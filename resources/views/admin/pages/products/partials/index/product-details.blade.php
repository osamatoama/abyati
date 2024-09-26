<style>
    .fit-content-table {
        width: 100%;
        table-layout: auto;
    }

    .fit-content-table th {
        text-wrap: nowrap;
    }

    .fit-content-table td:last-child {
        width: 80%;
    }
</style>

<div class="card card-flush h-lg-100" id="kt_contacts_main">
    <div class="card-header" id="">
        <div class="card-title">
            <h2>{{ $product->name }}</h2>
        </div>
    </div>

    <div class="card-body pt-5">
        <div class="d-flex gap-7 align-items-center">
            <div class="symbol symbol-100px">
                @if(filled($product->main_image))
                    <img src="{{ $product->main_image }}" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('assets/client/media/placeholders/product.jpg') }}" alt="{{ $product->name }}">
                @endif
            </div>

            <div class="d-flex flex-column gap-2">
                @if(filled($product->type))
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-list"></i>
                        <a class="text-muted text-hover-primary" dir="ltr">{{ lang("products.types.{$product->type}") }}</a>
                    </div>
                @endif

                @if(filled($product->sku))
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-barcode"></i>
                        <a class="text-muted text-hover-primary" dir="ltr">{{ $product->sku }}</a>
                    </div>
                @endif

                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-store"></i>
                    <a href="#" class="text-muted text-hover-primary">{{ $product->store->name }}</a>
                </div>
            </div>
        </div>

        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x fs-6 fw-semibold mt-6 mb-8 gap-2" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-4 active" data-bs-toggle="tab" href="#product-details-price" aria-selected="true" role="tab">
                    <i class="fas fa-coins fs-4 me-2"></i>
                    {{ __('admin.products.attributes.price') }}
                </a>
            </li>

            <li class="nav-item" role="presentation">
                <a class="nav-link text-active-primary d-flex align-items-center pb-4" data-bs-toggle="tab" href="#product-details-variants" aria-selected="true" role="tab">
                    <i class="fas fa-box-open fs-4 me-2"></i>
                    {{ __('admin.products.attributes.variants') }}
                </a>
            </li>
        </ul>

        <div class="tab-content" id="">
            <div class="tab-pane fade show active" id="product-details-price" role="tabpanel">
                <div class="table-responsive">
                    <table class="table fit-content-table">
                        <tbody>
                            <tr>
                                <th class="fw-semibold">{{ __('admin.products.attributes.price') }}</th>
                                <td>{{ round($product->price) . ' ' . lang("currency.$product->currency") }}</td>
                            </tr>
    
                            <tr>
                                <th class="fw-semibold">{{ __('admin.products.attributes.regular_price') }}</th>
                                <td>{{ round($product->regular_price) . ' ' . lang("currency.$product->currency") }}</td>
                            </tr>
    
                            <tr>
                                <th class="fw-semibold">{{ __('admin.products.attributes.sale_price') }}</th>
                                <td>{{ round($product->sale_price) . ' ' . lang("currency.$product->currency") }}</td>
                            </tr>
    
                            @if($product->sale_end)
                                <tr>
                                    <th class="fw-semibold">{{ __('admin.products.attributes.sale_end') }}</th>
                                    <td>{{  $product->sale_end->format('Y-m-d') }}</td>
                                </tr>
                            @endif
    
                            <tr>
                                <th class="fw-semibold">{{ __('admin.products.attributes.with_tax') }}</th>
                                <td>{!! boolToYesNoSymbol($product->with_tax) !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="product-details-variants" role="tabpanel">
                @if($product->variants->count())
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('admin.products.attributes.variant') }}</th>
                                    <th>{{ __('admin.products.attributes.sku') }}</th>
                                    <th>{{ __('admin.products.attributes.barcode') }}</th>
                                    <th>{{ __('admin.products.attributes.quantity') }}</th>
                                    <th>{{ __('admin.products.attributes.price') }}</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @foreach($product->variants as $variant)
                                    <tr>
                                        <td>
                                            @foreach ($variant->optionValues as $optionValue)
                                                <span class="d-block">
                                                    {{ $optionValue->option->name . ': ' . $optionValue->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ filled($variant->sku) ? $variant->sku : '---' }}
                                        </td>
                                        <td>
                                            {{ filled($variant->barcode) ? $variant->barcode : '---' }}
                                        </td>
                                        <td>
                                            @if($product->unlimited_quantity)
                                                <span class="badge badge-warning">
                                                    {{ __('admin.products.messages.unlimited_quantity') }}
                                                </span>
                                            @else
                                                {{ $variant->stock_quantity }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ round($variant->price) . ' ' . lang("currency.$variant->currency") }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">
                        {{ __('admin.products.messages.no_variants') }}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
