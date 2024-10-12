{{-- <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script> --}}

<style>
    /* In order to place the tracking correctly */
    canvas.drawing, canvas.drawingBuffer {
        position: absolute;
        left: 0;
        top: 0;
    }
</style>

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"
    integrity="sha512-bCsBoYoW6zE0aja5xcIyoCDPfT27+cGr7AOCqelttLVRGay6EKGQbR6wm6SUcUGOMGXJpj+jrIpMS6i80+kZPw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

<script>
    $('.scan-item-modal').on('shown.bs.modal', function(e) {
        let el = $(e.target)

        // startScanner()
        el.find('.scan-barcode-input').focus()
    })

    // $('.scan-item-modal').on('hidden.bs.modal', function(e) {
    //     stopScanner()
    // })

    Livewire.on('order-scanned', (params) => {
        $(`#scan-modal`).find('.scan-barcode-input').focus()
    })

    Livewire.on('order-item-scanned', (params) => {
        $(`#scan-item-${params[0].order_item_id}-modal`).find('.scan-barcode-input').focus()
    })

    Livewire.on('order-executed', (params) => {
        closeModal($(`#scan-modal`))
        successToast(params[0].message)
    })

    Livewire.on('order-item-executed', (params) => {
        closeModal($(`#scan-item-${params[0].order_item_id}-modal`))
        successToast(params[0].message)
    })

    Livewire.on('order-item-transferred', (params) => {
        closeModal($(`#transfer-item-${params[0].order_item_id}-modal`))
        successToast(params[0].message)
    })

    // function startScanner() {
    //     Quagga.init({
    //         inputStream: {
    //             name: "Live",
    //             type: "LiveStream",
    //             target: document.querySelector('#qr-reader')
    //         },
    //         decoder: {
    //             readers: ["code_128_reader"]
    //         }
    //     }, function(err) {
    //         if (err) {
    //             console.log(err);
    //             return
    //         }
    //         console.log("Initialization finished. Ready to start");
    //         Quagga.start();
    //     });
    // }

    function stopScanner() {
        Quagga.stop()
    }

    // Quagga.onDetected(function(result) {
    //     console.log("Barcode detected and processed : [" + result.codeResult.code + "]", result);
    // });


    var _scannerIsRunning = false;

    function startScanner() {
        Quagga.init({
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: document.querySelector('#qr-reader'),
                constraints: {
                    width: 480,
                    height: 320,
                    facingMode: "environment"
                },
            },
            decoder: {
                readers: [
                    "code_128_reader",
                    "ean_reader",
                    "ean_8_reader",
                    "code_39_reader",
                    "code_39_vin_reader",
                    "codabar_reader",
                    "upc_reader",
                    "upc_e_reader",
                    "i2of5_reader"
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

        }, function(err) {
            if (err) {
                console.log(err);
                return
            }

            console.log("Initialization finished. Ready to start");
            Quagga.start();
            // document.querySelector('#qr-reader').getContext('2d', { willReadFrequently: true });

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
        });
    }


    // Start/stop scanner
    // document.getElementById("btn").addEventListener("click", function() {
    //     if (_scannerIsRunning) {
    //         Quagga.stop();
    //     } else {
    //         startScanner();
    //     }
    // }, false);

    // var html5QrcodeScanner = new Html5QrcodeScanner(
    //     'qr-reader',
    //     {
    //         fps: 3,
    //         qrbox: 250,
    //         formatsToSupport: [
    //             Html5QrcodeSupportedFormats.QR_CODE,
    //             Html5QrcodeSupportedFormats.AZTEC,
    //             Html5QrcodeSupportedFormats.CODABAR,
    //             Html5QrcodeSupportedFormats.CODE_39,
    //             Html5QrcodeSupportedFormats.CODE_93,
    //             Html5QrcodeSupportedFormats.CODE_128,
    //             Html5QrcodeSupportedFormats.DATA_MATRIX,
    //             Html5QrcodeSupportedFormats.MAXICODE,
    //             Html5QrcodeSupportedFormats.ITF,
    //             Html5QrcodeSupportedFormats.EAN_13,
    //             Html5QrcodeSupportedFormats.EAN_8,
    //             Html5QrcodeSupportedFormats.PDF_417,
    //             Html5QrcodeSupportedFormats.RSS_14,
    //             Html5QrcodeSupportedFormats.RSS_EXPANDED,
    //             Html5QrcodeSupportedFormats.UPC_A,
    //             Html5QrcodeSupportedFormats.UPC_E,
    //             Html5QrcodeSupportedFormats.UPC_EAN_EXTENSION,
    //         ]
    //     }
    // );

    // html5QrcodeScanner.render(onScanSuccess, onScanFailure);

    // function onScanSuccess(qrCodeMessage) {
    //     console.log(qrCodeMessage)
    // }

    // function onScanFailure(error) {
    //     console.log(error)
    // }
</script>
