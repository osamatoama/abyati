<script>
    let dataTable = helpers.plugins.datatables.init([
        {data: 'id', name: 'id', orderable: true, searchable: true},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'action', name: 'action', orderable: false, searchable: true},
    ], "{{ route('admin.roles.index')}}")


    const deleteRowButtonClass = '.delete-row-button'

    $('body').on('click', deleteRowButtonClass, function (e) {
        e.preventDefault()
        let el = $(this)
        disableElement(el)

        Swal.fire({
            title: getTranslation('areYouSure'),
            text: getTranslation('deleteAlert'),
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: getTranslation('discard'),
            confirmButtonText: getTranslation('confirmDelete')
        }).then(function (result) {
            if (result.value) {
                axios.post(el.data('action'), generateFormData('DELETE'))
                    .then((response) => {
                        successToast(response?.data?.message || getTranslation('deletedSuccessfully'))
                        reloadDatatable(dataTable)
                    })
                    .catch((error) => {
                        errorToast(getTranslation('somethingWrong'))
                        enableElement(el)
                    })
            } else {
                enableElement(el)
            }
        })
    })
</script>
