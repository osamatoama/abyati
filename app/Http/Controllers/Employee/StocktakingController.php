<?php

namespace App\Http\Controllers\Employee;

use App\Models\Shelf;
use App\Models\Stocktaking;
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
}
