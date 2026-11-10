<!-- Weapon Withdraw/Return Modal -->
<div id="assignModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-full max-w-md">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-semibold">Registrar Asignacion de Arma</h3>
            <div id="currentStatus" class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800"></div>
        </div>

        <!-- Message Container -->
        <div id="assignMessage" class="hidden mb-4 p-3 rounded-lg text-sm font-medium"></div>

        <form id="assignForm" class="space-y-4">
            <input type="hidden" id="assignWeaponId">

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <select id="statusSelect" class="w-full px-3 py-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-lime-500" required>
                    <option value="">Elegir Estado</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Propietario</label>
                <select id="ownerSelect" class="w-full px-3 py-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-lime-500" required>
                    <option value="">Elegir Propietario</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Motivo</label>
                <textarea id="assignReason" class="w-full px-3 py-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-lime-500" rows="3" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Destino</label>
                <input type="text" id="assignDestination" class="w-full px-3 py-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-lime-500" placeholder="Donde se esta llevando el arma">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Autorizado Por</label>
                <input type="text" id="assignedBy" class="w-full px-3 py-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-lime-500" placeholder="Persona que autoriza esta accion">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Entrada</label>
                <input type="datetime-local" id="entryDate" class="w-full px-3 py-2 border border-stone-300 rounded-lg focus:ring-2 focus:ring-lime-500">
            </div>

            <div class="flex gap-3">
                <button type="submit" id="assignSubmitBtn" class="flex-1 bg-lime-700 text-white py-2 rounded-lg hover:bg-lime-800 cursor-pointer">
                    <span id="assignBtnText">Guardar</span>
                    <span id="assignBtnLoading" class="hidden">Procesando...</span>
                </button>
                <button type="button" id="btnCloseAssignModal" class="flex-1 bg-gray-300 text-gray-700 py-2 rounded-lg hover:bg-gray-400 cursor-pointer">Cancelar</button>
            </div>
        </form>
    </div>
</div>