<?php

namespace App\Http\Controllers\Support\Reports;

use App\Http\Controllers\Controller;
use App\Datatables\Support\Reports\ProductsWithoutSkuReportIndex;

class ProductsWithoutSkuReportController extends Controller
{
    public function index()
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(ProductsWithoutSkuReportIndex::class)->render();
        }

        return view('support.pages.reports.products-without-sku.index');
    }
}
