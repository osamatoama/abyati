<script>
    function sendDataToReactNative() {
        const data = { message: 'Hello from WebView!', value: 42 }

        if (window.ReactNativeWebView == undefined) {
            Swal.fire({
                title: 'هذه الميزة لا تعمل على الويب. يرجى تثبيت التطبيق على الهاتف لاستخدام هذه الميزة.',
                icon: 'error',
                showCancelButton: false,
                confirmButtonText: getTranslation('ok'),
            })

            return
        }

        window.ReactNativeWebView.postMessage(JSON.stringify(data))
    }

    $('#camera-btn').click(function() {
        sendDataToReactNative()
    })

    $('.scan-item-modal').on('shown.bs.modal', function(e) {
        let el = $(e.target)

        el.find('.scan-item-barcode-input').focus()
    })

    Livewire.on('order-scanned', (params) => {
        $('.scan-barcode-input').focus()
        playVoiceNotification('scanner-beep-notification')
    })

    Livewire.on('product-confirmed', (params) => {
        $('.scan-barcode-input').focus()
    })

    $(document).on('keydown', '.scan-barcode-input', (e) => {
        if (e.key === "Enter" || e.key === "Tab") {
            e.preventDefault()
            $('.scan-barcode-input').focus()
        }
    })

    Livewire.on('product-scanned', (params) => {
        $(`#scan-item-${params[0].order_item_id}-modal`).find('.scan-item-barcode-input').focus()
        playVoiceNotification('scanner-beep-notification')
    })

    Livewire.on('order-executed', (params) => {
        Swal.fire({
            title: params[0].message,
            icon: 'success',
            showCancelButton: true,
            cancelButtonText: getTranslation('cancel'),
            confirmButtonText: getTranslation('backToMenu'),
        }).then(function (result) {
            if (result.value) {
                location.href = params[0].redirect_url
            }
        })
    })

    Livewire.on('product-updated', (params) => {
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
