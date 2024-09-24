<audio
    id="cashier-voice-notification"
    src="{{ asset('assets/client/media/audio/notifications/cashier-sound.mp3') }}"
    preload="auto"
></audio>

<script src="{{ asset('assets/client/plugins/custom/pusher/pusher.min.js') }}"></script>

<script>
    const authEmployeeId = "{{ auth('employee')->id() }}"

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
                playVoiceNotification('cashier-voice-notification')
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
            if (dataTable) {
                reloadDatatable(dataTable)
            }
        })
        .bind('order-updated-event', function(data) {
            if (dataTable) {
                reloadDatatable(dataTable)
            }
        })
</script>
