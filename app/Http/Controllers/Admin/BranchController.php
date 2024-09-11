<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Datatables\Admin\BranchIndex;
use App\Http\Controllers\Concerns\Authorizable;
use App\Models\Branch;

class BranchController extends Controller
{
    use Authorizable;

    protected $permissionName = 'branches';

    public function index(): mixed
    {
        if (request()->expectsJson()) {
            return app(BranchIndex::class)->render();
        }

        return view('admin.pages.branches.index');
    }

    public function show(Branch $branch)
    {
        return view('admin.pages.branches.show', compact('branch'));
    }

    public function toggleActive(Branch $branch)
    {
        $branch->toggleActive();

        return response()->json([
            'success' => true,
            'message' => __('admin.branches.messages.' . ($branch->active ? 'activated' : 'deactivated')),
        ]);
    }
}
