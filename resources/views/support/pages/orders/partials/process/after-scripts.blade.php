<script>
    Livewire.on('order-item-completed', (params) => {
        successToast(params[0].message)
    })
</script>
