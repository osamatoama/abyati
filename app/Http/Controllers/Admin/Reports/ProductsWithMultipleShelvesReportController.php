<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\Authorizable;
use App\Datatables\Admin\Reports\ProductsWithMultipleShelvesIndex;

class ProductsWithMultipleShelvesReportController extends Controller
{
    use Authorizable;

    protected $permissionName = 'products_with_multiple_shevles_report';

    public function index()
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(ProductsWithMultipleShelvesIndex::class)->render();
        }

        return view('admin.pages.reports.products-with-multiple-shelves.index');
    }
}
