<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function __invoke()
    {
        return view('admin.pages.test.index');
    }
}
