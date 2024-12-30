<?php

namespace App\Http\Controllers\Employee\Reports;

use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        return view('employee.pages.reports.index');
    }
}
