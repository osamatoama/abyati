@extends('admin.layouts.master')

@section('title', 'Test')

@section('content')
    <div class="card">
        <div class="card-body">
            <div id="barcode-reader"></div>
        </div>
    </div>
@endsection

@push('afterScripts')
<script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>
{{-- <script src="{{ asset('assets/client/plugins/custom/quagga/quagga.js') }}"></script> --}}

<script>
    const scannerAudio = new Audio("{{ asset('assets/client/plugins/custom/barcode/barcode.wav') }}");

    function startScanner() {
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#barcode-reader'),
                constraints: {
                    width: 480,
                    height: 320,
                    facingMode: "environment",
                    // advanced: [{ focusMode: "auto" }],
                },
            },
            locator: {
                patchSize: 'medium',
                halfSample: true,
            },
            numOfWorkers: 0,
            frequency: 10,
            decoder: {
                readers: [
                    // "code_128_reader",
                    "ean_reader",
                    // "ean_8_reader",
                    // "code_39_reader",
                    // "code_39_vin_reader",
                    // "codabar_reader",
                    // "upc_reader",
                    // "upc_e_reader",
                    // "i2of5_reader"
                ],
                debug: {
                    showCanvas: true,
                    showPatches: true,
                    showFoundPatches: true,
                    showSkeleton: true,
                    showLabels: true,
                    showPatchLabels: true,
                    showRemainingPatchLabels: true,
                    boxFromPatches: {
                        showTransformed: true,
                        showTransformedBox: true,
                        showBB: true
                    }
                }
            },
            // locate: true,
        }, function(err) {
            if (err) {
                console.log(err);
                return
            }

            console.log("Initialization finished. Ready to start");
            Quagga.start();
            // document.querySelector('#barcode-reader').getContext('2d', { willReadFrequently: true });

            // Set flag to is running
            _scannerIsRunning = true;
        });

        Quagga.onProcessed(function(result) {
            var drawingCtx = Quagga.canvas.ctx.overlay,
                drawingCanvas = Quagga.canvas.dom.overlay;

            if (result) {
                if (result.boxes) {
                    drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(
                        drawingCanvas.getAttribute("height")));
                    result.boxes.filter(function(box) {
                        return box !== result.box;
                    }).forEach(function(box) {
                        Quagga.ImageDebug.drawPath(box, {
                            x: 0,
                            y: 1
                        }, drawingCtx, {
                            color: "green",
                            lineWidth: 2
                        });
                    });
                }

                if (result.box) {
                    Quagga.ImageDebug.drawPath(result.box, {
                        x: 0,
                        y: 1
                    }, drawingCtx, {
                        color: "#00F",
                        lineWidth: 2
                    });
                }

                if (result.codeResult && result.codeResult.code) {
                    Quagga.ImageDebug.drawPath(result.line, {
                        x: 'x',
                        y: 'y'
                    }, drawingCtx, {
                        color: 'red',
                        lineWidth: 3
                    });
                }
            }
        });


        Quagga.onDetected(function(result) {
            console.log("Barcode detected and processed : [" + result.codeResult.code + "]", result);

            alert(result.codeResult.code);

            const errors = result.codeResult.decodedCodes
                .filter((_) => _.error !== undefined)
                .map((_) => _.error);
            const median = _getMedian(errors);

            // if (median < 0.08 || errors.some((err) => err > 0.1)) {
            if (median < medianLimit) {
                // Quagga.stop();
                // alert(result.codeResult.code);
            }
        });
    }

    // startScanner()

    Quagga.init({
        inputStream : {
            name : "Live",
            type : "LiveStream",
            target: document.querySelector('#barcode-reader'),
            constraints: {
                width: 480,
                height: 320,
                facingMode: "environment",
                // advanced: [{ focusMode: "auto" }],
            },
        },
        decoder : {
            readers : [
                // "code_128_reader",
                "ean_reader",
                // "ean_8_reader",
                // "code_39_reader",
                // "code_39_vin_reader",
                // "codabar_reader",
                // "upc_reader",
                // "upc_e_reader",
                // "i2of5_reader",
            ],
        },
        // locator: {
        //     patchSize: 'medium',
        //     halfSample: true,
        // },
        // numOfWorkers: 2,
        frequency: 10,
        // locate: true,
    }, function(err) {
        if (err) {
            console.log(err);
            return
        }
        console.log("Initialization finished. Ready to start");
        Quagga.start();
    });

    Quagga.onDetected(function(result) {
        console.log("Barcode detected and processed : [" + result.codeResult.code + "]", result);
        scannerAudio.play()

        alert(result.codeResult.code);

        const errors = result.codeResult.decodedCodes
            .filter((_) => _.error !== undefined)
            .map((_) => _.error);
        const median = _getMedian(errors);

        // if (median < 0.08 || errors.some((err) => err > 0.1)) {
        if (median < medianLimit) {
            // Quagga.stop();
            alert('no errors');
        }

    });
</script>
@endpush
