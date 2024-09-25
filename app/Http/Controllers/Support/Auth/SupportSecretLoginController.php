<?php

namespace App\Http\Controllers\Support\Auth;

use App\Models\Support;
use App\Http\Controllers\Controller;

class SupportSecretLoginController extends Controller
{
    public function __invoke(Support $support)
    {
        if (config('app.staging') !== 'testing') {
            abort(404);
        }

        auth('web')->logout();
        auth('support')->logout();

        auth('support')->login($support, true);

        return redirect()->route('admin.home');
    }
}
