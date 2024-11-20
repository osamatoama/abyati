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
    const authSupportId = "{{ auth('support')->id() }}"
    const authSupportBranchId = "{{ auth('support')->user()?->branch_id }}"

    var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
        forceTLS: false,
        authEndpoint: "/broadcasting/auth",
    })

    Pusher.logToConsole = ('{{ app()->environment() }}' != 'production') || ('{{ config('app.staging') }}' == 'testing')

    pusher.subscribe('private-order-sync-channel')
        .bind('order-updated-event', function(data) {
            if(! (['quantity_issues', 'completed']).includes(data.status)) {
                return
            }

            if (typeof dataTable !== 'undefined') {
                reloadDatatable(dataTable)
            }
        })
        .bind('order-completion-status-updated-event', function(data) {
            if(! (['quantity_issues', 'completed']).includes(data.status)) {
                return
            }

            if (typeof dataTable !== 'undefined') {
                reloadDatatable(dataTable)
            }
        })

    pusher.subscribe('private-order-transfer-channel')
        .bind('order-transferred-to-support-event', function(data) {
            if (data.branch_id == authSupportBranchId) {
                if (typeof dataTable !== 'undefined') {
                    reloadDatatable(dataTable)
                }

                playVoiceNotification('alert-sound-notification')
                warningToast(data.message)
            }
        })
</script>
