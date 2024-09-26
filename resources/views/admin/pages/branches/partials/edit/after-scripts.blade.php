<script>
    Livewire.on('branch-updated', (params) => {
        successToast(params[0].message)
        location.href = params[0].redirect_url
    })
</script>
