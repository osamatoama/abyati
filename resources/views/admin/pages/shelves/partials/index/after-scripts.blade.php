<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'id', name: 'id', orderable: true, searchable: true},
        {data: 'warehouse', name: 'warehouse', orderable: false, searchable: true},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'description', name: 'description', orderable: false, searchable: true},
        {data: 'employees', name: 'employees', orderable: false, searchable: false},
        // {data: 'order', name: 'order', orderable: true, searchable: true},
        {data: 'products_count', name: 'products_count', orderable: true, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: true},
    ], $('#results-table').data('url'), '#results-table', [[0, 'desc']], {
        pageLength: 25,
        buttons: [],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('shelf-row cursor-pointer')
        },
        drawCallback: function(settings) {
            enableTooltips()
        },
    })

    Livewire.on('shelf-filters-applied', (params) => {
        $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
        reloadDatatable(dataTable)
    })

    Livewire.on('shelf-filters-reset', (params) => {
        $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
        reloadDatatable(dataTable)
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
                successToast(response?.data?.message || getTranslation('importdSuccessfully'))
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
        editForm.find('[name=warehouse_id]').val(el.data('warehouse_id'))
        editForm.find('[name=aisle]').val(el.data('aisle'))
        editForm.find('[name=description]').val(el.data('description'))
        editForm.find('[name=employee_ids\\[\\]]').val(el.data('employee_ids')).trigger('change')

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

    const importWarehouseForm = $('#import-warehouse-form')
    const importWarehouseModal = $('#import-warehouse-modal')

    importWarehouseForm.submit(function(e) {
        e.preventDefault()
        disableSubmit(importWarehouseForm)
        hideFormValidationErrors(importWarehouseForm)

        axios.post(importWarehouseForm.attr('action'), getFormData(importWarehouseForm))
            .then((response) => {
                resetForm(importWarehouseForm)
                closeModal(importWarehouseModal)
                successToast(response?.data?.message || getTranslation('importdSuccessfully'))
                reloadDatatable(dataTable)
            })
            .catch((error) => {
                handleAjaxFormError(error, importWarehouseForm)
            })
            .then(() => {
                enableSubmit(importWarehouseForm)
            })
    })

    const importAisleForm = $('#import-aisle-form')
    const importAisleModal = $('#import-aisle-modal')

    importAisleForm.submit(function(e) {
        e.preventDefault()
        disableSubmit(importAisleForm)
        hideFormValidationErrors(importAisleForm)

        axios.post(importAisleForm.attr('action'), getFormData(importAisleForm))
            .then((response) => {
                resetForm(importAisleForm)
                closeModal(importAisleModal)
                successToast(response?.data?.message || getTranslation('importdSuccessfully'))
                reloadDatatable(dataTable)
            })
            .catch((error) => {
                handleAjaxFormError(error, importAisleForm)
            })
            .then(() => {
                enableSubmit(importAisleForm)
            })
    })

    $(`select#import-aisle-form-aisle`).select2()

    $('select#import-aisle-form-warehouse_id').on('change', function() {
        const el = $(this)
        const relatedAisleSelect = $(`select#import-aisle-form-aisle`)

        relatedAisleSelect.prop('disabled', false)
        relatedAisleSelect.val(null).trigger('change')

        if (! el.val()) {
            return
        }

        axios.get(relatedAisleSelect.data('url'), {params: {warehouse_id: el.val()}})
            .then((response) => {
                let aisleOptions = [
                    {
                        id: "",
                        text: "{{ __('globals.select_aisle') }}",
                    }
                ]

                let rows = response?.data?.data

                if (! rows.length) {
                    relatedAisleSelect.prop('disabled', true)

                    return
                }

                for (let row of rows) {
                    aisleOptions.push({
                        id: row.aisle,
                        text: row.aisle,
                    })
                }

                relatedAisleSelect.select2('destroy')
                relatedAisleSelect.empty()

                relatedAisleSelect.select2({
                    data: aisleOptions,
                    language: getSelect2Localization(relatedAisleSelect),
                    escapeMarkup: function (markup) {
                        return markup
                    },
                    dropdownParent: importAisleModal,
                })

                relatedAisleSelect.prop('disabled', false)
            })
    })

    const importShelfForm = $('#import-shelf-form')
    const importShelfModal = $('#import-shelf-modal')

    importShelfForm.submit(function(e) {
        e.preventDefault()
        disableSubmit(importShelfForm)
        hideFormValidationErrors(importShelfForm)

        axios.post(importShelfForm.attr('action'), getFormData(importShelfForm))
            .then((response) => {
                resetForm(importShelfForm)
                closeModal(importShelfModal)
                successToast(response?.data?.message || getTranslation('importdSuccessfully'))
                reloadDatatable(dataTable)
            })
            .catch((error) => {
                handleAjaxFormError(error, importShelfForm)
            })
            .then(() => {
                enableSubmit(importShelfForm)
            })
    })

    $(`select#import-shelf-form-shelf_id`).select2()

    $('select#import-shelf-form-warehouse_id').on('change', function() {
        const el = $(this)
        const relatedShelfSelect = $(`select#import-shelf-form-shelf_id`)

        relatedShelfSelect.prop('disabled', false)
        relatedShelfSelect.val(null).trigger('change')

        if (! el.val()) {
            return
        }

        axios.get(relatedShelfSelect.data('url'), {params: {warehouse_id: el.val()}})
            .then((response) => {
                let shelfOptions = [
                    {
                        id: "",
                        text: "{{ __('globals.select_shelf') }}",
                    }
                ]

                let rows = response?.data?.data

                if (! rows.length) {
                    relatedShelfSelect.prop('disabled', true)

                    return
                }

                for (let row of rows) {
                    shelfOptions.push({
                        id: row.id,
                        text: row.name,
                    })
                }

                relatedShelfSelect.select2('destroy')
                relatedShelfSelect.empty()

                relatedShelfSelect.select2({
                    data: shelfOptions,
                    language: getSelect2Localization(relatedShelfSelect),
                    escapeMarkup: function (markup) {
                        return markup
                    },
                    dropdownParent: importShelfModal,
                })

                relatedShelfSelect.prop('disabled', false)
            })
    })
</script>
