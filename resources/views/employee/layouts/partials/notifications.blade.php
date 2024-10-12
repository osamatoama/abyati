<audio
    id="cashier-sound-notification"
    src="{{ asset('assets/client/media/audio/notifications/cashier-sound.mp3') }}"
    preload="auto"
></audio>

<audio
    id="alert-sound-notification"
    src="{{ asset('assets/client/media/audio/notifications/alert-sound.mp3') }}"
    preload="auto"
></audio>

<script src="{{ asset('assets/client/plugins/custom/pusher/pusher.min.js') }}"></script>

<script>
    const authEmployeeId = "{{ auth('employee')->id() }}"
    const authEmployeeBranchId = "{{ auth('employee')->user()?->branch_id }}"

    var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        forceTLS: false,
        authEndpoint: "/broadcasting/auth",
    })

    Pusher.logToConsole = ('{{ app()->environment() }}' != 'production') || ('{{ config('app.staging') }}' == 'testing')

    pusher.subscribe('private-order-assign-channel')
        .bind('order-assigned-event', function(data) {
            if (data.self_assign == false && data.employee_id == authEmployeeId) {
                successToast(data.message)
                playVoiceNotification('cashier-sound-notification')
            }

            if (dataTable) {
                reloadDatatable(dataTable)
            }
        })
        .bind('order-unassigned-event', function(data) {
            if (dataTable) {
                reloadDatatable(dataTable)
            }
        })

    pusher.subscribe('private-order-sync-channel')
        .bind('order-created-event', function(data) {
            if (data.branch_id == authEmployeeBranchId) {
                if (dataTable) {
                    reloadDatatable(dataTable)
                }

                playVoiceNotification('alert-sound-notification')

                setTimeout(() => {
                    playSpeechSynthesisNotification('New order arrived')
                }, 1500);

                console.log('New order arrived')
            }
        })
        .bind('order-updated-event', function(data) {
            if (data.branch_id == authEmployeeBranchId && (data.employee_id == authEmployeeId || data.employee_id == null)) {
                if (dataTable) {
                    reloadDatatable(dataTable)
                }
            }
        })
        .bind('order-completion-status-updated-event', function(data) {
            if (dataTable) {
                reloadDatatable(dataTable)
            }
        })

    pusher.subscribe('private-order-delay-channel')
        .bind('order-processing-delayed-event', function(data) {
            if (data.employee_id == authEmployeeId) {
                playSpeechSynthesisNotification('You have a delayed order. Please start scanning the order items.')
            }
        })
</script>
