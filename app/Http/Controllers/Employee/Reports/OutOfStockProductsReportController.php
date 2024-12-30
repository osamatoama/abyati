<?php

namespace App\Http\Controllers\Employee\Reports;

use App\Enums\EmployeeRole;
use App\Http\Controllers\Controller;
use App\Datatables\Employee\Reports\OutOfStockProductsIndex;

class OutOfStockProductsReportController extends Controller
{
    public function index()
    {
        abort_unless(auth('employee')->user()?->hasRole(EmployeeRole::STOCKTAKING), 403);

        if (request()->ajax() or request()->expectsJson()) {
            return app(OutOfStockProductsIndex::class)->render();
        }

        return view('employee.pages.reports.out-of-stock-products.index');
    }
}
