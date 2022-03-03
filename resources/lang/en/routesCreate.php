<?php

return [
    //Form validations
    'salida_required' => 'The field "Exit place" is required.',
    'salida_min' => 'The field "Exit" must contain at least 3 characters.',
    'fecha_salida_required' => 'The field "Exit date" is required.',
    'destino_required' => 'The field "Destination place" is required.',
    'destino_min' => 'The field "Destination place" must contain at least 3 characters.',
    'fecha_destino_required' => 'The field "Arrival date" is required.',
    'fecha_destino_after_or_equal' => 'The field "Arrival date" cannot be before "Exit date".',
    'descripcion_required' => 'The field "Description" is required.',
    'unidad_required' => 'Routes cannot be registered without a unit assigned.',
    'operator_required' => 'Routes cannot be registered without a operator assigned.',
    'contenedores_required' => 'Routes must have at least one container assigned.',
    'equipment_required' => 'Routes must have at least one restraint equipment assigned.',
    
    // Form labels
    'add_route' => 'Add route',
    'departure_location' => 'Departure location:',
    'departure_date' => 'Departure date:',
    'arrival_location' => 'Arrival location:',
    'destination_date' => 'Estimated arrival date:',
    'description' => 'Description:',
    'unit' => 'Unit:',
    'unit_licence_plate' => 'Licence plate of the unit to be used on this route',
    'operator' => 'Operator:',
    'restraint_equipment' => 'Restraint equipment to be used on this route:',
    'container_licence_plates' => 'Licence plates of the containers to be used on this route:',
    'images' => 'Inital images to be used on this route:',
    'select_operator' => 'Select the operator assigned for this route',
    'select_unit' => 'Select the licence plate of the unit to be used on this route',
    'select_container' => 'Select a container',
    'select_equipment' => 'Select a restraint equipment',
    'equipment_available' => 'Theres no restraint equipment available',
    'container_available' => 'Theres no containers available',

    // Form Buttons
    'route_create_add_route_btn' => 'Add route',
    'route_create_add_container_btn' => 'Add container',
    'route_create_remove_container_btn' => 'Remove container',
    'route_create_add_restraint_equipment' => 'Add restraint equipment',
    'route_create_remove_restraint_equipment' => 'Remove restraint equipment',
    'route_create_add_image' => 'Add image',
    'route_create_remove_image' => 'Remove image',

    // Submit alert
    'route_create_submit_alert_title' => 'Are you sure?',
    'route_create_submit_alert_confirm' => 'Confirm',
    'route_create_submit_alert_cancel' => 'Cancel',
    'route_create_submit_alert_body' => 'Verify that the data is correct, once a route is registered its data can no longer be modified until the end of it.',
    'route_store_message' => 'Route added succesfully'
];