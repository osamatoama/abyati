<script>
    let dataTable = helpers.plugins.datatables.init([
        {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false},
        {data: 'remote_id', name: 'remote_id', orderable: false, searchable: true},
        {data: 'image', name: 'image', orderable: false, searchable: false},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'sku', name: 'sku', orderable: false, searchable: true},
        {data: 'shelves', name: 'shelves', orderable: false, searchable: false},
    ], $('#results-table').data('url'),
        '#results-table',
        [[0, 'desc']],
        {
            buttons: [
                {
                    text: '---',
                    className: 'results-table-custom-count btn-sm disabled',
                },
            ],
            drawCallback: function(settings) {
                enableTooltips()
                const totalRows = this.api().page.info().recordsTotal
                $('.results-table-custom-count').text(`${totalRows} ` + ' ' + getTranslation('product'))
            }
        }
    );

    Livewire.on('report-filters-applied', (params) => {
        $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
        reloadDatatable(dataTable)
    })

    Livewire.on('report-filters-reset', (params) => {
        $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
        reloadDatatable(dataTable)
    })
</script>
