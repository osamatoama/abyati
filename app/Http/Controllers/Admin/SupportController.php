<?php

namespace App\Http\Controllers\Admin;

use App\Models\Support;
use App\Http\Controllers\Controller;
use App\Datatables\Admin\SupportIndex;
use App\Http\Controllers\Concerns\Authorizable;
use App\Http\Requests\Admin\Support\StoreSupportRequest;
use App\Http\Requests\Admin\Support\DeleteSupportRequest;
use App\Http\Requests\Admin\Support\UpdateSupportRequest;

class SupportController extends Controller
{
    use Authorizable;

    protected $permissionName = 'supports';

    protected $additionalAbilities = [];

    public function index()
    {
        if (request()->ajax() or request()->expectsJson()) {
            return app(SupportIndex::class)->render();
        }

        return view('admin.pages.supports.index');
    }

    public function store(StoreSupportRequest $request)
    {
        $data = $request->validated();

        Support::create($data);

        return response()->json([
            'success' => true,
            'message' => __('admin.supports.messages.created'),
            'data' => [],
        ]);
    }

    public function update(UpdateSupportRequest $request, Support $support)
    {
        $data = $request->validated();

        $support->update($data);

        return response()->json([
            'success' => true,
            'message' => __('admin.supports.messages.updated'),
            'data' => [],
        ]);
    }

    public function toggleActive(Support $support)
    {
        $support->toggleActive();

        return response()->json([
            'success' => true,
            'message' => __('admin.supports.messages.' . ($support->active ? 'activated' : 'deactivated')),
        ]);
    }

    public function destroy(DeleteSupportRequest $request, Support $support)
    {
        $support->delete();

        return response()->json([
            'success' => true,
            'message' => __('admin.supports.messages.deleted'),
        ]);
    }
}
