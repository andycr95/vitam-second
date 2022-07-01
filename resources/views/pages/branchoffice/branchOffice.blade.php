@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('branchoffices') }}
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Sucursales</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 text-nowrap">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Nueva sucursal
                            </button>
                        </div>
                    </div>
                    <div class="col">
                        <form action="{{ route('branchoffices')}}">
                            <div class="input-group form-2 pl-0">
                                <input autocomplete="nope"  class="form-control my-0 py-1 red-border" type="text" placeholder="Search" name="buscar" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="input-group-text" style="background-color: #1cc88a; color: white;" type="submit" ><i class="fas fa-search text-grey" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br/>
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table dataTable my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Ciudad</th>
                                <th>Encargado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($branchoffices as $branchoffice)
                            <tr>
                                <td><a href="{{ route('branchoffice', $branchoffice->id )}}">{{$branchoffice->name}}</a></td>
                                <td>{{$branchoffice->address}}</td>
                                <td>{{$branchoffice->city->name}}</td>
                                <td>{{$branchoffice->employee->user->name}} {{$branchoffice->employee->user->last_name}}</td>
                                <td>
                                    <a class="btn btn-sm btn-danger" data-id="{{$branchoffice->id}}" id="deletebranch" data-toggle="modal" data-target="#deleteModal">
                                        <i style="color: white;" class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    @if ($branchoffices->total() > 0)
                        <div class="col-md-6 align-self-center">
                            <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{$branchoffices->firstItem()}} a {{$branchoffices->lastItem()}} de {{$branchoffices->total()}}</p>
                        </div>
                        <div class="col-md-6">
                            <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                <ul class="pagination">
                                    {{$branchoffices->links()}}
                                </ul>
                            </nav>
                        </div>
                    @else

                    @endif
                </div>
            </div>
        </div>
        <!-- MODAL NUEVO -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('createBranch') }}" id="createBranch"  enctype="multipart/form-data"  method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header  primary">
                            <h5 class="modal-title" id="exampleModalLabel">Nueva sucursal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name"><strong>Nombre</strong></label>
                                <input autocomplete="nope"  class="form-control" placeholder="Nueva granada" type="text" name="name" required/>
                            </div>
                            <div class="form-group">
                                <label for="address"><strong>Direccion</strong></label>
                                <input autocomplete="nope"  class="form-control" type="text" name="address" placeholder="Cr 64 #2-54" required/>
                            </div>
                            <input autocomplete="nope"  type="hidden" name="state" value="activo"/>
                            <div class="form-group">
                                <label for="employee"><strong>Encargado</strong></label>
                                <input autocomplete="nope"  type="hidden" id="employees" value="{{$employees->count()}}"/>
                                @if ($employees->count() > 0)
                                    <select name="employee_id" id="employee_id" class="form-control" required>
                                        <option disabled selected value="#">Selecciona una opción</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->user->name}} {{$employee->user->last_name}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <a href="{{ route('employees')}}">Agregue un empleado</a>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="city"><strong>Ciudad</strong></label>
                                <select name="city_id" id="city_id"  class="form-control" required>
                                    <option disabled selected value="#">Selecciona una opción</option>
                                    @foreach ($city as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="button" id="save" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- MODAL Delete -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('deleteBranchoffice') }}" id="deleteform"  enctype="multipart/form-data"  method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-content">
                            <div class="modal-header  primary">
                                <h5 class="modal-title" id="deleteModalLabel">Eliminar sucursal</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <h3>¿Seguro de eliminar este sucursal?<h3>
                                    <input autocomplete="nope"  class="form-control" type="hidden" name="id" id="iddelete" required/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="button" id="deleteButton" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/branchoffice.js"></script>
@endpush
