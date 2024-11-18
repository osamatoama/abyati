<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shelf;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use App\Datatables\Admin\ShelfIndex;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Datatables\Admin\ShelfProductsIndex;
use App\Http\Controllers\Concerns\Authorizable;
use App\Http\Requests\Admin\Shelf\ImportRequest;
use App\Imports\Admin\Shelf\WarehouseProductsImport;
use App\Http\Requests\Admin\Shelf\DeleteShelfRequest;
use App\Http\Requests\Admin\Shelf\AttachProductRequest;

class ShelfController extends Controller
{
    use Authorizable;

    protected $permissionName = 'shelves';

    public function index()
    {
        if (request()->expectsJson()) {
            return app(ShelfIndex::class)->render();
        }

        $warehouses = Warehouse::pluck('name', 'id');

        return view('admin.pages.shelves.index', compact('warehouses'));
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

    public function attachProduct(Shelf $shelf, AttachProductRequest $request)
    {
        $data = $request->validated();

        $shelf->products()->syncWithoutDetaching($data['product_ids'] ?? []);

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.product_attached'),
        ]);
    }

    public function detachProduct(Shelf $shelf, Product $product)
    {
        $shelf->products()->detach($product);

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.product_detached'),
        ]);
    }

    public function import(ImportRequest $request)
    {
        $data = $request->validated();

        $file = Storage::disk('local')->putFile('imports', $data['file']);

        Excel::import(
            import: new WarehouseProductsImport(
                warehouse: Warehouse::find($data['warehouse_id']),
            ),
            filePath: storage_path('app/' . $file),
        );

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.import_started'),
            'data' => [],
        ]);
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
