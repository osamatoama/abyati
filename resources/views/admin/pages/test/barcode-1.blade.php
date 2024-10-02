@extends('admin.layouts.master')

@section('title', 'Test')

@push('afterStyles')
    <link rel="stylesheet" href="{{ asset('assets/client/plugins/custom/barcode/style.css') }}">
@endpush

@section('content')
    <div class="card">
        <div class="card-body">
            <div id="barcode">
                <video id="barcodevideo" autoplay></video>
                <canvas id="barcodecanvasg" ></canvas>
            </div>
            <canvas id="barcodecanvas" ></canvas>
            <div id="result"></div>
        </div>
    </div>
@endsection

@push('afterScripts')
<script src="{{ asset('assets/client/plugins/custom/barcode/barcode.js') }}"></script>

<script>
    var sound = new Audio("barcode.wav");

    $(document).ready(function() {

        barcode.config.start = 0.1;
        barcode.config.end = 0.9;
        barcode.config.video = '#barcodevideo';
        barcode.config.canvas = '#barcodecanvas';
        barcode.config.canvasg = '#barcodecanvasg';
        barcode.setHandler(function(barcode) {
            $('#result').html(barcode);
        });
        barcode.init();

        // $('#result').bind('DOMSubtreeModified', function(e) {
        //     sound.play();
        // });

        const observer = new MutationObserver(function(mutationsList, observer) {
            for(const mutation of mutationsList) {
                if (mutation.type === 'childList' || mutation.type === 'subtree') {
                    sound.play();
                }
            }
        });

        observer.observe(document.getElementById('result'), { childList: true, subtree: true });
    });
</script>
@endpush
