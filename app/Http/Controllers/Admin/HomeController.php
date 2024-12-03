<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Support;
use App\Models\Employee;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke()
    {
        $statistics = collect([]);

        $statistics->put('orders_count', Order::query()->readyForProcessing()->count());
        $statistics->put('employees_count', Employee::query()->count());
        $statistics->put('supports_count', Support::query()->count());

        return view('admin.pages.home.index', compact('statistics'));
    }
}
