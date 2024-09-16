<?php

namespace App\Http\Controllers\Employee\Auth;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Requests\Client\Auth\ResetPasswordRequest;

/**
 * Class ResetPasswordController
 * @package App\Http\Controllers\client\Authentication
 */
class ResetPasswordController extends Controller
{
    public function reset(ResetPasswordRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();

        $user->update([
            'password' => Hash::make($data['new_password']),
            'remember_token' => Str::random(60),
        ]);

        event(new PasswordReset($user));
        auth()->logout();

        return response()->json([
            'success' => true,
            'message' => __('account.messages.password_reset'),
            'data' => [
                'redirect' => route('admin.login'),
            ],
        ]);
    }
}
