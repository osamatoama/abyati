<div>
    @if($confirmedProducts->count())
        <div class="mb-5">
            <div class="card execution-card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('employee.stocktakings.process_statuses.confirmed') }} ({{ $confirmedProducts->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.image') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.name') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.barcode') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.price') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.quantity') }}</th>
                                </thead>

                                <tbody>
                                    @foreach($confirmedProducts as $product)
                                        <tr>
                                            <td>
                                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 50px;">
                                            </td>
                                            <td>
                                                <div class="product-name">
                                                    {{ $product->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <span dir="ltr">{{ $product->sku ?? '---' }}</span>
                                            </td>
                                            <td>
                                                {{ $product->price }}
                                            </td>
                                            <td>
                                                {{ $product->quantities->sum('quantity') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($issueProducts->count())
        <div class="mb-5">
            <div class="card execution-card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('employee.stocktakings.process_statuses.has_issues') }} ({{ $issueProducts->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.image') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.name') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.barcode') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.price') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.quantity') }}</th>
                                </thead>

                                <tbody>
                                    @foreach($issueProducts as $product)
                                        <tr>
                                            <td>
                                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 50px;">
                                            </td>
                                            <td>
                                                <div class="product-name">
                                                    {{ $product->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <span dir="ltr">{{ $product->sku ?? '---' }}</span>
                                            </td>
                                            <td>
                                                {{ $product->price }}
                                            </td>
                                            <td>
                                                {{ $product->quantities->sum('quantity') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($pendingProducts->count())
        <div class="mb-5">
            <div class="card execution-card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('employee.stocktakings.process_statuses.pending') }} ({{ $pendingProducts->count() }})</h3>
                </div>

                <div class="card-body">
                    <div class="order-products">
                        <div class="table-responsive">
                            <table class="table table-row-bordered">
                                <thead>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.image') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.name') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.barcode') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.price') }}</th>
                                    <th class="fw-bold text-nowrap">{{ __('employee.products.attributes.quantity') }}</th>
                                </thead>

                                <tbody>
                                    @foreach($pendingProducts as $product)
                                        <tr>
                                            <td>
                                                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 50px;">
                                            </td>
                                            <td>
                                                <div class="product-name">
                                                    {{ $product->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <span dir="ltr">{{ $product->sku ?? '---' }}</span>
                                            </td>
                                            <td>
                                                {{ $product->price }}
                                            </td>
                                            <td>
                                                {{ $product->quantities->sum('quantity') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
