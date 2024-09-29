<?php

namespace App\Http\Controllers\Support\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\Support\Auth\LoginRequest;

/**
 * Class LoginController
 * @package App\Http\Controllers\client\Authentication
 */
class LoginController extends Controller
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function showLoginForm()
    {
        return view('support.pages.auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'message' => __('support.auth.messages.logged_in'),
            'data' => [
                'redirect' => route('support.home'),
            ],
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        auth('support')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('support.login');
    }
}
