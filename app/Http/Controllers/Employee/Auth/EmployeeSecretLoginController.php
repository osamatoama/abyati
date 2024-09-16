<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Models\Employee;
use App\Http\Controllers\Controller;

class EmployeeSecretLoginController extends Controller
{
    public function __invoke(Employee $employee)
    {
        if (config('app.staging') !== 'testing') {
            abort(404);
        }

        auth('web')->logout();
        auth('employee')->logout();

        auth('employee')->login($employee, true);

        return redirect()->route('admin.home');
    }
}
