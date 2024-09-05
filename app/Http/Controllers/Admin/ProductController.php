<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Datatables\Admin\ProductIndex;
use App\Http\Controllers\Concerns\Authorizable;

class ProductController extends Controller
{
    use Authorizable;

    protected $permissionName = 'products';

    public function index(): mixed
    {
        if (request()->expectsJson()) {
            return app(ProductIndex::class)->render();
        }

        return view('admin.pages.products.index');
    }

    public function show(Product $product)
    {
        $product->load([
            'variants' => function ($query) {
                $query->select('*');
            },
            'variants.optionValues' => function ($query) {
                return $query->select('option_values.id', 'option_values.option_id', 'name');
            },
            'variants.optionValues.option' => function ($query) {
                return $query->select('options.id', 'name');
            },
        ]);

        return response()->json([
            'success' => true,
            'message' => 'fetched successfully',
            'data' => [
                'title' => __('products.details'),
                'html' => view('admin.pages.products.partials.index.product-details', compact('product'))->render(),
            ],
        ]);
    }
}
