<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'DT_RowIndex', name: 'id', orderable: true, searchable: false},
        {data: 'name', name: 'name', orderable: false, searchable: false},
        {data: 'domain', name: 'domain', orderable: false, searchable: false},
        {data: 'id_color', name: 'id_color', orderable: false, searchable: false},
        // {data: 'active', name: 'active', orderable: false, searchable: false},
    ], $('#results-table').data('url'), '#results-table', [[0, 'asc']], {
        buttons: [],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('store-row cursor-pointer')
        },
        drawCallback: function(settings) {
            enableTooltips()
        },
    })

    const storeIdColorInputClass = '.store-id-color'

    $(document).on('change', storeIdColorInputClass, function() {
        let el = $(this)

        axios.post(el.data('action'), {_method: 'PUT', id_color: el.val()})
            .then((res) => {
                successToast(res.data.message)
            })
            .catch((error) => {
                errorToast(getTranslation('somethingWrong'))
                reloadDatatable(dataTable)
            })
    })

    // const toggleActiveRowBtnClass = '.toggle-active-row-button'

    // $(document).on('click', toggleActiveRowBtnClass, function() {
    //     let el = $(this)

    //     axios.post(el.data('url'), generateFormData('PUT'))
    //         .then((res) => {
    //             successToast(res.data.message)
    //         })
    //         .catch((error) => {
    //             errorToast(getTranslation('somethingWrong'))
    //             reloadDatatable(dataTable)
    //         })
    // })

    // const storeRowClass = '#results-table .store-row'
    // const showProductModal = $('#show-modal')

    // $(document).on('click', storeRowClass, function(e) {
    //     if (e.target.classList.contains('toggle-active-row-button')) {
    //         return
    //     }

    //     const el = $(this)
    //     const idWrapper = el.find('.id-wrapper')

    //     el.addClass('tr-overlay')

    //     try {
    //         window.location.href = idWrapper.data('show-url')
    //     } catch (error) {
    //         errorToast(getTranslation('somethingWrong'))
    //         enableElement(el)
    //         el.removeClass('tr-overlay')
    //     }
    // })
</script>
