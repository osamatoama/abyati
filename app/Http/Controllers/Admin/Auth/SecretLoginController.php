<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;

class SecretLoginController extends Controller
{
    public function __invoke(?User $user)
    {
        if (config('app.staging') !== 'testing') {
            abort(404);
        }

        auth('web')->logout();
        auth('employee')->logout();

        auth('web')->login($user ?? User::first(), true);

        return redirect()->route('admin.home');
    }
}
