<!-- Weapon History Modal -->
<div id="historyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-2xl max-h-[80vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold">Historial del arma (ultimos 5 cambios)</h3>
            <button id="btnCloseHistoryModal" class="text-gray-500 hover:text-gray-700 cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div id="historyContent" class="space-y-4 mb-4">
            <!-- History items will be loaded here -->
        </div>

        <div class="flex justify-center">
            <button id="btnViewFullHistory" class="bg-amber-700 text-white px-4 py-2 rounded-lg hover:bg-amber-800 transition-colors">
                Ver Historial Completo
            </button>
        </div>
    </div>
</div>