<?php

namespace App\Jobs\Salla\Webhook\App\Store;

use Exception;
use App\Models\User;
use App\Models\Store;
use App\Enums\UserRole;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use App\Enums\StoreProviderType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Bus;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Salla\OAuth2\Client\Provider\SallaUser;
use App\Jobs\Concerns\InteractsWithException;
use App\Jobs\Salla\Pull\Orders\PullOrdersJob;
use App\Services\Salla\OAuth\SallaOAuthService;
use App\Jobs\Salla\Pull\Products\PullProductsJob;
use App\Jobs\Salla\Pull\OrderStatuses\PullOrderStatusesJob;

class AuthorizeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithException, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $merchantId,
        public array $data,
    ) {
        $this->maxAttempts = 1;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            logger()->debug('AuthorizeJob dispatched');

            $store = Store::query()->salla(providerId: $this->merchantId)->first();
            if ($store !== null) {
                $this->syncToken(user: $store->user);

                return;
            }

            try {
                $resourceOwner = (new SallaOAuthService())->getResourceOwner(accessToken: $this->data['access_token']);

                $email = $resourceOwner->getEmail();

                $user = User::where(column: 'email', operator: '=', value: $email)->firstOr(
                    callback: fn (): User => $this->createUser(resourceOwner: $resourceOwner, email: $email),
                );

                $store = DB::transaction(callback: function () use ($resourceOwner, $user): Store {
                    $this->syncToken(user: $user);

                    return $this->createStore(user: $user, resourceOwner: $resourceOwner);
                });

                $this->dispatchJobs(user: $user, store: $store);
            } catch (Exception $e) {
                $this->fail(exception: $e);

                logger()->error($e);
            }
        } catch (Exception $exception) {
            $this->handleException(
                exception: $exception,
            );
        }
    }

    protected function createUser(SallaUser $resourceOwner, string $email): User
    {
        $userData = DB::transaction(
            callback: function () use ($resourceOwner, $email): array {
                $password = Str::password();

                $user = User::query()->create(
                    attributes: [
                        'name' => $resourceOwner->getName(),
                        'email' => $email,
                        'password' => $password,
                    ],
                );

                $user->assignRole(
                    role: UserRole::MERCHANT->asModel(),
                );

                return [
                    'user' => $user,
                    'password' => $password,
                ];
            },
        );

        $user = $userData['user'];

        return $user;
    }

    protected function syncToken(User $user): void
    {
        $user->providerTokens()->updateOrCreate(attributes: [
            'provider_type' => StoreProviderType::SALLA,
        ], values: [
            'access_token' => $this->data['access_token'],
            'refresh_token' => $this->data['refresh_token'],
            'expired_at' => $this->data['expires'],
        ]);
    }

    /**
     * @throws Exception
     */
    protected function createStore(User $user, SallaUser $resourceOwner): Store
    {
        $data = $resourceOwner->toArray();

        return $user->store()->create(attributes: [
            'provider_type' => StoreProviderType::SALLA,
            'provider_id' => $data['merchant']['id'],
            'name' => $data['merchant']['name'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'domain' => $data['merchant']['domain'],
        ]);
    }

    protected function dispatchJobs(User $user, Store $store): void
    {
        $jobs = [];

        $jobs[] = new PullProductsJob(
            accessToken: $user->sallaToken->access_token,
            storeId: $user->store->id,
        );

        $jobs[] = new PullOrderStatusesJob(
            accessToken: $user->sallaToken->access_token,
            storeId: $user->store->id,
        );

        $jobs[] = new PullOrdersJob(
            accessToken: $user->sallaToken->access_token,
            storeId: $user->store->id,
        );

        Bus::chain($jobs)->dispatch();
    }
}
