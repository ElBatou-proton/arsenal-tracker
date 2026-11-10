<!-- Weapon Search Form -->
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6">Búsqueda de Armas</h2>
        
        <!-- Search Type Tabs -->
        <div class="flex space-x-1 mb-6 bg-stone-200 p-1 rounded-lg">
            <button 
                type="button" 
                id="serialTab"
                class="flex-1 py-2 px-4 text-sm font-medium rounded-md bg-lime-700 text-white shadow-sm transition-colors"
            >
                Número de Serie
            </button>
            <button 
                type="button" 
                id="qrTab"
                class="flex-1 py-2 px-4 text-sm font-medium rounded-md text-stone-600 hover:text-stone-700 transition-colors"
            >
                Código QR
            </button>
        </div>

        <!-- Serial Number Search -->
        <form id="searchForm" class="space-y-6">
            <div id="serialSearchField">
                <label for="serialNumber" class="block text-sm font-medium text-gray-700 mb-2">
                    Número de Serie
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="serialNumber" 
                        name="serial_number"
                        class="w-full px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-transparent"
                        placeholder="Ingrese el número de serie del arma"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- QR Code Search -->
            <div id="qrSearchField" class="hidden">
                <label for="qrCode" class="block text-sm font-medium text-gray-700 mb-2">
                    Código QR
                </label>
                <div class="relative mb-4">
                    <input 
                        type="text" 
                        id="qrCode" 
                        name="qr_code"
                        class="w-full px-4 py-3 border border-stone-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-transparent"
                        placeholder="Ingrese el código QR o escanee con la cámara"
                    >
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                        </svg>
                    </div>
                </div>
                <button 
                    type="button" 
                    id="btnScanQr"
                    class="mt-2 w-full bg-amber-700 mb-2 text-gray-100 py-3 px-4 rounded-lg hover:bg-amber-800 transition duration-200 text-sm font-medium"
                >
                    📷 Escanear Código QR con Cámara
                </button>
            </div>
            
            <button 
                type="submit" 
                class="w-full bg-lime-700 text-white py-3 px-4 rounded-lg hover:bg-lime-800 transition duration-200 font-medium cursor-pointer"
            >
                Buscar Arma
            </button>
        </form>

        <!-- Loading State -->
        <div id="loadingState" class="hidden text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-lime-700"></div>
            <p class="mt-2 text-gray-600">Buscando...</p>
        </div>

        <!-- Error Message -->
        <div id="errorMessage" class="hidden bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mt-4">
        </div>
    </div>
</div>
