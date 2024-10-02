<div class="tabs-wrapper card mb-5">
    <div class="card-body px-3 py-1">
        <div class="d-flex flex-row flex-grow-1 pe-8">
            @foreach ($tabs as $tab)
                <div class="d-flex flex-wrap">
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 my-3">
                        <div class="fw-semibold fs-6 text-gray-400">{{ $tab['title'] }}</div>
                        <div class="d-flex align-items-center">
                            @if($enabled)
                                <div class="fs-2 fw-bold">
                                    {{ $tab['count'] }}
                                </div>
                            @else
                                <div class="fs-2">
                                    ---
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
