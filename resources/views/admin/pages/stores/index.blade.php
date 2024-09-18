@extends('admin.layouts.master')

@section('title', __('admin.stores.title'))

@section('content')
    <div class="card">
        <div class="card-body">
            <table id="results-table" class="table table-hover table-row-bordered gy-5 gs-7"
                data-url="{{ route('admin.stores.index')}}"
            >
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800">
                        <th>#</th>
                        <th>{{ __('admin.stores.attributes.name') }}</th>
                        <th>{{ __('admin.stores.attributes.domain') }}</th>
                        <th>{{ __('admin.stores.attributes.id_color') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('afterScripts')
    @include('admin.pages.stores.partials.index.after-scripts')
@endpush
