<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Datatables\Admin\EmployeeIndex;
use App\Http\Controllers\Concerns\Authorizable;
use App\Http\Requests\Admin\Employee\StoreEmployeeRequest;
use App\Http\Requests\Admin\Employee\DeleteEmployeeRequest;
use App\Http\Requests\Admin\Employee\UpdateEmployeeRequest;

class EmployeeController extends Controller
{
    use Authorizable;

    protected $permissionName = 'employees';

    protected $additionalAbilities = [];

    public function index()
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(EmployeeIndex::class)->render();
        }

        $branches = Branch::pluck('name', 'id');

        return view('admin.pages.employees.index', compact('branches'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $data = $request->validated();

        Employee::create($data);

        return response()->json([
            'success' => true,
            'message' => __('admin.employees.messages.created'),
            'data' => [],
        ]);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $data = $request->validated();

        $employee->update($data);

        return response()->json([
            'success' => true,
            'message' => __('admin.employees.messages.updated'),
            'data' => [],
        ]);
    }

    public function toggleActive(Employee $employee)
    {
        $employee->toggleActive();

        return response()->json([
            'success' => true,
            'message' => __('admin.employees.messages.' . ($employee->active ? 'activated' : 'deactivated')),
        ]);
    }

    public function destroy(DeleteEmployeeRequest $request, Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'success' => true,
            'message' => __('admin.employees.messages.deleted'),
        ]);
    }
}
