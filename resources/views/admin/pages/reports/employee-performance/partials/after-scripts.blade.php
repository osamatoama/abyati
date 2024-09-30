<script>
    let dataTable = helpers.plugins.datatables.init([
        {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false},
        {data: 'reference_id', name: 'reference_id', orderable: false, searchable: true},
        {data: 'started_at', name: 'started_at', orderable: false, searchable: false},
        {data: 'completed_at', orderable: false, searchable: false},
        {data: 'duration', name: 'duration', orderable: false, searchable: false},
        // {data: 'actions', name: 'actions', orderable: false, searchable: false},
    ], $('#results-table').data('url'),
        '#results-table',
        [[0, 'desc']],
        {
            buttons: [],
            drawCallback: function(settings) {
                enableTooltips()
            },
            // createdRow: function (row, data, dataIndex) {
            //     let rowBackgroundColor = $(row).find('.id-wrapper').attr('data-id-color')
            //     $(row).addClass('order-row cursor-pointer')
            //     $(row).css('background-color', rowBackgroundColor)
            // }
        }
    );

    // window.Echo.channel(`test-public-channel`)
    //     .listen('test.public', (e) => {
    //         console.log(e);
    //     });

    Livewire.on('report-filters-applied', (params) => {
        $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
        reloadDatatable(dataTable)
    })

    Livewire.on('report-filters-reset', (params) => {
        $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
        reloadDatatable(dataTable)
    })

    Livewire.on('report-employee-assigned', (params) => {
        successToast(params[0].message)
    })
</script>
