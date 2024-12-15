<?php

namespace App\Datatables\Employee;

use App\Models\Stocktaking;
use App\Datatables\Datatable;
use App\Models\StocktakingIssue;
use Illuminate\Database\Eloquent\Builder;

class StocktakingIssuesIndex extends Datatable
{
    public function __construct(
        private Stocktaking $stocktaking,
    )
    {
        //
    }

    /**
     * @return Builder|mixed
     */
    public function query()
    {
        return StocktakingIssue::query()
            // ->filter()
            // ->forEmployee(auth('employee')->id())
            ->forStocktaking($this->stocktaking)
            ->whereHas('stocktaking.shelf', fn ($q) =>
                $q->forEmployee(auth('employee')->id())
            )
            ->with([
                'product',
            ]);
    }

    /**
     * For adding column to datatable
     */
    protected function addColumns(): array
    {
        return [
            'product' => function (StocktakingIssue $issue) {
                return view('employee.pages.stocktakings.partials.show.issues.cols.product', compact('issue'));
            },
            'action' => function (StocktakingIssue $issue) {
                return view('employee.pages.stocktakings.partials.show.issues.cols.actions', compact('issue'));
            }
        ];
    }

    /**
     * For edit column in the datatable
     */
    public function editColumns(): array
    {
        return [
            'id' => function (StocktakingIssue $issue) {
                return view('employee.pages.stocktakings.partials.show.issues.cols.id', compact('issue'));
            },
            'type' => function (StocktakingIssue $issue) {
                return view('employee.pages.stocktakings.partials.show.issues.cols.type', compact('issue'));
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
