let currentWeapon = null;
let availableStatuses = [];

// Load statuses for dropdown
async function loadStatuses() {
    try {
        const response = await fetch("/api/weapon-assignment-statuses");
        const statuses = await response.json();
        availableStatuses = statuses;
        return Promise.resolve(); // Return a promise so .then() works
    } catch (error) {
        console.error("Error cargando estados:", error);
        return Promise.resolve(); // Still return promise on error
    }
}

// Load owners for dropdown
async function loadOwners() {
    try {
        const response = await fetch("/api/owners");
        const owners = await response.json();
        const select = document.getElementById("ownerSelect");

        owners.forEach((owner) => {
            const option = document.createElement("option");
            option.value = owner.id;
            option.textContent = owner.full_name;
            select.appendChild(option);
        });
    } catch (error) {
        console.error("Error cargando propietarios:", error);
    }
}

// Search form submission
document.getElementById("searchForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const loadingState = document.getElementById("loadingState");
    const errorMessage = document.getElementById("errorMessage");

    // Show loading
    loadingState.classList.remove("hidden");
    errorMessage.classList.add("hidden");

    try {
        const formData = new FormData(e.target);
        const searchType = document
            .getElementById("qrSearchField")
            .classList.contains("hidden")
            ? "serial"
            : "qr";

        let requestData;
        if (searchType === "qr") {
            requestData = {
                qr_code: formData.get("qr_code"),
            };
        } else {
            requestData = {
                serial_number: formData.get("serial_number"),
            };
        }

        const response = await fetch("/weapons/search", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify(requestData),
        });

        const data = await response.json();

        //reset messages to have fresh start
        document.getElementById("assignMessage").classList.add("hidden");

        if (data.success) {
            currentWeapon = data.weapon;
            displayWeaponDetails(data.weapon);
            document.getElementById("weaponDetails").classList.remove("hidden");
        } else {
            errorMessage.textContent = data.message || "Arma no encontrada";
            errorMessage.classList.remove("hidden");
            // also hide the weapons detail view
            document.getElementById("weaponDetails").classList.add("hidden");
        }
    } catch (error) {
        console.error("Error buscando arma:", error);
        errorMessage.textContent = "Ocurrió un error durante la búsqueda";
        errorMessage.classList.remove("hidden");

        // also hide the weapons detail view
        document.getElementById("weaponDetails").classList.add("hidden");
    } finally {
        loadingState.classList.add("hidden");
    }
});

function displayWeaponDetails(weapon) {
    document.getElementById("weaponName").textContent = weapon.name;
    document.getElementById("weaponSerial").textContent =
        `Serie: ${weapon.serial_number}`;
    
    // New fields
    document.getElementById("weaponSerialNumber").textContent = weapon.serial_number || "-";
    document.getElementById("weaponType").textContent =
        weapon.weapon_type?.name || "-";
    document.getElementById("weaponBrand").textContent = weapon.brand || "-";
    document.getElementById("weaponModel").textContent = weapon.model || "-";
    document.getElementById("weaponCaliber").textContent =
        weapon.caliber || "-";
    
    // Format intake_date as human readable date
    if (weapon.intake_date) {
        const intakeDate = new Date(weapon.intake_date);
        document.getElementById("weaponIntakeDate").textContent = 
            intakeDate.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        document.getElementById("weaponIntakeTime").textContent = 
            intakeDate.toLocaleTimeString('es-ES', {
                hour: '2-digit',
                minute: '2-digit'
            });
    } else {
        document.getElementById("weaponIntakeDate").textContent = "-";
        document.getElementById("weaponIntakeTime").textContent = "-";
    }

    // Owner information
    const owner = weapon.owner;
    if (owner) {
        document.getElementById("ownerName").textContent =
            `${owner.first_name || ""} ${owner.last_name || ""}`.trim() || "-";
        document.getElementById("ownerRank").textContent =
            owner.rank?.name || "-";
        document.getElementById("ownerEmail").textContent = owner.email || "-";
        document.getElementById("ownerPhone").textContent = owner.phone || "-";
    } else {
        document.getElementById("ownerName").textContent =
            "Sin propietario asignado";
        document.getElementById("ownerRank").textContent = "-";
        document.getElementById("ownerEmail").textContent = "-";
        document.getElementById("ownerPhone").textContent = "-";
    }

    // Note: Current assignment section removed from UI

    // Status badge shows latest assignment status
    const weaponAssignmentsForBadge = weapon.weapon_assignments || [];
    const statusBadge = document.getElementById("statusBadge");

    if (weaponAssignmentsForBadge.length > 0) {
        // Get the latest assignment (first in array if ordered by date desc)
        const latestAssignment = weaponAssignmentsForBadge[0];
        if (latestAssignment.status) {
            const status = latestAssignment.status;
            statusBadge.textContent = status.name;
            statusBadge.className = `px-3 py-1 rounded-full text-sm font-medium bg-opacity-20 text-black bg-white`;
        } else {
            statusBadge.textContent = "desconocido";
            statusBadge.className =
                "px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800";
        }
    } else {
        statusBadge.textContent = "disponible";
        statusBadge.className =
            "px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800";
    }
}

// Modal functions
function openAssignModal() {
    // Reset form first
    document.getElementById("assignForm").reset();

    document.getElementById("assignWeaponId").value = currentWeapon.id;

    // Update status options dynamically
    const statusSelect = document.getElementById("statusSelect");
    statusSelect.innerHTML = '<option value="">Seleccionar Estado</option>';

    if (availableStatuses.length > 0) {
        const weaponAssignmentsForModal =
            currentWeapon.weapon_assignments || [];
        const latestAssignment =
            weaponAssignmentsForModal.length > 0
                ? weaponAssignmentsForModal[0]
                : null;
        const currentStatusName = latestAssignment?.status?.name;

        availableStatuses.forEach((status) => {
            // Don't show the current status as an option to change to
            if (status.name !== currentStatusName) {
                // If current status is active and this status is returned, show as "Return Weapon"
                if (
                    latestAssignment &&
                    latestAssignment.status &&
                    latestAssignment.status.name === "active" &&
                    status.name === "returned"
                ) {
                    statusSelect.innerHTML += `<option value="${status.id}">Devolver Arma</option>`;
                } else {
                    statusSelect.innerHTML += `<option value="${status.id}">${status.name}</option>`;
                }
            }
        });
    }

    // Pre-select current owner if exists
    if (currentWeapon.owner) {
        const ownerSelect = document.getElementById("ownerSelect");
        ownerSelect.value = currentWeapon.owner.id;
    }

    // Set datetime field
    const entryDateField = document.getElementById("entryDate");
    const now = new Date();
    const localDateTime = new Date(
        now.getTime() - now.getTimezoneOffset() * 60000,
    )
        .toISOString()
        .slice(0, 16);
    entryDateField.value = localDateTime;

    document.getElementById("assignModal").classList.remove("hidden");

    // Update current status display
    const statusDiv = document.getElementById("currentStatus");
    const weaponAssignmentsForStatus = currentWeapon.weapon_assignments || [];
    const latestAssignmentForStatus =
        weaponAssignmentsForStatus.length > 0
            ? weaponAssignmentsForStatus[0]
            : null;

    if (latestAssignmentForStatus && latestAssignmentForStatus.status) {
        const status = latestAssignmentForStatus.status;
        statusDiv.textContent = status ? status.name : "desconocido";
        statusDiv.className = `px-3 py-1 rounded-full text-sm font-medium ${status ? `bg-opacity-20 text-${status.color}-800 bg-${status.color}-100` : "bg-gray-100 text-gray-800"}`;
    } else {
        statusDiv.textContent = "disponible";
        statusDiv.className =
            "px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800";
    }
}

function openStatusModal() {
    document.getElementById("statusWeaponId").value = currentWeapon.id;

    // Ensure statuses are loaded, if not, load them
    if (availableStatuses.length === 0) {
        loadStatuses().then(() => {
            populateStatusModal();
        });
    } else {
        populateStatusModal();
    }

    document.getElementById("statusModal").classList.remove("hidden");
}

function populateStatusModal() {
    // Populate status options dynamically
    const statusSelect = document.getElementById("statusUpdateSelect");
    statusSelect.innerHTML = '<option value="">Seleccionar Estado</option>';

    if (availableStatuses.length > 0) {
        const weaponAssignmentsForStatus =
            currentWeapon.weapon_assignments || [];
        const latestAssignmentForStatus =
            weaponAssignmentsForStatus.length > 0
                ? weaponAssignmentsForStatus[0]
                : null;
        const currentStatusName = latestAssignmentForStatus?.status?.name;

        availableStatuses.forEach((status) => {
            // Don't show the current status as an option to change to
            if (status.name !== currentStatusName) {
                statusSelect.innerHTML += `<option value="${status.id}">${status.name}</option>`;
            }
        });
    }
}

function resetForm() {
    // Clear the search form
    document.getElementById("searchForm").reset();

    // Hide weapon details
    document.getElementById("weaponDetails").classList.add("hidden");

    // Hide error message
    document.getElementById("errorMessage").classList.add("hidden");

    // Reset current weapon
    currentWeapon = null;
}

function openHistoryModal() {
    loadWeaponHistory();
    document.getElementById("historyModal").classList.remove("hidden");
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add("hidden");
}

function viewFullHistory() {
    if (currentWeapon) {
        window.open(`/weapons/${currentWeapon.id}/full-history`, "_blank");
    }
}

// Form submissions
document.getElementById("assignForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const statusId = document.getElementById("statusSelect").value;
    const messageDiv = document.getElementById("assignMessage");

    if (!statusId) {
        messageDiv.textContent = "Por favor seleccione un estado.";
        messageDiv.className =
            "mb-4 p-3 rounded-lg text-sm font-medium bg-red-100 text-red-800 border border-red-200";
        messageDiv.classList.remove("hidden");
        return;
    }

    // Handle status change or new assignment
    let requestData = {
        action_type: "change_status",
        status_id: statusId,
        owner_id: document.getElementById("ownerSelect").value,
        reason: document.getElementById("assignReason").value,
        destination: document.getElementById("assignDestination").value,
        assigned_by: document.getElementById("assignedBy").value,
        entry_date: document.getElementById("entryDate").value,
    };

    // Check if we need to create a new assignment or update existing
    const weaponAssignmentsForValidation =
        currentWeapon.weapon_assignments || [];
    const latestAssignmentForValidation =
        weaponAssignmentsForValidation.length > 0
            ? weaponAssignmentsForValidation[0]
            : null;

    // Find the selected status to determine action type
    const selectedStatus = availableStatuses.find((s) => s.id == statusId);

    // Validate based on current weapon status
    if (
        selectedStatus &&
        selectedStatus.name === "active" &&
        latestAssignmentForValidation &&
        latestAssignmentForValidation.status &&
        latestAssignmentForValidation.status.name === "active"
    ) {
        messageDiv.textContent =
            "El arma ya está asignada. Por favor devuélvala primero.";
        messageDiv.className =
            "mb-4 p-3 rounded-lg text-sm font-medium bg-yellow-100 text-yellow-800 border border-yellow-200";
        messageDiv.classList.remove("hidden");
        return;
    }

    if (
        selectedStatus &&
        selectedStatus.name === "returned" &&
        (!latestAssignmentForValidation ||
            latestAssignmentForValidation.status.name === "returned")
    ) {
        messageDiv.textContent =
            "El arma no está actualmente asignada. Nada que devolver.";
        messageDiv.className =
            "mb-4 p-3 rounded-lg text-sm font-medium bg-yellow-100 text-yellow-800 border border-yellow-200";
        messageDiv.classList.remove("hidden");
        return;
    }

    const submitBtn = document.getElementById("assignSubmitBtn");
    const btnText = document.getElementById("assignBtnText");
    const btnLoading = document.getElementById("assignBtnLoading");

    // Show loading state
    submitBtn.disabled = true;
    btnText.classList.add("hidden");
    btnLoading.classList.remove("hidden");

    // Hide any previous messages
    messageDiv.classList.add("hidden");

    try {
        const response = await fetch(`/weapons/${currentWeapon.id}/assign`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify(requestData),
        });

        const data = await response.json();

        if (data.success) {
            // Show success message
            messageDiv.textContent =
                "Asignación de arma guardada exitosamente!";
            messageDiv.className =
                "mb-4 p-3 rounded-lg text-sm font-medium bg-green-100 text-green-800 border border-green-200";
            messageDiv.classList.remove("hidden");

            // Reset form
            document.getElementById("assignForm").reset();

            // Close modal after delay
            setTimeout(() => {
                closeModal("assignModal");
                // Refresh weapon details
                document
                    .getElementById("searchForm")
                    .dispatchEvent(new Event("submit"));
            }, 1500);
        } else {
            // Show error message
            messageDiv.textContent =
                data.message || "Ocurrió un error al guardar la asignación";
            messageDiv.className =
                "mb-4 p-3 rounded-lg text-sm font-medium bg-red-100 text-red-800 border border-red-200";
            messageDiv.classList.remove("hidden");
        }
    } catch (error) {
        console.error("Error de asignación:", error);
        // Show error message
        messageDiv.textContent = "Error de red. Por favor intente nuevamente.";
        messageDiv.className =
            "mb-4 p-3 rounded-lg text-sm font-medium bg-red-100 text-red-800 border border-red-200";
        messageDiv.classList.remove("hidden");
    } finally {
        // Reset loading state
        submitBtn.disabled = false;
        btnText.classList.remove("hidden");
        btnLoading.classList.add("hidden");
    }
});

async function confirmReturn() {
    try {
        const response = await fetch(`/weapons/${currentWeapon.id}/return`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
        });

        const data = await response.json();

        if (data.success) {
            closeModal("returnModal");
            // Refresh weapon details
            document
                .getElementById("searchForm")
                .dispatchEvent(new Event("submit"));
        }
    } catch (error) {
        console.error("Error devolviendo arma:", error);
    }
}

document.getElementById("statusForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    try {
        const response = await fetch(`/weapons/${currentWeapon.id}/assign`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
            },
            body: JSON.stringify({
                status_id: document.getElementById("statusUpdateSelect").value,
                details: document.getElementById("statusDetails").value,
            }),
        });

        const data = await response.json();

        if (data.success) {
            closeModal("statusModal");
            // Refresh weapon details
            document
                .getElementById("searchForm")
                .dispatchEvent(new Event("submit"));
        }
    } catch (error) {
        console.error("Error actualizando estado:", error);
    }
});

async function loadWeaponHistory() {
    try {
        const response = await fetch(`/weapons/${currentWeapon.id}/history`);
        const data = await response.json();

        const historyContent = document.getElementById("historyContent");
        historyContent.innerHTML = "";

        if (data.success && data.assignments.length > 0) {
            data.assignments.forEach((assignment) => {
                const item = document.createElement("div");
                item.className = "border-l-4 border-blue-500 pl-4 py-2";

                const status = assignment.status;
                const statusColor = status ? status.color : "gray";

                item.innerHTML = `
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">${assignment.owner ? `${assignment.owner.first_name} ${assignment.owner.last_name}` : "Desconocido"}</h4>
                                <p class="text-sm text-gray-600">${assignment.reason}</p>
                                ${assignment.destination ? `<p class="text-sm text-gray-600">Destino: ${assignment.destination}</p>` : ""}
                                ${
                                    assignment.status
                                        ? `
                                    <span class="inline-block px-2 py-1 text-xs font-medium rounded-full ${assignment.status.color ? `bg-${assignment.status.color}-100 text-${assignment.status.color}-800` : "bg-gray-100 text-gray-800"}">
                                        ${assignment.status.name}
                                    </span>
                                `
                                        : ""
                                }
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500">${new Date(assignment.entry_date).toLocaleString()}</p>
                            </div>
                        </div>
                    `;

                historyContent.appendChild(item);
            });
        } else {
            historyContent.innerHTML =
                '<p class="text-gray-500 text-center">no hay registros para mostrar</p>';
        }
    } catch (error) {
        console.error("Error cargando historial:", error);
    }
}

// Initialize
document.addEventListener("DOMContentLoaded", () => {
    loadOwners();
    loadStatuses();
});

// Search type switching
function switchSearchType(type) {
    const serialTab = document.getElementById("serialTab");
    const qrTab = document.getElementById("qrTab");
    const serialField = document.getElementById("serialSearchField");
    const qrField = document.getElementById("qrSearchField");
    const serialInput = document.getElementById("serialNumber");
    const qrInput = document.getElementById("qrCode");

    if (type === "serial") {
        serialTab.className =
            "flex-1 py-2 px-4 text-sm font-medium rounded-md bg-white text-gray-900 shadow-sm transition-colors";
        qrTab.className =
            "flex-1 py-2 px-4 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 transition-colors";
        serialField.classList.remove("hidden");
        qrField.classList.add("hidden");
        serialInput.required = true;
        qrInput.required = false;
    } else {
        qrTab.className =
            "flex-1 py-2 px-4 text-sm font-medium rounded-md bg-white text-gray-900 shadow-sm transition-colors";
        serialTab.className =
            "flex-1 py-2 px-4 text-sm font-medium rounded-md text-gray-500 hover:text-gray-700 transition-colors";
        qrField.classList.remove("hidden");
        serialField.classList.add("hidden");
        qrInput.required = true;
        serialInput.required = false;
    }
}

// now that we are using this file as a js we need to attach the event to their corresponding elements
document.addEventListener("DOMContentLoaded", function () {
    const btnSearchSerial = document.getElementById("serialTab");
    if (btnSearchSerial) {
        btnSearchSerial.addEventListener(
            "click",
            switchSearchType.bind(null, "serial"),
        );
    }

    const btnSearchQr = document.getElementById("qrTab");
    if (btnSearchQr) {
        btnSearchQr.addEventListener(
            "click",
            switchSearchType.bind(null, "qr"),
        );
    }

    const btnCloseAssignModal = document.getElementById("btnCloseAssignModal");
    if (btnCloseAssignModal) {
        btnCloseAssignModal.addEventListener("click", function () {
            closeModal("assignModal");
        });
    }

    const btnCloseHistoryModal = document.getElementById(
        "btnCloseHistoryModal",
    );
    if (btnCloseHistoryModal) {
        btnCloseHistoryModal.addEventListener("click", function () {
            closeModal("historyModal");
        });
    }

    const btnViewFullHistory = document.getElementById("btnViewFullHistory");
    if (btnViewFullHistory) {
        btnViewFullHistory.addEventListener("click", function () {
            viewFullHistory();
        });
    }

    const btnCloseStatusModal = document.getElementById("btnCloseStatusModal");
    if (btnCloseStatusModal) {
        btnCloseStatusModal.addEventListener("click", function () {
            closeModal("statusModal");
        });
    }

    const btnUpdateWeaponStatus = document.getElementById(
        "btnUpdateWeaponStatus",
    );
    if (btnUpdateWeaponStatus) {
        btnUpdateWeaponStatus.addEventListener("click", function () {
            openAssignModal();
        });
    }

    const btnReturn = document.getElementById("returnBtn");
    if (btnReturn) {
        btnReturn.addEventListener("click", function () {
            resetForm();
        });
    }

    const btnViewHistory = document.getElementById("btnViewHistory");
    if (btnViewHistory) {
        btnViewHistory.addEventListener("click", function () {
            openHistoryModal();
        });
    }
});
