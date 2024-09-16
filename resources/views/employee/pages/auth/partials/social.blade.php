{{--<div class="row g-3 mb-9">
    <div class="col-md-6">
        <a href="{{ route('integration.redirect', \App\Models\EcommerceProvider::SALLA_KEY) }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
            <img alt="Logo" src="{{ assetCustom('assets/client/media/svg/brand-logos/salla.svg') }}" class="h-15px me-3">
            Sign in with Salla
        </a>
    </div>
    <div class="col-md-6">
        <a href="{{ route('integration.redirect', \App\Models\EcommerceProvider::ZID_KEY) }}" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
            <img alt="Logo" src="{{ assetCustom('assets/client/media/svg/brand-logos/zid.svg') }}" class="h-15px me-3">
            Sign in with Zid
        </a>
    </div>
</div>--}}
<div class="row g-3 mb-9">
    <div class="col-12">
        <a href="{{ route('integration.redirect', \App\Models\EcommerceProvider::SALLA_KEY) }}"
           class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
            <img alt="Logo" src="{{ assetCustom('assets/client/media/svg/brand-logos/salla.svg') }}" class="h-15px me-3">
            {{ __("employee.auth.sign_in_with_salla") }}
        </a>
    </div>
</div>
