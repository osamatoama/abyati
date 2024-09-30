<?php

namespace App\Http\Controllers\Admin\Reports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Concerns\Authorizable;
use App\Datatables\Admin\Reports\EmployeePerformanceIndex;

class EmployeePerformanceReportController extends Controller
{
    use Authorizable;

    protected $permissionName = 'employee_performance_report';

    public function index()
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(EmployeePerformanceIndex::class)->render();
        }

        return view('admin.pages.reports.employee-performance.index');
    }
}
