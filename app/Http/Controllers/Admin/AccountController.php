<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Employee;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $type = null;
        if ($user instanceof User) {
            $type = 'merchant';
        } elseif ($user instanceof Employee) {
            $type = 'employee';
        }

        if (! $type) {
            abort(404);
        }

        return view("client.account.$type", compact('user'));
    }
}
