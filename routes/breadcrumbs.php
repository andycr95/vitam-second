<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('home'));
});

Breadcrumbs::for('clients', function ($trail) {
    $trail->parent('home');
    $trail->push('Clientes', route('clients'));
});

Breadcrumbs::for('client', function ($trail, $client) {
    $trail->parent('clients');
    $name = $client->name.' '.$client->last_name;
    $trail->push($name, route('client', $client->id));
});

Breadcrumbs::for('vehicles', function ($trail) {
    $trail->parent('home');
    $trail->push('Vehiculos', route('vehicles'));
});

Breadcrumbs::for('vehicle', function ($trail, $vehicle) {
    $trail->parent('vehicles');
    $trail->push($vehicle->placa, route('vehicle', $vehicle->id));
});

Breadcrumbs::for('branchoffices', function ($trail) {
    $trail->parent('home');
    $trail->push('Sucursales', route('branchoffices'));
});

Breadcrumbs::for('branchoffice', function ($trail, $branchoffice) {
    $trail->parent('branchoffices');
    $trail->push($branchoffice->name, route('branchoffice', $branchoffice->id));
});

Breadcrumbs::for('employees', function ($trail) {
    $trail->parent('home');
    $trail->push('Empleados', route('employees'));
});

Breadcrumbs::for('employee', function ($trail, $employee) {
    $trail->parent('employees');
    $name = $employee->user->name.' '.$employee->user->last_name;
    $trail->push($name, route('employee', $employee->id));
});

Breadcrumbs::for('investors', function ($trail) {
    $trail->parent('home');
    $trail->push('Inversionistas', route('investors'));
});

Breadcrumbs::for('investor', function ($trail, $investor) {
    $trail->parent('investors');
    $name = $investor->user->name.' '.$investor->user->last_name;
    $trail->push($name, route('investor', $investor->id));
});

Breadcrumbs::for('sales', function ($trail) {
    $trail->parent('home');
    $trail->push('Ventas', route('sales'));
});

Breadcrumbs::for('sale', function ($trail, $sale) {
    $trail->parent('sales');
    $name = $sale->vehicle->placa;
    $trail->push($name, route('sale', $sale->id));
});


Breadcrumbs::for('payments', function ($trail) {
    $trail->parent('home');
    $trail->push('Recaudos', route('payments'));
});

Breadcrumbs::for('late-payments', function ($trail) {
    $trail->parent('payments');
    $trail->push('Recaudos retrasados', route('late-payments'));
});

Breadcrumbs::for('reports', function ($trail) {
    $trail->parent('home');
    $trail->push('Reportes', route('reports'));
});
