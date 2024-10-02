<?php

namespace App\Http\Controllers\Webhooks\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Salla\Webhook\SallaWebhookHandler;

class SallaWebhookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, SallaWebhookHandler $sallaWebhooksHandler): void
    {
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
