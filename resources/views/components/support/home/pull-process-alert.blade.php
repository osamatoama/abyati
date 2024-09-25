@if($showAlert)
    <div class="alert alert-dismissable bg-warning d-flex flex-column flex-sm-row align-items-center p-5 mb-10">
        <i class="fa-solid fa-cloud-arrow-down fs-2hx text-light me-4 mb-5 mb-sm-0"></i>

        <div class="d-flex flex-column text-light pe-0 pe-sm-10">
            <h4 class="mb-2 text-light">
            </h4>
            <span>
                {{ __('home.pull_process_alert.body') }}
            </span>
        </div>

        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
            <i class="ki-duotone ki-cross fs-1 text-light"><span class="path1"></span><span class="path2"></span></i>
        </button>
    </div>
@endif
