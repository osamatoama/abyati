<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\Authorizable;
use App\Datatables\Admin\Reports\ProductsWithoutShelvesIndex;

class ProductsWithoutShelvesReportController extends Controller
{
    use Authorizable;

    protected $permissionName = 'products_without_shevles_report';

    public function index()
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(ProductsWithoutShelvesIndex::class)->render();
        }

        return view('admin.pages.reports.products-without-shelves.index');
    }
}
