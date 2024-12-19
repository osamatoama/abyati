@extends('employee.layouts.master')

@section('title',
    __('employee.stocktakings.title')
    . ($stocktaking->shelf ? ' - ' . __('employee.shelves.num_#', ['name' => $stocktaking->shelf->name]) : '')
    .  ' - ' . __('employee.stocktakings.num_#', ['name' => $stocktaking->id])
)

@section('actions')
    @include('employee.pages.stocktakings.partials.show.actions')
@endsection

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="stocktaking-issues-table" class="table table-hover table-row-bordered gy-5 gs-7"
                    data-url="{{ route('employee.stocktakings.issues', ['stocktaking' => $stocktaking->id]) }}"
                >
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800">
                            <th>#</th>
                            <th>{{ __('employee.stocktakings.issues.attributes.product') }}</th>
                            <th>{{ __('employee.stocktakings.issues.attributes.type') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('employee.pages.stocktakings.partials.show.after-scripts')
@endpush
