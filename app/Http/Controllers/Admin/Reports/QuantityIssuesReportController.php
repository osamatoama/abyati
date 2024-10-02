<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\Authorizable;
use App\Datatables\Admin\Reports\QuantityIssuesIndex;

class QuantityIssuesReportController extends Controller
{
    use Authorizable;

    protected $permissionName = 'quantity_issues_report';

    public function index()
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(QuantityIssuesIndex::class)->render();
        }

        return view('admin.pages.reports.quantity-issues.index');
    }
}
