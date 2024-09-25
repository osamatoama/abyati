@if($errors->any())
    <div class="alert bg-danger alert-dismissible d-flex flex-column flex-sm-row align-items-center p-5 mb-10 text-white">
        @foreach($errors->all() as $error)
            {!! $error !!}<br/>
        @endforeach

        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-light">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert bg-danger alert-dismissible d-flex flex-column flex-sm-row align-items-center p-5 mb-10 text-white">
        {{ session('error') }}

        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-light">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </button>
    </div>
@endif

@if(session('success'))
    <div class="alert bg-success alert-dismissible d-flex flex-column flex-sm-row align-items-center p-5 mb-10 text-white">
        {{ session('success') }}

        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-light">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </button>
    </div>
@endif
