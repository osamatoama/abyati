<script>
    $('.scan-item-modal').on('shown.bs.modal', function (e) {
        let el = $(e.target)

        el.find('.scan-barcode-input').focus()
    })

    Livewire.on('order-item-scanned', (params) => {
        $(`#scan-item-${params[0].order_item_id}-modal`).find('.scan-barcode-input').focus()
    })

    Livewire.on('order-item-executed', (params) => {
        closeModal($(`#scan-item-${params[0].order_item_id}-modal`))
        successToast(params[0].message)
    })

    Livewire.on('order-item-transferred', (params) => {
        closeModal($(`#transfer-item-${params[0].order_item_id}-modal`))
        successToast(params[0].message)
    })
</script>
