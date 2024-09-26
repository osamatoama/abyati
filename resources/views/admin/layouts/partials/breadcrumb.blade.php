@unless ($breadcrumbs->isEmpty())
    @foreach ($breadcrumbs as $breadcrumb)
        @if (!is_null($breadcrumb->url) && !$loop->last)
            <li class="breadcrumb-item text-muted">
                <a href="{{ $breadcrumb->url }}" class="text-muted text-hover-primary">{{ $breadcrumb->title }}</a>
            </li>
        @else
            <li class="breadcrumb-item text-muted">{{ $breadcrumb->title }}</li>
        @endif

        @if(!$loop->last)
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>
        @endif
    @endforeach
@endunless
