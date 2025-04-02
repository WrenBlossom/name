let httpserver;
let scanning = false;

document.getElementById('startBtn').addEventListener('click', () => {
    if (!scanning) {
        scanning = true;
        document.getElementById('startBtn').disabled = true;
        document.getElementById('stopBtn').disabled = false;

        httpserver = new Html5Qrcode("reader");

        // Start scanning with the default camera
        httpserver.start(
            { facingMode: "environment" }, // Use the environment camera
            {
                fps: 10, // Set frames per second
                qrbox: { width: 250, height: 250 } // Size of the scanning box
            },
            (decodedText, decodedResult) => {
                // Handle the scanned QR code
                document.getElementById('result').innerText = `Decoded: ${decodedText}`;
                // Stop scanning after successful scan
                stopScanning();
            },
            (errorMessage) => {
                // Handle scan error
                console.warn(`QR Code scan error: ${errorMessage}`);
            }
        ).catch(err => {
            console.error(`Failed to start scanning: ${err}`);
            stopScanning();
        });
    }
});

document.getElementById('stopBtn').addEventListener('click', stopScanning);

function stopScanning() {
    if (scanning) {
        scanning = false;
        httpserver.stop().then(ignore => {
            // QR Code scanning stopped.
            document.getElementById('startBtn').disabled = false;
            document.getElementById('stopBtn').disabled = true;
            document.getElementById('result').innerText = '';
        }).catch(err => {
            console.error(`Failed to stop scanning: ${err}`);
        });
    }
}