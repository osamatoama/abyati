{{-- <div class="tabs-wrapper row">
    @foreach ($tabs as $tab)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-5">
            <a href="#" class="card shadow-sm parent-hover">
                <div class="card-body d-flex align-items justify-content-between px-5 py-5">
                    <span class="ms-3 @if($tab['active']) text-primary @else text-gray-700 @endif parent-hover-primary fs-6 fw-bold">
                        {{ $tab['title'] }}
                    </span>

                    <span class="badge badge-outline badge-info rounded-pill">
                        {{ $tab['count'] }}
                    </span>
                </div>
            </a>
        </div>
    @endforeach
</div> --}}

<div class="tabs-wrapper card mb-5">
    <div class="card-body px-3 py-1">
        <div class="d-flex flex-row flex-grow-1 pe-8">
            @foreach ($tabs as $tab)
                <div class="d-flex flex-wrap">
                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 my-3">
                        <div class="fw-semibold fs-6 text-gray-400">{{ $tab['title'] }}</div>
                        <div class="d-flex align-items-center">
                            <div class="fs-2 fw-bold">
                                {{ $tab['count'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
