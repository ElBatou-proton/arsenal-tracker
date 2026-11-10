<!-- Weapon Details Section -->
<div id="weaponDetails" class="hidden max-w-4xl mx-auto mt-8">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Weapon Header -->
        <div class="bg-gradient-to-r from-gray-800 to-gray-900 text-white p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold" id="weaponName"></h3>
                    <p class="text-gray-300" id="weaponSerial"></p>
                    @if(isset($weapon->qr_code))
                        <p class="text-gray-300 mt-1">QR Code: {{ $weapon->qr_code }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <span id="statusBadge" class="px-3 py-1 rounded-full text-sm font-medium"></span>
                </div>
            </div>
        </div>

        <!-- QR Code Display -->
        @if(isset($weapon->qr_code))
        <div class="mb-6 text-center p-6">
            <h3 class="text-sm font-medium text-gray-700 mb-2">QR Code</h3>
            <img src="{{ route('weapons.qr-code', $weapon) }}" alt="QR Code" class="inline-block border border-gray-300 rounded-lg p-2">
            <p class="text-xs text-gray-500 mt-2">{{ $weapon->qr_code }}</p>
        </div>
        @endif

        <!-- Weapon Info -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Info -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-800 border-b pb-2">Informacion Basica</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Numero de Serie:</span>
                            <span class="font-medium" id="weaponSerialNumber"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tipo:</span>
                            <span class="font-medium" id="weaponType"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Marca:</span>
                            <span class="font-medium" id="weaponBrand"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Modelo:</span>
                            <span class="font-medium" id="weaponModel"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Calibre:</span>
                            <span class="font-medium" id="weaponCaliber"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fecha de Adquisicion:</span>
                            <span class="font-medium" id="weaponIntakeDate"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Hora de Adquisicion:</span>
                            <span class="font-medium" id="weaponIntakeTime"></span>
                        </div>
                    </div>
                </div>

                <!-- Owner Information -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-gray-800 border-b pb-2">Informacion del dueño</h4>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Nombre:</span>
                            <span class="font-medium" id="ownerName">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Rango:</span>
                            <span class="font-medium" id="ownerRank">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email:</span>
                            <span class="font-medium" id="ownerEmail">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Telefono:</span>
                            <span class="font-medium" id="ownerPhone">-</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-wrap gap-3 justify-center">
                <button
                    id="btnUpdateWeaponStatus"
                    class="bg-lime-700 text-white px-6 py-2 rounded-lg hover:bg-lime-800 transition duration-200 cursor-pointer">
                    Actualizar Estado del Arma
                </button>
                <button
                    id="returnBtn"
                    class="bg-amber-700 text-white px-6 py-2 rounded-lg hover:bg-amber-800 transition duration-200 cursor-pointer">
                    Reiniciar Formulario
                </button>
                <!--
                <button
                    onclick="openStatusModal()"
                    class="bg-orange-600 text-white px-6 py-2 rounded-lg hover:bg-orange-700 transition duration-200 cursor-pointer">
                    Mark Lost/Stolen/Destroyed
                </button>
                -->
                <button
                    id="btnViewHistory"
                    class="bg-stone-600 text-white px-6 py-2 rounded-lg hover:bg-stone-700 transition duration-200 cursor-pointer">
                    Ver Historial
                </button>
            </div>
        </div>
    </div>
</div>