<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use App\Http\Controllers\Controller;
use App\Datatables\Admin\StoreIndex;
use App\Http\Controllers\Concerns\Authorizable;
use App\Http\Requests\Admin\Store\UpdateStoreRequest;

class StoreController extends Controller
{
    use Authorizable;

    protected $permissionName = 'stores';

    public function index(): mixed
    {
        if (request()->expectsJson()) {
            return app(StoreIndex::class)->render();
        }

        return view('admin.pages.stores.index');
    }

    public function update(UpdateStoreRequest $request, Store $store)
    {
        $data = $request->validated();

        $store->update($data);

        cache()->forget(Store::CACHE_STORES_ID_COLORS_KEY);

        return response()->json([
            'success' => true,
            'message' => __('admin.stores.messages.updated'),
        ]);
    }

    // public function toggleActive(Store $store)
    // {
    //     $store->toggleActive();

    //     return response()->json([
    //         'success' => true,
    //         'message' => __('admin.stores.messages.' . ($store->active ? 'activated' : 'deactivated')),
    //     ]);
    // }
}
