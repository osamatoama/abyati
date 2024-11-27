<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'id', name: 'id', orderable: true, searchable: true},
        {data: 'remote_id', name: 'remote_id', orderable: false, searchable: true},
        {data: 'image', name: 'image', orderable: false, searchable: false},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'store', name: 'store', orderable: false, searchable: true},
        {data: 'categories', categories: 'sku', orderable: false, searchable: false},
        {data: 'sku', name: 'sku', orderable: false, searchable: true},
        {data: 'warehouse', name: 'warehouse', orderable: false, searchable: false},
        // {data: 'quantity', name: 'quantity', orderable: true, searchable: true},
        // {data: 'price', name: 'price', orderable: true, searchable: false},
    ], $('#results-table').data('url'), '#results-table', [[0, 'desc']], {
        buttons: [],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('product-row cursor-pointer')
        },
        drawCallback: function(settings) {
            enableTooltips()
        },
    })

    Livewire.on('product-filters-applied', (params) => {
        $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
        reloadDatatable(dataTable)
    })

    Livewire.on('product-filters-reset', (params) => {
        $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
        reloadDatatable(dataTable)
    })

    const productRowClass = '#results-table .product-row'
    const showProductModal = $('#show-modal')

    $(document).on('click', productRowClass, function() {
        const el = $(this)
        const idWrapper = el.find('.id-wrapper')

        el.addClass('tr-overlay')

        axios.get(idWrapper.data('show-url'))
            .then((res) => {
                showProductModal.find('.modal-title').text(res.data.data.title)
                showProductModal.find('.modal-body').html(res.data.data.html)
                openModal(showProductModal)
            })
            .catch((error) => {
                errorToast(getTranslation('somethingWrong'))
                enableElement(el)
            })
            .then(() => {
                el.removeClass('tr-overlay')
            })
    })
</script>
