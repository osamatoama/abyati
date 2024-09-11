<script>
    const dataTable = helpers.plugins.datatables.init([
        {data: 'id', name: 'id', orderable: true, searchable: true},
        {data: 'name', name: 'name', orderable: false, searchable: true},
        {data: 'active', name: 'active', orderable: false, searchable: false},
    ], $('#results-table').data('url'), '#results-table', [[0, 'desc']], {
        buttons: [],
        createdRow: function (row, data, dataIndex) {
            $(row).addClass('branch-row cursor-pointer')
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

    const branchRowClass = '#results-table .branch-row'
    const showProductModal = $('#show-modal')

    $(document).on('click', branchRowClass, function(e) {
        console.log(e.target)

        if (e.target.classList.contains('toggle-active-row-button')) {
            return
        }

        const el = $(this)
        const idWrapper = el.find('.id-wrapper')

        el.addClass('tr-overlay')

        try {
            window.location.href = idWrapper.data('show-url')
        } catch (error) {
            errorToast(getTranslation('somethingWrong'))
            enableElement(el)
            el.removeClass('tr-overlay')
        }
    })
</script>
