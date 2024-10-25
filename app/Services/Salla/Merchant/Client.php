<?php

namespace App\Services\Salla\Merchant;

use App\Services\Salla\Client as BaseClient;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class Client extends BaseClient
{
    public function __construct(
        protected string $accessToken,
    ) {}

    /**
     * @throws SallaMerchantException
     */
    public function get(string $url, array $query = []): array
    {
        try {
            $response = $this->pendingRequest()->get(
                url: $url,
                query: $query,
            );
        } catch (ConnectionException $exception) {
            throw SallaMerchantException::connectionException(
                exception: $exception,
            );
        }

        $data = $response->json();

        $this->validateResponse(
            response: $response,
            data: $data,
        );

        return $data;
    }

    /**
     * @throws SallaMerchantException
     */
    public function post(string $url, array $data = []): array
    {
        try {
            $response = $this->pendingRequest()->post(
                url: $url,
                data: $data,
            );
        } catch (ConnectionException $exception) {
            throw SallaMerchantException::connectionException(
                exception: $exception,
            );
        }

        $data = $response->json();

        $this->validateResponse(
            response: $response,
            data: $data,
        );

        return $data;
    }

    /**
     * @throws SallaMerchantException
     */
    public function put(string $url, array $data = []): array
    {
        try {
            $response = $this->pendingRequest()->put(
                url: $url,
                data: $data,
            );
        } catch (ConnectionException $exception) {
            throw SallaMerchantException::connectionException(
                exception: $exception,
            );
        }

        $data = $response->json();

        $this->validateResponse(
            response: $response,
            data: $data,
        );

        return $data;
    }

    /**
     * @throws SallaMerchantException
     */
    public function patch(string $url, array $data = []): array
    {
        try {
            $response = $this->pendingRequest()->patch(
                url: $url,
                data: $data,
            );
        } catch (ConnectionException $exception) {
            throw SallaMerchantException::connectionException(
                exception: $exception,
            );
        }

        $data = $response->json();

        $this->validateResponse(
            response: $response,
            data: $data,
        );

        return $data;
    }

    /**
     * @throws SallaMerchantException
     */
    public function delete(string $url, array $data = []): array
    {
        try {
            $response = $this->pendingRequest()->delete(
                url: $url,
                data: $data,
            );
        } catch (ConnectionException $exception) {
            throw SallaMerchantException::connectionException(
                exception: $exception,
            );
        }

        $data = $response->json();

        $this->validateResponse(
            response: $response,
            data: $data,
        );

        return $data;
    }

    /**
     * @throws SallaMerchantException
     */
    public function validateResponse(Response $response, ?array $data): void
    {
        if ($response->failed()) {
            if ($data === null) {
                throw SallaMerchantException::fromNullData(
                    response: $response,
                );
            }

            if ($response->status() === 500) {
                throw SallaMerchantException::sallaServerError(
                    response: $response,
                    data: $data,
                );
            }

            if ($response->status() === 422) {
                throw SallaMerchantException::sallaValidationError(
                    response: $response,
                    data: $data,
                );
            }

            throw SallaMerchantException::fromResponse(
                response: $response,
                data: $data,
            );
        }
    }

    public function pendingRequest(): PendingRequest
    {
        return Http::withToken(
            token: $this->accessToken,
        )->acceptJson()->asJson();
    }
}
