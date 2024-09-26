<?php

namespace App\Http\Controllers\Admin;

use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Datatables\Admin\BranchIndex;
use App\Http\Controllers\Concerns\Authorizable;
use App\Http\Requests\Admin\Branch\DeleteBranchRequest;

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

    public function create()
    {
        return view('admin.pages.branches.create');
    }

    public function edit(Branch $branch)
    {
        return view('admin.pages.branches.edit', compact('branch'));
    }

    public function toggleActive(Branch $branch)
    {
        $branch->toggleActive();

        return response()->json([
            'success' => true,
            'message' => __('admin.branches.messages.' . ($branch->active ? 'activated' : 'deactivated')),
        ]);
    }

    public function destroy(DeleteBranchRequest $request, Branch $branch)
    {
        DB::transaction(function () use ($branch) {
            $branch->orderStatuses()->sync([]);
            $branch->delete();
        });

        return response()->json([
            'success' => true,
            'message' => __('admin.branches.messages.deleted'),
        ]);
    }
}
