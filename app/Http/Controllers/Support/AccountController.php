<?php

namespace App\Http\Controllers\Support;

use App\Models\User;
use App\Models\Support;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $type = null;
        if ($user instanceof User) {
            $type = 'merchant';
        } elseif ($user instanceof Support) {
            $type = 'support';
        }

        if (! $type) {
            abort(404);
        }

        return view("client.account.$type", compact('user'));
    }
}
