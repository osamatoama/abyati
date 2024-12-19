<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\Authorizable;
use App\Datatables\Admin\Reports\NearlyExpiredProductsIndex;

class NearlyExpiredProductsReportController extends Controller
{
    use Authorizable;

    protected $permissionName = 'nearly_expired_products_report';

    public function index()
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(NearlyExpiredProductsIndex::class)->render();
        }

        return view('admin.pages.reports.nearly-expired-products.index');
    }
}
