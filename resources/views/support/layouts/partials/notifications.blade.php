<audio
    id="cashier-voice-notification"
    src="{{ asset('assets/client/media/audio/notifications/cashier-sound.mp3') }}"
    preload="auto"
></audio>

<script src="{{ asset('assets/client/plugins/custom/pusher/pusher.min.js') }}"></script>

<script>
    const authSupportId = "{{ auth('support')->id() }}"

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

            if (dataTable) {
                reloadDatatable(dataTable)
            }
        })
        .bind('order-completion-status-updated-event', function(data) {
            if(! (['quantity_issues', 'completed']).includes(data.status)) {
                return
            }

            if (dataTable) {
                reloadDatatable(dataTable)
            }
        })
</script>
