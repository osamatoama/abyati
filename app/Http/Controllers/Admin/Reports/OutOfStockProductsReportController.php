<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\Authorizable;
use App\Datatables\Admin\Reports\OutOfStockProductsIndex;

class OutOfStockProductsReportController extends Controller
{
    use Authorizable;

    protected $permissionName = 'out_of_stock_products_report';

    public function index()
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(OutOfStockProductsIndex::class)->render();
        }

        return view('admin.pages.reports.out-of-stock-products.index');
    }
}
