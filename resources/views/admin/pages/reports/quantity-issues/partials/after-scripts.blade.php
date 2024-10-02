<script>
    let dataTable = helpers.plugins.datatables.init([
        {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false},
        {data: 'remote_id', name: 'remote_id', orderable: false, searchable: true},
        {data: 'name', name: 'name', orderable: false, searchable: false},
        {data: 'issues_count', name: 'issues_count', orderable: false, searchable: false},
        // {data: 'duration', name: 'duration', orderable: false, searchable: false},
        // {data: 'actions', name: 'actions', orderable: false, searchable: false},
    ], $('#results-table').data('url'),
        '#results-table',
        [[0, 'desc']],
        {
            buttons: [],
            drawCallback: function(settings) {
                enableTooltips()
            },
        }
    );

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
