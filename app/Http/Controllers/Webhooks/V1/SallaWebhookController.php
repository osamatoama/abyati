<?php

namespace App\Http\Controllers\Webhooks\V1;

use Throwable;
use App\Dto\WebhookDto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Webhooks\WebhookService;
use App\Services\Salla\Webhook\SallaWebhookHandler;

class SallaWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, SallaWebhookHandler $sallaWebhooksHandler): void
    {
        try {
            WebhookService::instance()
                ->create(
                    webhookDto: WebhookDto::fromSalla(
                        headers: $request->header(),
                        payload: $request->all(),
                    ),
                );
        } catch (Throwable $th) {
            logger()->error($th->getMessage());
        }

        // if ($sallaWebhooksHandler->isNotVerified($request->header('Authorization', ''))) {
        //     return;
        // }

        $sallaWebhooksHandler->handle(
            event: $request->input('event'),
            merchantId: $request->input('merchant'),
            data: $request->input('data'),
        );
    }
}
