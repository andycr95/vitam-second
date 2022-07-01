@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('vehicles') }}
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Vehiculos</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 text-nowrap">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Nuevo vehiculo
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('vehicles')}}">
                            <div class="input-group md-form form-sm form-2 pl-0">
                                <input class="form-control my-0 py-1 red-border" type="text" placeholder="Search" name="buscar" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="input-group-text" style="background-color: #1cc88a; color: white;" type="submit" ><i class="fas fa-search text-grey" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table dataTable my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Placa</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Motor</th>
                                <th>Chasis</th>
                                <th>Condición</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehicles as $vehicle)
                            <tr>
                                <td><a href="{{ route('vehicle', $vehicle->id )}}">{{$vehicle->placa}}</a></td>
                                <td>{{$vehicle->model}}</td>
                                <td>{{$vehicle->color}}</td>
                                <td>{{$vehicle->motor}}</td>
                                <td>{{$vehicle->chasis}}</td>
                                @if ($vehicle->state == 0)
                                    <td><span class="badge badge-success">Vendida</span></td>
                                @else
                                    <td><span class="badge badge-primary">Por vender</span></td>
                                @endif
                                <td>{{$vehicle->type->name}}</td>
                                <td>
                                    <a class="btn btn-sm btn-danger" data-id="{{$vehicle->id}}" data-state="{{$vehicle->state}}" id="deletevehicle" data-toggle="modal" data-target="#deleteModal">
                                        <i style="color: white;" class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{$vehicles->firstItem()}} a {{$vehicles->lastItem()}} de {{$vehicles->total()}}</p>
                    </div>
                    <div class="col-md-6">
                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                {{$vehicles->links()}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL NUEVO -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="createForm" action="{{ route('createVehicle') }}"  enctype="multipart/form-data"  method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header  primary">
                            <h5 class="modal-title" id="exampleModalLabel">Nuevo Vehiculo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name"><strong>Placa</strong></label>
                                        <input class="form-control" placeholder="ABC-123" id="placa" type="text" name="placa"  required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><strong>Modelo</strong></label>
                                        <input class="form-control" type="number" name="model" placeholder="2018" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Color</strong></label>
                                        <input class="form-control" type="text" name="color" placeholder="Azul" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Chasis</strong></label>
                                        <input class="form-control" type="text" id="chasis" name="chasis" placeholder="36584" required/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="phone"><strong>Motor</strong></label>
                                        <input class="form-control" type="number" id="motor" name="motor" placeholder="258693" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone"><strong>Precio</strong></label>
                                        <input class="form-control" type="number" name="fee" placeholder="258693" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Propietario</strong></label>
                                        @if ($investors->count() > 0)
                                            <select id="select-investor" name="investor_id" placeholder="Seleccione una opción..."></select>
                                        @else
                                            <a href="{{ route('investors')}}">Agregue un invesionista</a>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Estado</strong></label>
                                        <select name="type_id" id="type_id" class="form-control" placeholder="Seleccione una opción" required>
                                            @foreach ($types as $type)
                                                <option value="{{$type->id}}">{{$type->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="groupAmount" class="form-group">

                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Sucursal</strong></label>
                                        @if ($branchoffices->count() > 0)
                                            <select id="select-branch" name="branchoffice_id" placeholder="Seleccione una opción..."></select>
                                        @else
                                            <a href="{{ route('branchoffices')}}">Agregue una sucursal</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" id="vehicleSave" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- MODAL Delete -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('deleteVehicle') }}" id="deleteform"  enctype="multipart/form-data"  method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-content">
                            <div class="modal-header  primary">
                                <h5 class="modal-title" id="deleteModalLabel">Eliminar Vehiculo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <h3>¿Seguro de eliminar este vehiculo?<h3>
                                    <input class="form-control" type="hidden" name="id" id="id" required/>
                                    <input class="form-control" type="hidden" name="state" id="state" required/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="button" id="deleteButton" class="btn btn-success">Eliminar</button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/vehicle.js"></script>
@endpush
