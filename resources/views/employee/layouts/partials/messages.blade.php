@if($errors->any())
    <!--begin::Alert-->
    <div class="alert bg-danger alert-dismissible d-flex flex-column flex-sm-row align-items-center p-5 mb-10 text-white">
        @foreach($errors->all() as $error)
            {!! $error !!}<br/>
        @endforeach

        <!--begin::Close-->
        <button type="button"
                class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-light"><span class="path1"></span><span class="path2"></span></i>
        </button>
        <!--end::Close-->
    </div>
@endif
