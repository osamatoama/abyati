<?php

namespace App\Http\Controllers\Employee;

use App\Models\Shelf;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Datatables\Employee\ShelfIndex;
use App\Datatables\Employee\ShelfProductsIndex;
use App\Http\Requests\Employee\Shelf\AttachProductRequest;
use App\Http\Requests\Employee\Shelf\BulkDetachProductsRequest;
use App\Http\Requests\Employee\Shelf\BulkTransferProductsRequest;

class ShelfController extends Controller
{
    public function index()
    {
        if (request()->expectsJson()) {
            return app(ShelfIndex::class)->render();
        }

        $warehouses = Warehouse::pluck('name', 'id');

        return view('employee.pages.shelves.index', compact('warehouses'));
    }

    public function show(Shelf $shelf)
    {
        abort_unless($shelf->employees->contains('id', auth('employee')->id()), 403);

        return view('employee.pages.shelves.show', compact('shelf'));
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
            'message' => __('employee.shelves.messages.product_attached'),
        ]);
    }

    public function detachProduct(Shelf $shelf, Product $product)
    {
        $shelf->products()->detach($product);

        return response()->json([
            'success' => true,
            'message' => __('employee.shelves.messages.product_detached'),
        ]);
    }

    public function bulkDetachProducts(Shelf $shelf, BulkDetachProductsRequest $request)
    {
        $data = $request->validated();

        $shelf->products()->detach($data['product_ids']);

        return response()->json([
            'success' => true,
            'message' => __('employee.shelves.messages.products_detached'),
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
            'message' => __('employee.shelves.messages.products_transferred'),
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
