<script>
    let dataTable = helpers.plugins.datatables.init([
        {data: 'reference_id', name: 'reference_id', orderable: true, searchable: true},
        {data: 'customer', name: 'customer', orderable: true, searchable: false},
        {data: 'date', name: 'date', orderable: true, searchable: false},
        {data: 'status', name: 'status_name', orderable: true, searchable: true},
        {data: 'payment_method', name: 'payment_method', orderable: false, searchable: false},
        {data: 'items_count', name: 'items_count', orderable: false, searchable: false},
        {data: 'total', name: 'total', orderable: true, searchable: false},
        {data: 'actions', name: 'actions', orderable: false, searchable: false},
    ], '{{ route('client.orders.index' ,['status' => request('status')])}}',
        '#results-table',
        [[2, 'desc']],
        {
            buttons: [
                'excel'
            ],
            drawCallback: function(settings) {
                enableTooltips()
            },
            createdRow: function (row, data, dataIndex) {
                $(row).addClass('order-row cursor-pointer')
            }
        }
    );


    const orderRowClass = '#results-table .order-row'
    const showOrderModal = $('#show-modal')

    $(document).on('click', orderRowClass, function() {
        const el = $(this)
        const idWrapper = el.find('.id-wrapper')

        el.addClass('tr-overlay')

        axios.get(idWrapper.data('show-url'))
            .then((res) => {
                showOrderModal.find('.modal-title').text(res.data.data.title)
                showOrderModal.find('.modal-body').html(res.data.data.html)
                openModal(showOrderModal)
            })
            .catch((error) => {
                errorToast(getTranslation('somethingWrong'))
                enableElement(el)
            })
            .then(() => {
                el.removeClass('tr-overlay')
            })
    })


    const showHistoryBtnClass = '.show-history-btn'
    const showHistoryModal = $('#show-history-modal')

    $('body').on('click', showHistoryBtnClass, function(e) {
        e.preventDefault()
        const el = $(this)

        axios.get(el.data('url'))
            .then((response) => {
                showHistoryModal.find('.modal-title').text(response.data.data.title)
                showHistoryModal.find('.modal-body').html(response.data.data.html)
                openModal(showHistoryModal)
            })
    })
</script>
