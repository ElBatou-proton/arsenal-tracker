// QR Code Generator functionality
import QRCode from 'qrcode';

// Generate QR code and display it
function generateQrCodePreview(qrValue, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    // Clear previous QR code
    container.innerHTML = '';

    // Generate QR code
    QRCode.toDataURL(qrValue, {
        width: 200,
        margin: 2,
        color: {
            dark: '#000000',
            light: '#FFFFFF'
        }
    })
    .then(url => {
        // Create QR code image
        const img = document.createElement('img');
        img.src = url;
        img.alt = 'QR Code Preview';
        img.className = 'mx-auto mb-4 border border-gray-300 rounded';

        // Create download button
        const downloadBtn = document.createElement('button');
        downloadBtn.type = 'button';
        downloadBtn.className = 'w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 text-sm font-medium';
        downloadBtn.innerHTML = `
            <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
            </svg>
            Download QR Code
        `;
        downloadBtn.onclick = () => downloadQrCode(url, qrValue);

        // Append elements to container
        container.appendChild(img);
        container.appendChild(downloadBtn);
    })
    .catch(err => {
        console.error('Error generating QR code:', err);
        container.innerHTML = '<p class="text-red-500 text-center">Error generating QR code</p>';
    });
}

// Download QR code as image
function downloadQrCode(dataUrl, qrValue) {
    const link = document.createElement('a');
    link.download = `qr-code-${qrValue}.png`;
    link.href = dataUrl;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Export functions for global access
window.generateQrCodePreview = generateQrCodePreview;
window.downloadQrCode = downloadQrCode;
