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
use App\Imports\Admin\Shelf\AisleProductsImport;
use App\Imports\Admin\Shelf\ShelfProductsImport;
use App\Http\Requests\Admin\Shelf\StoreShelfRequest;
use App\Imports\Admin\Shelf\WarehouseProductsImport;
use App\Http\Requests\Admin\Shelf\DeleteShelfRequest;
use App\Http\Requests\Admin\Shelf\UpdateShelfRequest;
use App\Http\Requests\Admin\Shelf\AttachProductRequest;
use App\Http\Requests\Admin\Shelf\Import\ImportAisleRequest;
use App\Http\Requests\Admin\Shelf\Import\ImportShelfRequest;
use App\Http\Requests\Admin\Shelf\Import\ImportWarehouseRequest;

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

    public function store(StoreShelfRequest $request)
    {
        $data = $request->validated();

        Shelf::create($data);

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.created'),
            'data' => [],
        ]);
    }

    public function update(Shelf $shelf, UpdateShelfRequest $request)
    {
        $data = $request->validated();

        $shelf->update($data);

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.updated'),
            'data' => [],
        ]);
    }

    public function destroy(DeleteShelfRequest $request, Shelf $shelf)
    {
        DB::transaction(function () use ($shelf) {
            $shelf->products()->sync([]);
            $shelf->delete();
        });

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.deleted'),
        ]);
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

    public function importWarehouse(ImportWarehouseRequest $request)
    {
        $data = $request->validated();
        $importFailed = false;

        $file = Storage::disk('local')->putFile('imports', $data['file']);

        try {
            Excel::import(
                import: new WarehouseProductsImport(
                    warehouse: Warehouse::find($data['warehouse_id']),
                ),
                filePath: storage_path('app/' . $file),
            );

        } catch (\Exception $e) {
            logger()->error($e);

            $importFailed = true;
        }

        Storage::disk('local')->delete($file);

        if ($importFailed) {
            return response()->json([
                'success' => false,
                'message' => __('globals.errors.something_went_wrong'),
                'data' => [],
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.imported'),
            'data' => [],
        ]);
    }

    public function importAisle(ImportAisleRequest $request)
    {
        $data = $request->validated();
        $importFailed = false;

        $file = Storage::disk('local')->putFile('imports', $data['file']);

        try {
            Excel::import(
                import: new AisleProductsImport(
                    warehouse: Warehouse::find($data['warehouse_id']),
                    aisle: $data['aisle'],
                ),
                filePath: storage_path('app/' . $file),
            );

        } catch (\Exception $e) {
            logger()->error($e);

            $importFailed = true;
        }

        Storage::disk('local')->delete($file);

        if ($importFailed) {
            return response()->json([
                'success' => false,
                'message' => __('globals.errors.something_went_wrong'),
                'data' => [],
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.imported'),
            'data' => [],
        ]);
    }

    public function importShelf(ImportShelfRequest $request)
    {
        $data = $request->validated();
        $importFailed = false;

        $file = Storage::disk('local')->putFile('imports', $data['file']);

        try {
            Excel::import(
                import: new ShelfProductsImport(
                    warehouse: Warehouse::find($data['warehouse_id']),
                    shelf: Shelf::find($data['shelf_id']),
                ),
                filePath: storage_path('app/' . $file),
            );

        } catch (\Exception $e) {
            logger()->error($e);

            $importFailed = true;
        }

        Storage::disk('local')->delete($file);

        if ($importFailed) {
            return response()->json([
                'success' => false,
                'message' => __('globals.errors.something_went_wrong'),
                'data' => [],
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.imported'),
            'data' => [],
        ]);
    }

    public function toggleActive(Shelf $shelf)
    {
        $shelf->toggleActive();

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.' . ($shelf->active ? 'activated' : 'deactivated')),
        ]);
    }

    public function select()
    {
        if (! request()->expectsJson()) {
            abort(404);
        }

        $shelves = Shelf::select('id', 'warehouse_id', 'name')
            ->when(request()->warehouse_id, function ($q) {
                return $q->where('warehouse_id', request()->warehouse_id);
            })
            ->get();

        return response()->json([
            'success' => __('general.success.fetched'),
            'data'    => $shelves,
        ], 200);
    }

    public function selectAisles()
    {
        if (! request()->expectsJson()) {
            abort(404);
        }

        $aisles = Shelf::select('aisle')
            ->distinct('aisle')
            ->when(request()->warehouse_id, function ($q) {
                return $q->where('warehouse_id', request()->warehouse_id);
            })
            ->get();

        return response()->json([
            'success' => __('general.success.fetched'),
            'data'    => $aisles,
        ], 200);
    }
}
