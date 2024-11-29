<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'checkbox', name: 'id', orderable: false, searchable: false},
        {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false},
        {data: 'remote_id', name: 'remote_id', orderable: false, searchable: true},
        {data: 'image', name: 'image', orderable: false, searchable: false},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'sku', name: 'sku', orderable: false, searchable: true},
        {data: 'attached_at', name: 'attached_at', orderable: true, searchable: true},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ], $('#shelf-products-table').data('url'), '#shelf-products-table', [[6, 'desc']], {
        buttons: [],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('product-row cursor-pointer')
        },
        drawCallback: function(settings) {
            enableTooltips()
        },
    })

    Livewire.on('product-scanned', (params) => {
        $('.scan-barcode-input').focus()
        playVoiceNotification('scanner-beep-notification')
        reloadDatatable(dataTable)
    })

    Livewire.on('scan-error', () => {
        playVoiceNotification('wrong-barcode-notification')
    })

    $(document).on('keydown', '.scan-barcode-input', (e) => {
        if (e.key === "Enter" || e.key === "Tab") {
            e.preventDefault()
            $('.scan-barcode-input').focus()
        }
    })

    const detachProductButtonClass = '.detach-product-btn'

    $('body').on('click', detachProductButtonClass, function (e) {
        e.preventDefault()
        let el = $(this)
        disableElement(el)

        // Swal.fire({
        //     title: getTranslation('areYouSure'),
        //     text: getTranslation('noRevertDelete'),
        //     icon: 'warning',
        //     showCancelButton: true,
        //     cancelButtonText: getTranslation('discard'),
        //     confirmButtonText: getTranslation('confirmDelete')
        // }).then(function (result) {
        //     if (result.value) {
                axios.post(el.data('action'), generateFormData('PUT'))
                    .then((response) => {
                        successToast(response?.data?.message || getTranslation('deletedSuccessfully'))
                        reloadDatatable(dataTable)
                    })
                    .catch((error) => {
                        errorToast(getTranslation('somethingWrong'))
                        enableElement(el)
                    })
        //     } else {
        //         enableElement(el)
        //     }
        // })
    })

    $('select.attach-product-form-product_ids').each((i, el) => {
        el = $(el)

        el.select2({
            language: getSelect2Localization(el),
            ajax: {
                url: el.data('ajax-url'),
                dataType: 'json',
                type: 'GET',
                data: function (params) {
                    return {
                        keyword: params.term,
                    }
                },
                delay: 500,
                processResults({ data }) {
                    return {
                        results: $.map(data, function (item) {
                            let text = item.name

                            if ((item.sku).length > 0) {
                                text += ' (' + item.sku + ')'
                            }

                            return {
                                text: text,
                                id: item.id,
                            }
                        })
                    }
                }
            }
        })
    })

    const attachProductForm = $('#attach-product-form')
    const attachProductModal = $('#attach-product-modal')

    attachProductForm.submit(function(e) {
        e.preventDefault()
        disableSubmit(attachProductForm)
        hideFormValidationErrors(attachProductForm)

        axios.post(attachProductForm.attr('action'), getFormData(attachProductForm))
            .then((response) => {
                resetForm(attachProductForm)
                closeModal(attachProductModal)
                successToast(response?.data?.message || getTranslation('createdSuccessfully'))
                reloadDatatable(dataTable)
            })
            .catch((error) => {
                handleAjaxFormError(error, attachProductForm)
            })
            .then(() => {
                enableSubmit(attachProductForm)
            })
    })

    let selectedRowIds = []
    let bulkActionsButtonId = '#bulk-actions-btn'
    let bulkActionsButton = $(bulkActionsButtonId)
    let bulkActionsCountId = '#bulk-actions-count'
    let bulkActionsCount = $(bulkActionsCountId)

    $('body').on('change', '.checkbox-single-row', function() {
        let checkboxSingleRow = $(this)
        let rowId = strAfterPrefix(checkboxSingleRow.attr('id'), 'checkbox-row-')
        checkboxSingleRow.prop('checked') ? selectedRowIds.push(rowId) : selectedRowIds.remove(rowId)
        selectedRowIds = [...new Set(selectedRowIds)]

        console.log(selectedRowIds)

        let enableBulkDelete = true
        $('.checkbox-single-row:checked').each(function(i, elem) {
            if ($(elem).closest('tr').find('.delete-row-button').length == 0) {
                enableBulkDelete = false
            }
        })

        if (! enableBulkDelete) {
            $('#bulk-delete-button').addClass('link-disabled')
            $('#bulk-trash-button').addClass('link-disabled')
        } else {
            $('#bulk-delete-button').removeClass('link-disabled')
            $('#bulk-trash-button').removeClass('link-disabled')
        }

        if (selectedRowIds.length > 0) {
            showElement(bulkActionsButton)
            bulkActionsCount.text(`(${selectedRowIds.length})`)
        } else {
            hideElement(bulkActionsButton)
            bulkActionsCount.text(`(0)`)
        }
    })

    $('body').on('change', '#checkbox-all-rows', function() {
        let checkboxAllRows = $(this)
        let state = checkboxAllRows.prop('checked')

        $(`#shelf-products-table .checkbox-single-row:not([disabled])`).each((index, element) => {
            let checkboxSingleRow = $(element)
            checkboxSingleRow.prop('checked', state)
            checkboxSingleRow.trigger('change')
        })
    })

    $('body').on('click', '#bulk-detach-button', function(e) {
        e.preventDefault()
        let el = $(this)
        let formData = generateFormData('PUT')
        formData.append('ids', selectedRowIds.toString())

        Swal.fire({
            title: getTranslation('areYouSure'),
            text: getTranslation('noRevertDetach'),
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: getTranslation('discard'),
            confirmButtonText: getTranslation('confirmDetach')
        }).then(function (result) {
            if (result.value) {
                axios.post(el.data('action'), formData)
                    .then((response) => {
                        successToast(response?.data?.message || getTranslation('deletedSuccessfully'))

                        reloadDatatable(dataTable)

                        if ($('#checkbox-all-rows').prop('checked')) {
                            $('#checkbox-all-rows').prop('checked', false)
                            $('#checkbox-all-rows').trigger('change')
                        }
                    })
            }
        })
    })
</script>
