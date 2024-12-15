<?php

namespace App\Datatables\Employee;

use App\Models\Stocktaking;
use App\Datatables\Datatable;
use Illuminate\Database\Eloquent\Builder;

class StocktakingIndex extends Datatable
{
    /**
     * @return Builder|mixed
     */
    public function query()
    {
        $shelfId = request('shelf_id');

        return Stocktaking::query()
            // ->filter()
            // ->forEmployee(auth('employee')->id())
            ->whereHas('shelf', function ($query) {
                $query->forEmployee(auth('employee')->id());
            })
            ->when($shelfId, fn ($query) =>
                $query->forShelf($shelfId)
            )
            ->with([
                'shelf',
                'employee',
            ])
            ->withCount([
                'issues',
            ]);
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            'shelf' => function (Stocktaking $stocktaking) {
                return view('employee.pages.stocktakings.partials.index.cols.shelf', compact('stocktaking'));
            },
            'employee' => function (Stocktaking $stocktaking) {
                return view('employee.pages.stocktakings.partials.index.cols.employee', compact('stocktaking'));
            },
            'action' => function (Stocktaking $stocktaking) {
                return view('employee.pages.stocktakings.partials.index.cols.actions', compact('stocktaking'));
            }
        ];
    }

    /**
     * For edit column in the datatable
     */
    public function editColumns(): array
    {
        return [
            'id' => function (Stocktaking $stocktaking) {
                return view('employee.pages.stocktakings.partials.index.cols.id', compact('stocktaking'));
            },
            'audited_at' => function (Stocktaking $stocktaking) {
                return view('employee.pages.stocktakings.partials.index.cols.audited_at', compact('stocktaking'));
            },
            'issues_count' => function (Stocktaking $stocktaking) {
                return view('employee.pages.stocktakings.partials.index.cols.issues_count', compact('stocktaking'));
            },
        ];
    }

    /**
     * For filtering columns in the datatable
     */
    protected function filterColumns(): array
    {
        return [
            // 'name' => function ($query, $keyword) {
            //     $query->where('name', '=', $keyword);
            // },
        ];
    }
}
