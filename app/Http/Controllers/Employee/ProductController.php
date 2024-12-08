<?php

namespace App\Http\Controllers\Employee;

use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function select()
    {
        if (! request()->expectsJson()) {
            abort(404);
        }

        $products = Product::select('id', 'name', 'sku')
            ->when(request()->keyword, function ($q) {
                return $q->where(function($q) {
                    return $q->where('name', 'LIKE', "%" . request()->keyword . "%")
                        ->orWhere('sku', 'LIKE', "%" . request()->keyword . "%");
                });
            })
            ->take(10)
            ->get();

        return response()->json([
            'success' => __('general.success.fetched'),
            'data'    => $products,
        ], 200);
    }
}
