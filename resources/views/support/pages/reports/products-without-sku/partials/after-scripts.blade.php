<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: true},
        {data: 'remote_id', name: 'remote_id', orderable: false, searchable: true},
        {data: 'image', name: 'image', orderable: false, searchable: false},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'store', name: 'store', orderable: false, searchable: true},
        {data: 'sku', name: 'sku', orderable: false, searchable: true},
        // {data: 'quantity', name: 'quantity', orderable: true, searchable: true},
        // {data: 'price', name: 'price', orderable: true, searchable: false},
    ], $('#results-table').data('url'), '#results-table', [[0, 'asc']], {
        buttons: [],
        // createdRow: function (row, data, dataIndex) {
        //     $(row).addClass('product-row cursor-pointer')
        // },
        drawCallback: function(settings) {
            enableTooltips()
        },
    })

    // Livewire.on('report-filters-applied', (params) => {
    //     $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
    //     reloadDatatable(dataTable)
    // })

    // Livewire.on('report-filters-reset', (params) => {
    //     $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
    //     reloadDatatable(dataTable)
    // })

    // Livewire.on('report-employee-assigned', (params) => {
    //     successToast(params[0].message)
    // })
</script>
