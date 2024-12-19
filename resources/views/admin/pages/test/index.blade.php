@extends('admin.layouts.master')

@section('title', 'Test')

@section('content')
    @php
        $barcode = \App\Models\Product::whereNotNull('sku')->first()->sku;
    @endphp

    <div class="card">
        <div class="card-body">
            <div class="mb-5">
                {!! $barcode !!}
            </div>

            <div class="mb-5">
                {!! generateBarcode($barcode) !!}
            </div>

            <div class="mb-5">
                {!! generateBarcode2($barcode) !!}
            </div>

            <div class="mb-5">
                <span>
                    {!! generateSvgBarcode($barcode) !!}
                    <span>{{ $barcode }}</span>
                </span>
            </div>
        </div>
    </div>
@endsection

@push('afterScripts')
<script>

</script>
@endpush
