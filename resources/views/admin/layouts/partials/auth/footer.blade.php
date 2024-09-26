<div class="d-flex flex-stack px-lg-10">
    <div class="me-0">
        <button class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
            <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ assetCustom('assets/client/media/flags/' . locale()->current() . '.svg') }}" alt="{{ locale()->currentNative() }}">
            <span data-kt-element="current-lang-name" class="me-1">
                {{ locale()->currentNative() }}
            </span>
            <i class="ki-duotone ki-down fs-5 text-muted rotate-180 m-0"></i>
        </button>
        @if(locale()->count() > 1)
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                @foreach(locale()->available() as $locale => $properties)
                    <div class="menu-item px-3">
                        <a href="{{ route('locale.change', ['locale' => $locale]) }}" class="menu-link d-flex px-5">
                            <span class="symbol symbol-20px me-4">
                                <img data-kt-element="lang-flag" class="rounded-1" src="{{ assetCustom('assets/client/media/flags/' . $locale . '.svg') }}" alt="{{ $properties['native'] }}">
                            </span>
                            <span data-kt-element="lang-name">
                                {{ $properties['native'] }}
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    {{--<div class="d-flex fw-semibold text-primary fs-base gap-5">
        <a href="" target="_blank">
            Link
        </a>
        <a href="" target="_blank">
            Link
        </a>
        <a href="" target="_blank">
            Link
        </a>
    </div>--}}
</div>
