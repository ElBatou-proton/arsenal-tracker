<!-- Status Change Modal -->
<div id="statusModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <h3 class="text-xl font-semibold mb-4">Actualizar Estado del Arma</h3>
        <form id="statusForm" class="space-y-4">
            <input type="hidden" id="statusWeaponId">
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select id="statusUpdateSelect" class="w-full px-3 py-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-lime-500" required>
                    <option value="">Seleccionar Estado</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Detalles</label>
                <textarea id="statusDetails" class="w-full px-3 py-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-lime-500" rows="3"></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-amber-700 text-white py-2 rounded-lg hover:bg-amber-800 cursor-pointer">Actualizar Estado</button>
                <button type="button" id="btnCloseStatusModal" class="flex-1 bg-stone-300 text-stone-700 py-2 rounded-lg hover:bg-stone-400 cursor-pointer">Cancelar</button>
            </div>
        </form>
    </div>
</div>
