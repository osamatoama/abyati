<script>
    let dataTable = helpers.plugins.datatables.init([
        {data: 'reference_id', name: 'reference_id', orderable: false, searchable: true},
        {data: 'store', name: 'store', orderable: false, searchable: false},
        {data: 'customer', name: 'customer', orderable: false, searchable: false},
        {data: 'date', name: 'date', orderable: true, searchable: false},
        {data: 'status', name: 'status_name', orderable: false, searchable: true},
        {data: 'completion_status', name: 'completion_status', orderable: false, searchable: true},
        {data: 'employee', name: 'employee', orderable: false, searchable: true},
        {data: 'items_count', name: 'items_count', orderable: false, searchable: false},
        {data: 'total', name: 'total', orderable: true, searchable: false},
        {data: 'actions', name: 'actions', orderable: false, searchable: false},
    ], $('#results-table').data('url'),
        '#results-table',
        [[3, 'desc']],
        {
            buttons: [],
            drawCallback: function(settings) {
                enableTooltips()
            },
            createdRow: function (row, data, dataIndex) {
                let rowBackgroundColor = $(row).find('.id-wrapper').attr('data-id-color')
                $(row).addClass('order-row cursor-pointer')
                $(row).css('background-color', rowBackgroundColor)
            }
        }
    );

    Livewire.on('order-filters-applied', (params) => {
        $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
        reloadDatatable(dataTable)
    })

    Livewire.on('order-filters-reset', (params) => {
        $('#results-table').DataTable().ajax.url(params[0].refresh_url).load()
        reloadDatatable(dataTable)
    })

    Livewire.on('order-employee-assigned', (params) => {
        successToast(params[0].message)
    })

    const orderRowClass = '#results-table .order-row'
    const showOrderModal = $('#show-modal')

    $(document).on('click', orderRowClass, function(e) {
        const el = $(this)
        const idWrapper = el.find('.id-wrapper')

        console.log(e.target)

        if (e.target.closest('.actions-wrapper')) {
            return;
        }

        if (e.target.tagName === 'SELECT' || e.target.classList.contains('select2-selection')) {
            return
        }

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

    const assignBtnClass = '.assign-btn'

    $(document).on('click', assignBtnClass, function(e) {
        e.preventDefault()
        const el = $(this)
        disableElement(el)

        axios.post(el.data('action'))
            .then((response) => {
                successToast(response?.data?.message || getTranslation('updatedSuccessfully'))
                reloadDatatable(dataTable)
            })
            .catch((error) => {
                errorToast(getTranslation('somethingWrong'))
            })
            .then(() => {
                enableElement(el)
            })
    })

    const unassignBtnClass = '.unassign-btn'

    $(document).on('click', unassignBtnClass, function(e) {
        e.preventDefault()
        const el = $(this)
        disableElement(el)

        Swal.fire({
            title: getTranslation('areYouSure'),
            text: el.data('confirm-message'),
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: getTranslation('discard'),
            confirmButtonText: el.data('confirm-title')
        }).then(function (result) {
            if (result.value) {
                axios.post(el.data('action'))
                    .then((response) => {
                        successToast(response?.data?.message || getTranslation('updatedSuccessfully'))
                        reloadDatatable(dataTable)
                    })
                    .catch((error) => {
                        errorToast(getTranslation('somethingWrong'))
                    })
                    .then(() => {
                        enableElement(el)
                    })
            } else {
                enableElement(el)
            }
        })
    })
</script>
