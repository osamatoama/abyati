<form>
    <button type="submit" id="complete-item-{{ $item->id }}-btn" class="complete-item-btn btn btn-sm btn-success" data-kt-menu-dismiss="true">
        <i class="fas fa-check"></i> {{ __('support.orders.actions.complete') }}
    </button>
</form>

@script
    <script>
        $(document).on('click', '#complete-item-{{ $item->id }}-btn', function(e) {
            e.preventDefault()
            const el = $(this)
            disableElement(el)

            Swal.fire({
                title: getTranslation('areYouSure'),
                text: null,
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: getTranslation('discard'),
                confirmButtonText: "{{ __('support.orders.actions.complete') }}",
            }).then(function (result) {
                if (result.value) {
                    @this.complete()
                } else {
                    enableElement(el)
                }
            })
        })
    </script>
@endscript
