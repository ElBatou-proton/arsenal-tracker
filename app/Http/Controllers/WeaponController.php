<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use App\Models\Owner;
use App\Models\WeaponAssignment;
use App\Models\WeaponAssignmentStatus;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class WeaponController extends Controller
{
    public function index()
    {
        return view('weapons.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'serial_number' => 'required_without:qr_code|string',
            'qr_code' => 'required_without:serial_number|string'
        ]);

        $query = Weapon::with(['owner.rank', 'weaponType', 'weaponAssignments.owner', 'weaponAssignments.status'])
            ->with(['weaponAssignments' => function($query) {
                $query->orderBy('entry_date', 'desc');
            }]);

        if ($request->has('qr_code')) {
            $weapon = $query->where('qr_code', $request->qr_code)->first();
        } else {
            $weapon = $query->where('serial_number', $request->serial_number)->first();
        }

        if (!$weapon) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontro el arma'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'weapon' => $weapon
        ]);
    }

    public function assign(Request $request, Weapon $weapon)
    {
        $request->validate([
            'action_type' => 'required|string',
            'owner_id' => 'required|exists:owners,id',
            'reason' => 'required|string',
            'destination' => 'nullable|string',
            'assigned_by' => 'nullable|string',
            'entry_date' => 'nullable|date',
            'status_id' => 'required|exists:weapon_assignment_statuses,id'
        ]);

        // Always create a new assignment to maintain complete history
        $assignment = WeaponAssignment::create([
            'weapon_id' => $weapon->id,
            'owner_id' => $request->owner_id,
            'assigned_by' => $request->assigned_by ?: 'System',
            'entry_date' => $request->entry_date ?: now(),
            'reason' => $request->reason,
            'destination' => $request->destination,
            'status_id' => $request->status_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Asignación creada exitosamente',
            'assignment' => $assignment->load(['owner', 'status', 'weapon'])
        ]);
    }

    public function return(Request $request, Weapon $weapon)
    {
        $assignment = WeaponAssignment::where('weapon_id', $weapon->id)
            ->where('status', 'active')
            ->first();

        if (!$assignment) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontro una asignacion activa'
            ], 404);
        }

        $assignment->update([
            'status' => 'returned',
            'returned_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'assignment' => $assignment->load('owner')
        ]);
    }

    public function updateStatus(Request $request, Weapon $weapon)
    {
        $request->validate([
            'status_id' => 'required|exists:weapon_assignment_statuses,id',
            'details' => 'nullable|string'
        ]);

        // Find the latest assignment and update its status
        $latestAssignment = WeaponAssignment::where('weapon_id', $weapon->id)
            ->orderBy('entry_date', 'desc')
            ->first();

        if (!$latestAssignment) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontro una asignacion para actualizar'
            ], 404);
        }

        $latestAssignment->update([
            'status_id' => $request->status_id,
            'details' => $request->details,
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estado del arma actualizado exitosamente'
        ]);
    }

    public function history(Weapon $weapon)
    {
        $assignments = WeaponAssignment::with(['owner', 'status'])
            ->where('weapon_id', $weapon->id)
            ->orderBy('entry_date', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'assignments' => $assignments
        ]);
    }

    public function fullHistory(Weapon $weapon, Request $request)
    {
        $query = WeaponAssignment::with(['owner', 'status'])
            ->where('weapon_id', $weapon->id);

        if ($request->filled('start_date')) {
            $query->where('entry_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('entry_date', '<=', $request->end_date . ' 23:59:59');
        }

        $assignments = $query->orderBy('entry_date', 'desc')
            ->paginate(30);

        return view('weapons.full-history', [
            'weapon' => $weapon,
            'assignments' => $assignments,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date ?? now()->format('Y-m-d')
        ]);
    }

    public function getOwners()
    {
        $owners = Owner::with('rank')->get();

        return response()->json($owners->map(function ($owner) {
            return [
                'id' => $owner->id,
                'first_name' => $owner->first_name,
                'last_name' => $owner->last_name,
                'full_name' => $owner->full_name,
                'full_name_with_rank' => $owner->full_name_with_rank,
                'rank' => $owner->rank ? $owner->rank->name : null
            ];
        }));
    }

    public function qrCode(Weapon $weapon)
    {
        if (!$weapon->qr_code) {
            abort(404, 'Codigo QR no encontrado para este arma');
        }

        $qrCode = QrCode::format('png')->size(200)->generate($weapon->qr_code);
        
        return response($qrCode)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'public, max-age=86400'); // Cache for 24 hours
    }

    public function getWeaponAssignmentStatuses()
    {
        $statuses = WeaponAssignmentStatus::get();

        return response()->json($statuses->map(function ($status) {
            return [
                'id' => $status->id,
                'name' => $status->name,
                'description' => $status->description
            ];
        }));
    }

    public function exportHistory(Weapon $weapon, Request $request)
    {
        $query = WeaponAssignment::with(['owner', 'status'])
            ->where('weapon_id', $weapon->id);

        if ($request->filled('start_date')) {
            $query->where('entry_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('entry_date', '<=', $request->end_date . ' 23:59:59');
        }

        $assignments = $query->orderBy('entry_date', 'desc')->get();

        $filename = 'historial_asignacion_' . $weapon->serial_number . '_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($assignments) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            // Header row
            fputcsv($file, [
                'Dueño',
                'Rango',
                'Estado',
                'Razón',
                'Detalles',
                'Destino',
                'Asignado por',
                'Fecha de Asignación'
            ], ';');

            // Data rows
            foreach ($assignments as $assignment) {
                fputcsv($file, [
                    $assignment->owner ? $assignment->owner->first_name . ' ' . $assignment->owner->last_name : 'Desconocido',
                    $assignment->owner && $assignment->owner->rank ? $assignment->owner->rank->name : '',
                    $assignment->status ? $assignment->status->name : 'Desconocido',
                    $assignment->reason,
                    $assignment->details ?? '',
                    $assignment->destination ?? '',
                    $assignment->assigned_by ?? '',
                    $assignment->entry_date ? $assignment->entry_date->format('Y-m-d H:i') : ''
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function report(Request $request)
    {
        $query = WeaponAssignment::with(['weapon', 'owner.rank', 'status']);

        if ($request->filled('start_date')) {
            $query->where('entry_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('entry_date', '<=', $request->end_date . ' 23:59:59');
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        $assignments = $query->orderBy('entry_date', 'desc')->paginate(30);
        $statuses = WeaponAssignmentStatus::all();

        return view('weapons.report', [
            'assignments' => $assignments,
            'statuses' => $statuses,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status_id' => $request->status_id
        ]);
    }

    public function exportReport(Request $request)
    {
        $query = WeaponAssignment::with(['weapon', 'owner.rank', 'status']);

        if ($request->filled('start_date')) {
            $query->where('entry_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('entry_date', '<=', $request->end_date . ' 23:59:59');
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        $assignments = $query->orderBy('entry_date', 'desc')->get();

        $filename = 'reporte_general_' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($assignments) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            
            // Header row
            fputcsv($file, [
                'Número de Serie',
                'Dueño',
                'Rango',
                'Estado',
                'Razón',
                'Detalles',
                'Destino',
                'Asignado por',
                'Fecha de Asignación'
            ], ';');

            // Data rows
            foreach ($assignments as $assignment) {
                fputcsv($file, [
                    $assignment->weapon ? $assignment->weapon->serial_number : '-',
                    $assignment->owner ? $assignment->owner->first_name . ' ' . $assignment->owner->last_name : 'Desconocido',
                    $assignment->owner && $assignment->owner->rank ? $assignment->owner->rank->name : '',
                    $assignment->status ? $assignment->status->name : 'Desconocido',
                    $assignment->reason,
                    $assignment->details ?? '',
                    $assignment->destination ?? '',
                    $assignment->assigned_by ?? '',
                    $assignment->entry_date ? $assignment->entry_date->format('Y-m-d H:i') : ''
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
