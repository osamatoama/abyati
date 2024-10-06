<?php

namespace App\Http\Controllers\Support\Reports;

use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index()
    {
        return view('support.pages.reports.index');
    }
}
