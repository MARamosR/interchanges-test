<?php

return [
    // Form validations
    'salida_required' => 'El campo "Salida" es obligatorio.',
    'salida_min' => 'El campo "Salida" debe contener por lo menos 3 caracteres.',
    'fecha_salida_required' => 'El campo "Fecha de salida" es obligatorio.',
    'destino_required' => 'El campo "Destino" es obligatorio.',
    'destino_min' => 'El campo "Destino" debe contener por lo menos 3 caracteres.',
    'fecha_destino_required' => 'El campo "Fecha de llegada" es obligatorio.',
    'fecha_destino_after_or_equal' => 'El campo "Fecha de destino" no puede ser antes de la fecha de salida.',
    'descripcion_required' => 'El campo "Descripción" es obligatorio.',
    'unidad_required' => 'Se requiere una unidad para poder registrar la ruta.',
    'operator_required' => 'Se requiere un operador para poder registrar la ruta.',
    'contenedores_required' => 'Se requiere por lo menos 1 contenedor para poder registrar la ruta.',
    'equipment_required' => 'Se requiere por lo menos 1 equipo de sujeción para poder registrar la ruta.',

    // Form labels
    'add_route' => 'Agregar ruta:',
    'departure_location' => 'Lugar de salida:',
    'departure_date' => 'Fecha de salida:',
    'arrival_location' => 'Lugar de destino:',
    'destination_date' => 'Fecha de llegada estimada:',
    'description' => 'Descripcion:',
    'unit' => 'Unidad:',
    'unit_licence_plate' => 'Placas de la unidad que se que se usará en esta ruta ',
    'operator' => 'Operador:',
    'restraint_equipment' => 'Equipo de sujeción que se usará en esta ruta:',
    'container_licence_plates' => 'Placas de los contenedores que se usarán en esta ruta:',
    'images' => 'Imagenes inicales de la ruta:',
    'select_operator' => 'Selecciona al operador asignado para esta ruta',
    'select_unit' => 'Selecciona la placa de la unidad asignada para esta ruta',
    'select_container' => 'Selecciona un contenedor',
    'select_equipment' => 'Selecciona un equipo de sujeción',
    'equipment_available' => 'No hay equipo de sujeción disponible',
    'container_available' => 'No hay contenedores disponibles',
    
    
    //Form buttons
    'route_create_add_route_btn' => 'Agregar ruta',
    'route_create_add_container_btn' => 'Agregar contenedor',
    'route_create_remove_container_btn' => 'Remover contenedor',
    'route_create_add_restraint_equipment' => 'Agregar equipo',
    'route_create_remove_restraint_equipment' => 'Remover equipo',
    'route_create_add_image' => 'Agregar imagen',
    'route_create_remove_image' => 'Remover imagen',

    //Submit alert
    'route_create_submit_alert_title' => '¿Esta seguro de esto?',
    'route_create_submit_alert_confirm' => 'Confirmar',
    'route_create_submit_alert_cancel' => 'Cancelar',
    'route_create_submit_alert_body' => 'Verifique que los datos sean correctos, una vez registrada una ruta sus datos ya no podran ser alterados hasta el termino de la misma.',
    'route_store_message' => 'Ruta agregada correctamente'
];