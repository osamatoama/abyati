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
                        <a class="text-muted text-hover-primary" dir="ltr">{{ lang("admin.products.types.{$product->type}") }}</a>
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

            @if($product->isGroup())
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-active-primary d-flex align-items-center pb-4" data-bs-toggle="tab" href="#product-details-consisted" aria-selected="true" role="tab">
                        <i class="fas fa-box-open fs-4 me-2"></i>
                        {{ __('admin.products.attributes.consisted_products') }}
                    </a>
                </li>
            @endif
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

                            {{-- @if($product->sale_end)
                                <tr>
                                    <th class="fw-semibold">{{ __('admin.products.attributes.sale_end') }}</th>
                                    <td>{{  $product->sale_end->format('Y-m-d') }}</td>
                                </tr>
                            @endif --}}

                            {{-- <tr>
                                <th class="fw-semibold">{{ __('admin.products.attributes.with_tax') }}</th>
                                <td>{!! boolToYesNoSymbol($product->with_tax) !!}</td>
                            </tr> --}}
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

            @if($product->isGroup())
                <div class="tab-pane fade" id="product-details-consisted" role="tabpanel">
                    @if($product->groupItems->count())
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin.products.attributes.id') }}</th>
                                        <th>{{ __('admin.products.attributes.salla_id') }}</th>
                                        <th>{{ __('admin.products.attributes.image') }}</th>
                                        <th>{{ __('admin.products.attributes.name') }}</th>
                                        <th>{{ __('admin.products.attributes.sku') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($product->groupItems as $groupItem)
                                        <tr>

                                            <td>
                                                {{ $groupItem->product->id }}
                                            </td>
                                            <td>
                                                {{ $groupItem->product->remote_id }}
                                            </td>
                                            <td>
                                                @if(filled($groupItem->product->main_image))
                                                    <a href="{{ $groupItem->product->main_image }}" target="_blank">
                                                        <img src="{{ $groupItem->product->main_image }}" alt="{{ $groupItem->product->name }}" width="100" height="100">
                                                    </a>
                                                @else
                                                    -----
                                                @endif
                                            </td>
                                            <td>
                                                {{ $groupItem->product->name }}

                                                @if($groupItem->product->status == \App\Enums\ProductStatus::DELETED->value)
                                                    <div class="mt-1">
                                                        <span class="badge badge-sm badge-danger">
                                                            {{ __('globals.deleted') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                {{ filled($groupItem->product->sku) ? $groupItem->product->sku : '-----' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">
                            {{ __('admin.products.messages.no_consisted_products') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
