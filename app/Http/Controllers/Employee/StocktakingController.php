<?php

namespace App\Http\Controllers\Employee;

use App\Models\Shelf;
use App\Models\Stocktaking;
use Illuminate\Http\Request;
use App\Enums\StocktakingStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Datatables\Employee\StocktakingIndex;
use App\Datatables\Employee\StocktakingIssuesIndex;

class StocktakingController extends Controller
{
    public function index()
    {
        if (request()->expectsJson()) {
            return app(StocktakingIndex::class)->render();
        }

        $shelf = request('shelf_id') ? Shelf::find(request('shelf_id')) : null;

        return view('employee.pages.stocktakings.index', compact('shelf'));
    }

    public function show(Stocktaking $stocktaking)
    {
        abort_unless($stocktaking->shelf->employees->contains('id', auth('employee')->id()), 403);

        return view('employee.pages.stocktakings.show', compact('stocktaking'));
    }

    public function issues(Stocktaking $stocktaking)
    {
        if (! request()->expectsJson()) {
            abort(403);
        }

        return app(StocktakingIssuesIndex::class, ['stocktaking' => $stocktaking])->render();
    }

    public function create(Request $request)
    {
        abort_unless(filled($request->shelf_id), 404);

        $shelf = Shelf::find($request->shelf_id);

        $stocktaking = DB::transaction(function () use ($shelf) {
            $stocktaking = Stocktaking::create([
                'shelf_id' => $shelf->id,
                'employee_id' => auth('employee')->id(),
                'status' => StocktakingStatus::PENDING->value,
                'started_at' => now(),
            ]);

            // $shelf->products->each(function ($product) use ($stocktaking) {
            //     $stocktaking->products()->attach($product->id);
            // });

            return $stocktaking;
        });

        return redirect()->route('employee.stocktakings.process', ['stocktaking' => $stocktaking->id]);
    }

    public function process(Stocktaking $stocktaking)
    {
        abort_unless($stocktaking->isPending(), 403);

        $stocktaking->load([
            'products',
            'products.quantities' => fn($q) => $q->where('branch_id', $stocktaking->shelf->warehouse->branch_id),
        ]);

        return view('employee.pages.stocktakings.process', compact('stocktaking'));
    }
}
