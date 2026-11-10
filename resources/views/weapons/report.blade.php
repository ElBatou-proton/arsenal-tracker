@extends('layouts.app')

@section('content')
<body class="bg-stone-100 min-h-screen relative">
    <!-- Background Image with Overlay -->
    <div class="fixed inset-0 bg-cover bg-center bg-no-repeat opacity-20" style="background-image: url('{{ asset('images/bg.jpg') }}');"></div>
    <div class="fixed inset-0 bg-gradient-to-br from-stone-900/30 via-stone-800/20 to-stone-900/40"></div>
    
    <!-- Content -->
    <div class="relative z-10">
<div class="container mx-auto px-4 py-8">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 text-white p-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white">Reporte General de Asignaciones</h1>
                <p class="text-gray-300 mt-1">Filtrar por fecha y estado de asignación</p>
            </div>
            <a href="/" class="bg-stone-600 text-white px-4 py-2 rounded-lg hover:bg-stone-700 transition-colors">
                Retornar al Inicio
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <form method="GET" action="{{ route('weapons.report') }}" class="mb-6">
                <div class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-[200px]">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Inicio</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $start_date ?? '' }}" class="w-full px-3 py-2 border text-black border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Fin</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $end_date ?? now()->format('Y-m-d') }}" class="w-full px-3 py-2 border text-black border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="flex-1 min-w-[200px]">
                        <label for="status_id" class="block text-sm font-medium text-gray-700 mb-1">Estado de Asignación</label>
                        <select id="status_id" name="status_id" class="w-full px-3 py-2 border text-black border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Todos</option>
                            @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ $status_id == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Filtrar
                        </button>
                        <a href="{{ route('weapons.report') }}" class="ml-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                            Limpiar
                        </a>
                        <a href="{{ route('weapons.exportReport') }}?start_date={{ request('start_date') }}&end_date={{ request('end_date') }}&status_id={{ request('status_id') }}" class="ml-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                            Exportar a Excel
                        </a>
                    </div>
                </div>
            </form>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-stone-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número de Serie</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dueño</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rango</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Razón</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destino</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asignado por</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de Asignación</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($assignments as $assignment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $assignment->weapon->serial_number ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($assignment->owner)
                            <div class="text-sm font-medium text-gray-900">
                                {{ $assignment->owner->first_name }} {{ $assignment->owner->last_name }}
                            </div>
                            @else
                            <span class="text-sm text-gray-500">Desconocido</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($assignment->owner && $assignment->owner->rank)
                            <div class="text-sm text-gray-500">{{ $assignment->owner->rank->name }}</div>
                            @else
                            <span class="text-sm text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($assignment->status)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $assignment->status->color ? 'bg-' . $assignment->status->color . '-100 text-' . $assignment->status->color . '-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $assignment->status->name }}
                            </span>
                            @else
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                Desconocido
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $assignment->reason }}</div>
                            @if($assignment->details)
                            <div class="text-sm text-gray-500 mt-1">{{ $assignment->details }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $assignment->destination ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $assignment->assigned_by }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $assignment->entry_date->format('M j, Y g:i A') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                            No se encontró historial de asignaciones para los filtros seleccionados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($assignments->hasPages())
        <div class="mt-6">
            {{ $assignments->appends(['start_date' => request('start_date'), 'end_date' => request('end_date'), 'status_id' => request('status_id')])->links() }}
        </div>
        @endif
    </div>
</div>
</div>
@endsection
