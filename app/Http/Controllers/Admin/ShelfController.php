<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shelf;
use App\Models\Product;
use App\Models\Employee;
use App\Models\Warehouse;
use App\Enums\EmployeeRole;
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
use App\Http\Requests\Admin\Shelf\BulkDetachProductsRequest;
use App\Http\Requests\Admin\Shelf\Import\ImportAisleRequest;
use App\Http\Requests\Admin\Shelf\Import\ImportShelfRequest;
use App\Http\Requests\Admin\Shelf\BulkTransferProductsRequest;
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
        $stocktakingEmployees = Employee::select('id', 'name', 'email')
            ->role(EmployeeRole::STOCKTAKING)
            ->get();

        return view('admin.pages.shelves.index', compact('warehouses', 'stocktakingEmployees'));
    }

    public function show(Shelf $shelf)
    {
        return view('admin.pages.shelves.show', compact('shelf'));
    }

    public function store(StoreShelfRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($data) {
            $shelf = Shelf::create($data);

            if (! empty($data['employee_ids'])) {
                $shelf->employees()->sync($data['employee_ids']);
            }
        });

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.created'),
            'data' => [],
        ]);
    }

    public function update(Shelf $shelf, UpdateShelfRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function () use ($shelf, $data) {
            $shelf->update($data);

            if (! empty($data['employee_ids'])) {
                $shelf->employees()->sync($data['employee_ids']);
            }
        });

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.updated'),
            'data' => [],
        ]);
    }

    public function destroy(DeleteShelfRequest $request, Shelf $shelf)
    {
        DB::transaction(function () use ($shelf) {
            $shelf->employees()->sync([]);
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

    public function bulkDetachProducts(Shelf $shelf, BulkDetachProductsRequest $request)
    {
        $data = $request->validated();

        $shelf->products()->detach($data['product_ids']);

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.products_detached'),
        ]);
    }

    public function bulkTransferProducts(Shelf $shelf, BulkTransferProductsRequest $request)
    {
        $data = $request->validated();
        $destinationShelf = Shelf::findOrFail($data['shelf_id']);

        DB::transaction(function () use ($shelf, $destinationShelf, $data) {
            $shelf->products()->detach($data['product_ids']);
            $destinationShelf->products()->syncWithoutDetaching($data['product_ids']);
        });

        return response()->json([
            'success' => true,
            'message' => __('admin.shelves.messages.products_transferred'),
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
            ->when(request()->aisle, function ($q) {
                return $q->where('aisle', request()->aisle);
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
