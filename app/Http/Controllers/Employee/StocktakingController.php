<?php

namespace App\Http\Controllers\Employee;

use App\Models\Shelf;
use App\Http\Controllers\Controller;
use App\Datatables\Employee\StocktakingIndex;

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
}
