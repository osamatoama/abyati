<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'id', name: 'id', orderable: true, searchable: true},
        {data: 'remote_id', name: 'remote_id', orderable: false, searchable: true},
        {data: 'image', name: 'image', orderable: false, searchable: false},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'sku', name: 'sku', orderable: false, searchable: true},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ], $('#shelf-products-table').data('url'), '#shelf-products-table', [[0, 'desc']], {
        buttons: [],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('product-row cursor-pointer')
        },
        drawCallback: function(settings) {
            enableTooltips()
        },
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
</script>
