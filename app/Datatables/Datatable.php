<?php

namespace App\Datatables;

use Yajra\DataTables\Exceptions\Exception;

/**
 * Class Datatable
 *
 * @package Modules\Core\Classes
 */
abstract class Datatable
{

    /**
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    abstract public function query();

    /**
     * @return mixed
     *
     * @throws \Exception
     */
    public function render()
    {
        $datatable = app('datatables');

        $datatable = $datatable->of($this->query())->addIndexColumn();

        foreach ($this->addColumns() as $key => $value) {
            $datatable = $datatable->addColumn($key, $value);
        }

        foreach ($this->editColumns() as $key => $value) {
            $datatable = $datatable->editColumn($key, $value);
        }

        foreach ($this->filterColumns() as $key => $value) {
            $datatable = $datatable->filterColumn($key, $value);
        }

        foreach ($this->orderColumns() as $key => $value) {
            $datatable = $datatable->orderColumn($key, $value);
        }

        return $datatable->make(true);
    }

    /**
     * For adding column to datatable
     *
     * @return array
     */
    protected function addColumns()
    {
        return [];
    }

    /**
     * For edit column in the datatable
     *
     * @return array
     */
    protected function editColumns()
    {
        return [];
    }

    /**
     * For filtering columns in the datatable
     *
     * @return array
     */
    protected function filterColumns()
    {
        return [];
    }

    /**
     * For ordering columns in the datatable
     *
     * @return array
     */
    protected function orderColumns()
    {
        return [];
    }
}
