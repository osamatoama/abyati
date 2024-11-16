<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'id', name: 'id', orderable: true, searchable: true},
        {data: 'remote_id', name: 'remote_id', orderable: false, searchable: true},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'warehouses_count', name: 'warehouses_count', orderable: true, searchable: false},
        {data: 'active', name: 'active', orderable: false, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: true},
    ], $('#results-table').data('url'), '#results-table', [[0, 'desc']], {
        buttons: [],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('branch-row cursor-pointer')
        },
        drawCallback: function(settings) {
            enableTooltips()
        },
    })

    const toggleActiveRowBtnClass = '.toggle-active-row-button'

    $(document).on('click', toggleActiveRowBtnClass, function() {
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

    const deleteRowButtonClass = '.delete-row-button'

    $('body').on('click', deleteRowButtonClass, function (e) {
        e.preventDefault()
        let el = $(this)
        disableElement(el)

        Swal.fire({
            title: getTranslation('areYouSure'),
            text: getTranslation('noRevertDelete'),
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
