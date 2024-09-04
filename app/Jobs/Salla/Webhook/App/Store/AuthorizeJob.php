<?php

namespace App\Jobs\Salla\Webhook\App\Store;

use App\Enums\StoreProviderType;
use App\Enums\UserRole;
use App\Jobs\Concerns\InteractsWithException;
use App\Models\Store;
use App\Models\User;
use App\Services\Salla\OAuth\SallaOAuthService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Salla\OAuth2\Client\Provider\SallaUser;

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

                // $this->dispatchJobs(user: $user, store: $store);
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

        /*$user->notify(instance: new UserCreatedUsingSallaWebhook(
            email: $email,
            password: $userData['password'],
        ));*/

        // SendCreatedUserCredentialsViaWhatsappToMerchantJob::dispatch(
        //     mobile: $resourceOwner->getMobile(),
        //     email: $email,
        //     password: $userData['password'],
        // );

        /**
         * TEMP
         */
        // Mail::to(users: ['kareemmfouad.dev@gmail.com', 'altoama@outlook.com', 'abdelrahman.tarek@valinteca.com'])
        //     ->send(mailable: new UserCreatedUsingSallaWebhook(email: $email, password: $userData['password']));
        /**
         * END TEMP
         */

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

    // protected function dispatchJobs(User $user, Store $store): void
    // {
    //     PullStoreDataJob::dispatch(
    //         accessToken: $user->sallaToken->access_token,
    //         storeId: $store->id,
    //     );

    //     SendCreatedStoreDataViaWhatsappToAdminsJob::dispatch(
    //         userId: $user->id,
    //         storeId: $store->id,
    //         name: $store->name,
    //         mobile: $store->mobile,
    //         domain: $store->domain,
    //     );

    //     return;
    //     $sendStoreDataBatch = Bus::batch(new SendCreatedStoreDataViaWhatsappToAdminsJob(
    //         userId: $user->id,
    //         storeId: $store->id,
    //         name: $store->name,
    //         mobile: $store->mobile,
    //         domain: $store->domain,
    //     ));

    //     $orderStatusBatch = Bus::batch(new SallaPullOrderStatusesJob(
    //         accessToken: $user->sallaToken->access_token,
    //         storeId: $user->store->id,
    //     ))->name(name: "salla.pull.order-statuses:{$store->id}");

    //     $ordersBatch = Bus::batch(new SallaPullOrdersJob(
    //         accessToken: $user->sallaToken->access_token,
    //         storeId: $user->store->id,
    //     ))->name(name: "salla.pull.orders:{$store->id}");

    //     $orderHistoriesBatch = Bus::batch(new SallaPullOrdersHistoriesJob(
    //         accessToken: $user->sallaToken->access_token,
    //         storeId: $user->store->id,
    //     ))->name(name: "salla.pull.order-histories:{$store->id}");

    //     $couponsBatch = Bus::batch(new SallaPullCouponsJob(
    //         accessToken: $user->sallaToken->access_token,
    //         storeId: $user->store->id
    //     ))->name(name: "salla.pull.coupons:{$store->id}");

    //     $reviewsBatch = Bus::batch(new SallaPullReviewsJob(
    //         accessToken: $user->sallaToken->access_token,
    //         storeId: $user->store->id
    //     ))->name(name: "salla.pull.reviews:{$store->id}");

    //     $abandonedCartsBatch = Bus::batch(new SallaPullAbandonedCartsJob(
    //         accessToken: $user->sallaToken->access_token,
    //         storeId: $user->store->id
    //     ))->name(name: "salla.pull.abandoned-carts:{$store->id}");

    //     Bus::chain([
    //         $sendStoreDataBatch,
    //         $orderStatusBatch,
    //         $ordersBatch,
    //         $orderHistoriesBatch,
    //         $couponsBatch,
    //         $reviewsBatch,
    //         $abandonedCartsBatch,
    //     ])->dispatch();
    // }
}
