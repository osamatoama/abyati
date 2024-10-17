<script>
    $('.scan-item-modal').on('shown.bs.modal', function(e) {
        let el = $(e.target)

        el.find('.scan-item-barcode-input').focus()
    })

    Livewire.on('order-scanned', (params) => {
        $('.scan-barcode-input').focus()
        playVoiceNotification('scanner-beep-notification')
    })

    Livewire.on('order-item-scanned', (params) => {
        $(`#scan-item-${params[0].order_item_id}-modal`).find('.scan-item-barcode-input').focus()
        playVoiceNotification('scanner-beep-notification')
    })

    Livewire.on('order-executed', (params) => {
        successToast(params[0].message)
        location.href = params[0].redirect_url
    })

    Livewire.on('order-item-executed', (params) => {
        closeModal($(`#scan-item-${params[0].order_item_id}-modal`))
        successToast(params[0].message)
    })

    Livewire.on('order-item-transferred', (params) => {
        closeModal($(`#transfer-item-${params[0].order_item_id}-modal`))
        successToast(params[0].message)
    })

    Livewire.on('scan-error', () => {
        playVoiceNotification('wrong-barcode-notification')
    })
</script>
