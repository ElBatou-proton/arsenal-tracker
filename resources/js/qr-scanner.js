// QR Scanner functionality
import { Html5Qrcode } from 'html5-qrcode';

let isScanning = false;
let html5QrCode = null;
let lastErrorTime = 0;
const ERROR_THROTTLE_MS = 2000; // Log errors max once per second

function startQrScanner() {
    if (isScanning) {
        stopQrScanner();
        return;
    }

    // Check webcam availability first
    checkWebcamAvailability().then(() => {
        // Create QR scanner modal
        const modal = document.createElement('div');
        //add a unique id 
        modal.id = 'qrScannerModal';
        modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50';
        modal.innerHTML = `
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <h3 class="text-lg font-semibold mb-4">Escanear Código QR</h3>
                    <div id="qrScannerRegion" class="relative bg-gray-100 rounded-lg overflow-hidden" style="height: 300px;">
                    </div>
                <div class="mt-4 flex gap-3">
                    <button onclick="stopQrScanner()" class="flex-1 bg-gray-200 text-gray-800 py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-200">
                        Cancelar
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Initialize Html5Qrcode after the modal is added to DOM
        html5QrCode = new Html5Qrcode('qrScannerRegion');

        // Initialize QR scanner
        initializeQrScanner();
        isScanning = true;
    }).catch(error => {
        // Show error message in the main form
        showWebcamError(error.message);
    });
}

// Webcam availability check
async function checkWebcamAvailability() {
    try {
        // Check if getUserMedia is supported
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            throw new Error("La cámara no está disponible");
        }

        // Try to access webcam to verify it's working
        const stream = await navigator.mediaDevices.getUserMedia({ 
            video: { facingMode: "environment" } 
        });
        
        // If successful, stop the stream immediately
        stream.getTracks().forEach(track => track.stop());
        
        return Promise.resolve();
        
    } catch (error) {
        console.error("Webcam access error:", error);
        let errorMessage = "La cámara no está disponible";
        
        if (error.name === 'NotAllowedError') {
            errorMessage = "Permiso de cámara denegado. Por favor permite el acceso a la cámara.";
        } else if (error.name === 'NotFoundError') {
            errorMessage = "No se encontró ninguna cámara.";
        } else if (error.name === 'NotSupportedError') {
            errorMessage = "Tu navegador no soporta acceso a la cámara.";
        }
        
        return Promise.reject(new Error(errorMessage));
    }
}

// Show webcam error in the main form
function showWebcamError(message) {
    // Use the existing error message div from the search form
    const errorMessageDiv = document.getElementById("errorMessage");
    if (errorMessageDiv) {
        errorMessageDiv.textContent = message;
        errorMessageDiv.classList.remove("hidden");
        
        // Hide error after 5 seconds
        setTimeout(() => {
            errorMessageDiv.classList.add("hidden");
        }, 5000);
    } else {
        // Fallback: show alert if error div is not available
        alert(message);
    }
}

function initializeQrScanner() {
    // Check if browser supports camera
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        showQrError('La cámara no es compatible con este navegador');
        return;
    }

    const config = { 
        fps: 10, 
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0
    };

    // Throttled error logging function
    const logError = (message) => {
        const now = Date.now();
        if (now - lastErrorTime > ERROR_THROTTLE_MS) {
            console.warn(`QR Scan error: ${message}`);
            lastErrorTime = now;
        }
    };

    // Start scanning
    html5QrCode.start(
        { facingMode: 'environment' },
        config,
        (decodedText, decodedResult) => {
            onQrCodeDetected(decodedText);
        },
        (errorMessage) => {
            // Throttle error logging to prevent console spam
            logError(errorMessage);
        }
    ).catch((err) => {
        showQrError('Acceso a la cámara denegado: ' + err);
        stopQrScanner();
    }).then(() => {
        isScanning = true;
    });
}

function onQrCodeDetected(qrCode) {
    // Stop scanning
    stopQrScanner();

    // Fill the QR code input field
    const qrInput = document.getElementById('qrCode');
    if (qrInput) {
        qrInput.value = qrCode;
        qrInput.focus();
    }

    // Show success message
    const successMessage = document.createElement('div');
    successMessage.className = 'fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg z-50';
    successMessage.innerHTML = `
        <div class="flex items-center">
            <div class="text-green-600 mr-2">✅</div>
            <div>
                <strong>Codigo QR detectado!</strong><br>
                <span class="text-sm">${qrCode}</span>
            </div>
        </div>
    `;
    document.body.appendChild(successMessage);

    // Auto-remove success message after 3 seconds
    setTimeout(() => {
        if (successMessage.parentNode) {
            successMessage.parentNode.removeChild(successMessage);
        }
    }, 3000);

    // auto-submit the search form
    setTimeout(() => {
        const searchForm = document.getElementById('searchForm');
        if (searchForm) {
            searchForm.dispatchEvent(new Event('submit'));
            // close the modal
            stopQrScanner();
        }
    }, 1000);
}

function showQrError(message) {
    const scannerRegion = document.getElementById('qrScannerRegion');
    if (scannerRegion) {
        scannerRegion.innerHTML = `
            <div class="text-center p-4">
                <div class="text-red-600 mb-2">⚠️</div>
                <p class="text-gray-600">${message}</p>
                <button onclick="startQrScanner()" class="mt-3 bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                    Intentar de nuevo
                </button>
            </div>
        `;
    }
}

function stopQrScanner() {
    isScanning = false;

    // Stop html5-qrcode scanner
    if (html5QrCode && html5QrCode.isScanning) {
        html5QrCode.stop().then(() => {
            console.log('Escanner detenido');
        }).catch((err) => {
            console.error('Error al detener el escanner: ', err);
        });
    }

    // Reset the instance
    html5QrCode = null;

    // Remove modal
    const modal = document.querySelector('#qrScannerModal');
    if (modal) {
        modal.remove();
    }
}

// Export functions for global access
window.startQrScanner = startQrScanner;
window.stopQrScanner = stopQrScanner;

// Attach event listener for QR scan button
document.addEventListener('DOMContentLoaded', function() {
    const btnScanQr = document.getElementById('btnScanQr');
    if (btnScanQr) {
        btnScanQr.addEventListener('click', startQrScanner);
    }
});