<script>
    Livewire.on('branch-created', (params) => {
        successToast(params[0].message)
        location.href = params[0].redirect_url
    })
</script>
