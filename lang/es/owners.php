<?php

return [
    // Resource
    'resource_label' => 'Propietario',
    'resource_label_plural' => 'Propietarios',
    'navigation_group' => 'Gestión de Propietarios',
    
    // Form
    'form_title' => 'Formulario de Propietario',
    'create_title' => 'Nuevo Propietario',
    'edit_title' => 'Editar Propietario',
    
    // Fields
    'first_name' => 'Nombre',
    'last_name' => 'Apellido',
    'email' => 'Correo Electrónico',
    'phone' => 'Teléfono',
    'address' => 'Dirección',
    'identification' => 'Identificación',
    'license_number' => 'Número de Licencia',
    'license_expiry' => 'Vencimiento de Licencia',
    'date_of_birth' => 'Fecha de Nacimiento',
    'created_at' => 'Fecha de Creación',
    'updated_at' => 'Fecha de Actualización',
    'rank' => 'Rango',
    
    // Table
    'table_columns' => [
        'first_name' => 'Nombre',
        'last_name' => 'Apellido',
        'email' => 'Correo Electrónico',
        'phone' => 'Teléfono',
        'weapons_count' => 'Cantidad de Armas',
        'license_status' => 'Estado de Licencia',
        'rank' => 'Rango',
    ],
    
    // License Status
    'license_status' => [
        'valid' => 'Válida',
        'expired' => 'Vencida',
        'suspended' => 'Suspendida',
        'pending' => 'Pendiente',
    ],
    
    // Messages
    'created' => 'Propietario creado exitosamente',
    'updated' => 'Propietario actualizado exitosamente',
    'deleted' => 'Propietario eliminado exitosamente',
    'confirm_delete' => '¿Está seguro de que desea eliminar este propietario? Las armas asociadas quedarán sin propietario.',
    
    // Validation
    'validation' => [
        'unique_email' => 'El correo electrónico de este propietario ya está en uso. Por favor, use otro correo electrónico.',
    ],
];
