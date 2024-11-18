<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'id', name: 'id', orderable: true, searchable: true},
        {data: 'warehouse', name: 'warehouse', orderable: false, searchable: true},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'description', name: 'description', orderable: false, searchable: true},
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

    const importForm = $('#import-form')
    const importModal = $('#import-modal')

    importForm.submit(function(e) {
        e.preventDefault()
        disableSubmit(importForm)
        hideFormValidationErrors(importForm)

        axios.post(importForm.attr('action'), getFormData(importForm))
            .then((response) => {
                resetForm(importForm)
                closeModal(importModal)
                successToast(response?.data?.message || getTranslation('importdSuccessfully'))
                reloadDatatable(dataTable)
            })
            .catch((error) => {
                handleAjaxFormError(error, importForm)
            })
            .then(() => {
                enableSubmit(importForm)
            })
    })
</script>
