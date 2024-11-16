<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shelf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Datatables\Admin\ShelfIndex;
use App\Datatables\Admin\ShelfProductsIndex;
use App\Http\Controllers\Concerns\Authorizable;
use App\Http\Requests\Admin\Shelf\DeleteShelfRequest;

class ShelfController extends Controller
{
    use Authorizable;

    protected $permissionName = 'shelves';

    public function index()
    {
        if (request()->expectsJson()) {
            return app(ShelfIndex::class)->render();
        }

        return view('admin.pages.shelves.index');
    }

    public function show(Shelf $shelf)
    {
        return view('admin.pages.shelves.show', compact('shelf'));
    }

    public function products(Shelf $shelf)
    {
        if (! request()->expectsJson()) {
            abort(403);
        }

        return app(ShelfProductsIndex::class, ['shelf' => $shelf])->render();
    }

    public function create()
    {
        return view('admin.pages.shelves.create');
    }

    public function edit(Shelf $shelf)
    {
        return view('admin.pages.shelves.edit', compact('shelf'));
    }

    public function toggleActive(Shelf $shelf)
    {
        $shelf->toggleActive();

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.' . ($shelf->active ? 'activated' : 'deactivated')),
        ]);
    }

    public function destroy(DeleteShelfRequest $request, Shelf $shelf)
    {
        DB::transaction(function () use ($shelf) {
            $shelf->orderStatuses()->sync([]);
            $shelf->delete();
        });

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.deleted'),
        ]);
    }
}
