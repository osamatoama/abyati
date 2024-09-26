<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cookie;

class LocaleController extends Controller
{

    public function change($locale = 'ar')
    {
        session()->put('locale', $locale);
        Cookie::queue('locale', $locale);

        return back();
    }
}
