<script>
    let dataTable = helpers.plugins.datatables.init([
        {data: 'id', name: 'id'},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'role', name: 'role.name', orderable: false, searchable: true},
        {data: 'email', name: 'email', orderable: false, searchable: true},
        {data: 'phone', name: 'phone', orderable: false, searchable: true},
        {data: 'active', name: 'active', orderable: false, searchable: true},
        {data: 'action', name: 'action', orderable: false, searchable: true},
    ], "{{ route('admin.users.index')}}")

    const rowActiveInputClass = '.toggle-active-row-button'

    $(document).on('click', rowActiveInputClass, function() {
        let el = $(this)

        axios.post(el.data('url'), generateFormData('PUT'))
        .then((res) => {
            successToast(res.data.message)
        })
        .catch((error) => {
            errorToast(getTranslation('somethingWrong'))
            reloadDatatable(dataTable)
        })
    })

    const createForm = $('#create-form')
    const createModal = $('#create-modal')

    createForm.submit(function(e) {
        e.preventDefault()
        disableSubmit(createForm)
        hideFormValidationErrors(createForm)

        axios.post(createForm.attr('action'), getFormData(createForm))
            .then((response) => {
                resetForm(createForm)
                closeModal(createModal)
                successToast(response?.data?.message || getTranslation('createdSuccessfully'))
                reloadDatatable(dataTable)
            })
            .catch((error) => {
                handleAjaxFormError(error, createForm)
            })
            .then(() => {
                enableSubmit(createForm)
            })
    })

    const editForm = $('#edit-form')
    const editModal = $('#edit-modal')
    const editRowBtnClass = '.edit-row-button'

    $(document).on('click', editRowBtnClass, function(e) {
        e.preventDefault()
        const el = $(this)

        resetForm(editForm)
        setFormAction(editForm, el.data('action'))
        editForm.find('[name=name]').val(el.data('name'))
        editForm.find('[name=role_id]').val(el.data('role-id'))
        editForm.find('[name=email]').val(el.data('email'))
        editForm.find('[name=phone]').val(el.data('phone'))
        hideFormValidationErrors(editForm)
        openModal(editModal)
    })

    editForm.submit(function(e) {
        e.preventDefault()
        disableSubmit(editForm)
        hideFormValidationErrors(editForm)

        axios.post(editForm.attr('action'), getFormData(editForm))
            .then((response) => {
                resetForm(editForm)
                closeModal(editModal)
                successToast(response?.data?.message || getTranslation('updatedSuccessfully'))
                reloadDatatable(dataTable)
            })
            .catch((error) => {
                handleAjaxFormError(error, editForm)
            })
            .then(() => {
                enableSubmit(editForm)
            })
    })



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
