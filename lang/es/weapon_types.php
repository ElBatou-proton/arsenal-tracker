<?php

return [
    // Resource
    'resource_label' => 'Tipo de Arma',
    'resource_label_plural' => 'Tipos de Arma',
    'navigation_group' => 'Gestión de Armas',

    // Form
    'form_title' => 'Formulario de Tipo de Arma',
    'create_title' => 'Nuevo Tipo de Arma',
    'edit_title' => 'Editar Tipo de Arma',

    // Fields
    'name' => 'Nombre',
    'description' => 'Descripción',
    'category' => 'Categoría',
    'order' => 'Orden',
    'created_at' => 'Fecha de Creación',
    'updated_at' => 'Fecha de Actualización',

    // Categories
    'categories' => [
        'handgun' => 'Arma de Fuego Corta',
        'rifle' => 'Rifle',
        'shotgun' => 'Escopeta',
        'submachine_gun' => 'Subfusil',
        'machine_gun' => 'Ametralladora',
        'sniper' => 'Francotirador',
        'other' => 'Otro',
    ],

    // Table
    'table_columns' => [
        'name' => 'Nombre',
        'category' => 'Categoría',
        'description' => 'Descripción',
        'weapons_count' => 'Cantidad de Armas',
        'order' => 'Orden',
    ],

    // Messages
    'created' => 'Tipo de arma creado exitosamente',
    'updated' => 'Tipo de arma actualizado exitosamente',
    'deleted' => 'Tipo de arma eliminado exitosamente',
    'confirm_delete' => '¿Está seguro de que desea eliminar este tipo de arma? Esto también afectará a las armas asociadas.',
];
