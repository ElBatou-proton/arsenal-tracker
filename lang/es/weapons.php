<?php

return [
    // Resource
    'resource_label' => 'Arma',
    'resource_label_plural' => 'Armas',
    'navigation_group' => 'Gestión de Armas',
    
    // Form
    'form_title' => 'Formulario de Arma',
    'create_title' => 'Nueva Arma',
    'edit_title' => 'Editar Arma',
    
    // Fields
    'weapon_type' => 'Tipo de Arma',
    'brand' => 'Marca',
    'model' => 'Modelo',
    'caliber' => 'Calibre',
    'origin' => 'Origen',
    'chamber_length' => 'Longitud de Cámara',
    'description' => 'Descripción',
    'serial_number' => 'Número de Serie',
    'qr_code' => 'Código QR',
    'qr_code_image' => 'Imagen del Código QR',
    'qr_code_image_save' => 'Guardar Imagen del Código QR',
    'qr_code_preview' => 'Vista Previa del Código QR',
    'qr_code_helper' => 'Código QR único autogenerado para identificación del arma',
    'intake_date' => 'Fecha de Ingreso',
    'intake_time' => 'Hora de Ingreso',
    'ammunition_type' => 'Tipo de Munición',
    'owner' => 'Propietario',
    
    // Table
    'table_columns' => [
        'weapon_type' => 'Tipo de Arma',
        'brand' => 'Marca',
        'model' => 'Modelo',
        'caliber' => 'Calibre',
        'serial_number' => 'Número de Serie',
        'qr_code' => 'Código QR',
        'intake_date' => 'Fecha de Ingreso',
        'intake_time' => 'Hora de Ingreso',
        'owner' => 'Propietario',
        'no_owner' => 'Sin propietario',
    ],
    
    // Info List
    'infolist_title' => 'Detalles del Arma',
    'no_qr_code' => 'No hay código QR disponible',
    'qr_code_error' => 'Error generando código QR',
    
    // Messages
    'created' => 'Arma creada exitosamente',
    'updated' => 'Arma actualizada exitosamente',
    'deleted' => 'Arma eliminada exitosamente',
    'confirm_delete' => '¿Está seguro de que desea eliminar esta arma? Esta acción no se puede deshacer.',
    
    // Status
    'status' => [
        'available' => 'Disponible',
        'assigned' => 'Asignada',
        'maintenance' => 'En Mantenimiento',
        'retired' => 'Retirada',
    ],
];
