<script>
    const loginForm = $('#login-form')

    loginForm.submit(function(e) {
        e.preventDefault()
        disableSubmit(loginForm)
        hideFormValidationErrors(loginForm)

        axios.post(loginForm.attr('action'), getFormData(loginForm))
            .then((response) => {
                successToast(response?.data?.message || 'تم تسجيل الدخول بنجاح')
                window.location.href = response?.data?.data?.redirect || '{{ route('admin.home') }}'
            })
            .catch((error) => {
                handleAjaxFormError(error, loginForm)
                enableSubmit(loginForm)
            })
            .then(() => {
                //
            })
    })
</script>
