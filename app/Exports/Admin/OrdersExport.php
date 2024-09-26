<?php

namespace App\Exports\Admin;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class OrdersExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder
{
    public function __construct(
        private Builder $query
    )
    {
        //
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $orders = $this->query->get();

        return $orders->map(function ($order) {
            return [
                $order->reference_id,
                $order->store?->name,
                $order->customer_name,
                $order->date,
                $order->status->name,
                $order->completion_status->trans(),
                $order->employee?->name,
                $order->items_count,
                $order->total,
            ];
        });
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        return [
            __('admin.orders.attributes.order_number'),
            __('admin.orders.attributes.store'),
            __('admin.orders.attributes.customer'),
            __('admin.orders.attributes.date'),
            __('admin.orders.attributes.status'),
            __('admin.orders.attributes.completion_status'),
            __('admin.orders.attributes.employee'),
            __('admin.orders.attributes.items_count'),
            __('admin.orders.attributes.total'),
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
