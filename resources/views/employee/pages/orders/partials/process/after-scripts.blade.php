<script>
    Livewire.on('order-item-executed', (params) => {
        closeModal($(`#scan-item-${params[0].order_item_id}-modal`))
        successToast(params[0].message)
    })
</script>
