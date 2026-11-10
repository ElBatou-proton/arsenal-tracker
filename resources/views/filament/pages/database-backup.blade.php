<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            Información de copia de seguridad
        </x-slot>

        <p class="">
            Genera y descarga copias de seguridad de la base de datos SQL. Las copias de seguridad se almacenan en el directorio: storage/app/backups
        </p>
        <p class="">
            Conexión de base de datos actual: <strong class="">{{ config('database.default') }}</strong>
        </p>
    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">
            Copias de seguridad disponibles
        </x-slot>

        @if(count($this->backups) > 0)
        <!-- Using Filament table wrapper classes -->
        <table class="fi-ta-table">
            <thead>
                <tr>
                    <th class="fi-ta-header-cell">Nombre del archivo</th>
                    <th class="fi-ta-header-cell">Tamaño</th>
                    <th class="fi-ta-header-cell">Fecha de creación</th>
                    <th class="fi-ta-header-cell">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($this->backups as $backup)
                <tr>
                    <td class="fi-ta-cell">
                        <div class="fi-size-sm  fi-ta-text-item  fi-ta-text">
                            {{ $backup['filename'] }}
                        </div>
                    </td>
                    <td class="fi-ta-cell">
                        <div class="fi-size-sm  fi-ta-text-item  fi-ta-text">
                            {{ $backup['size'] }}
                        </div>
                    </td>
                    <td class="fi-ta-cell">
                        <div class="fi-size-sm  fi-ta-text-item  fi-ta-text">
                            {{ $backup['created_at'] }}
                        </div>
                    </td>
                    <td class="fi-ta-cell">
                        <div class="fi-size-sm  fi-ta-text-item  fi-ta-text">
                            <a
                                href="{{ route('backup.download', ['filename' => $backup['filename']]) }}"
                                style="margin-right: 0.5rem; color: #2563eb; text-decoration: underline;">
                                Descargar
                            </a>
                            <button
                                wire:click="deleteBackup('{{ $backup['filename'] }}')"
                                wire:confirm="¿Estás seguro de que quieres eliminar esta copia de seguridad?"
                                style="color: #dc2626; background: none; border: none; cursor: pointer; text-decoration: underline;">
                                Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div style="text-align: center; padding: 1.5rem 0; color: #6b7280;">
            No hay copias de seguridad disponibles. Genera tu primera copia de seguridad usando el botón de arriba.
        </div>
        @endif
    </x-filament::section>
</x-filament-panels::page>