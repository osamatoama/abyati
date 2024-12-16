<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'id', name: 'id', orderable: true, searchable: true},
        @if(! $shelf)
        {data: 'shelf', name: 'shelf', orderable: false, searchable: true},
        @endif
        {data: 'employee', name: 'employee', orderable: false, searchable: true},
        {data: 'status', name: 'status', orderable: false, searchable: false},
        {data: 'started_at', name: 'started_at', orderable: true, searchable: false},
        {data: 'finished_at', name: 'finished_at', orderable: true, searchable: false},
        {data: 'issues_count', name: 'issues_count', orderable: true, searchable: false},
        {data: 'action', name: 'action', orderable: false, searchable: true},
    ], $('#results-table').data('url'), '#results-table', [[@if($shelf) 3 @else 4 @endif, 'desc']], {
        pageLength: 10,
        buttons: [],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('stocktaking-row cursor-pointer')
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
</script>
