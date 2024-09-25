<div class="tabs-wrapper row">
    @foreach ($tabs as $tab)
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 mb-5">
            <a href="{{ $tab['url'] }}" class="card shadow-sm parent-hover">
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
</div>
