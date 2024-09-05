<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function __invoke()
    {
        $statistics = collect([]);

        // if (user() instanceof Employee) {
        //     $user = User::find(user()->user_id);
        //     $statistics->put('orders_count', $user->orders()->count());
        //     $statistics->put('return_requests_count', $user->returnRequests()->count());
        //     $statistics->put('exchange_requests_count', $user->exchangeRequests()->count());
        // } else {

        //     $statistics->put('orders_count', user()->orders()->count());
        //     $statistics->put('return_requests_count', user()->returnRequests()->count());
        //     $statistics->put('exchange_requests_count', user()->exchangeRequests()->count());
        // }


        return view('admin.pages.home.index', compact('statistics'));
    }
}
