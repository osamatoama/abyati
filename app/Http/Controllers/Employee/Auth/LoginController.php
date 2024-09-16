<?php

namespace App\Http\Controllers\Employee\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\Employee\Auth\LoginRequest;
use Illuminate\Contracts\Foundation\Application;

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
        return view('employee.pages.auth.login');
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
            'message' => __('employee.auth.messages.logged_in'),
            'data' => [
                'redirect' => $request->session()->get('url.intended') ?? route('employee.home'),
            ],
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('employee.login');
    }
}
