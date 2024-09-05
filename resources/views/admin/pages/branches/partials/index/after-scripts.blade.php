<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'id', name: 'id', orderable: true, searchable: true},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'related_order_status_id', name: 'related_order_status_id', orderable: false, searchable: false},
        {data: 'active', name: 'active', orderable: false, searchable: false},
    ], $('#results-table').data('url'), '#results-table', [[0, 'desc']], {
        buttons: [],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('product-row cursor-pointer')
        }
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
