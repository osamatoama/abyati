<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false},
        {data: 'remote_id', name: 'remote_id', orderable: false, searchable: true},
        {data: 'synced', name: 'synced', orderable: false, searchable: false},
        {data: 'image', name: 'image', orderable: false, searchable: false},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'sku', name: 'sku', orderable: false, searchable: true},
        {data: 'quantity', name: 'quantity', orderable: true, searchable: false},
        {data: 'attached_at', name: 'attached_at', orderable: true, searchable: true},
    ], $('#shelf-sync-products-table').data('url'), '#shelf-sync-products-table', [[7, 'desc']], {
        buttons: [],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('product-row cursor-pointer')
        },
        drawCallback: function(settings) {
            enableTooltips()
        },
    })

    setInterval(() => {
        dataTable.ajax.reload(null, false)
    }, 5000)
</script>
