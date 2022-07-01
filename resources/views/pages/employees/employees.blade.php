@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('employees') }}
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Empleados</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 text-nowrap">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-plus"></i> Nueva empleado
                            </button>
                        </div>
                    </div>
                    <div class="col">
                        <form action="{{ route('employees')}}">
                            <div class="input-group form-2 pl-0">
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
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Telefono</th>
                                <th>Sucursal</th>
                                <th>Vehículos</th>
                                <th>Salario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $employee)
                            <tr>
                                <td><a href="{{ route('employee', $employee->id )}}">{{$employee->user->name}} {{$employee->user->last_name}}</a></td>
                                <td>{{$employee->user->address}}</td>
                                <td>{{$employee->user->phone}}</td>
                                @if ($employee->branchoffice == null)
                                    <td><a href="#" data-id="{{$employee->id}}" id="asignBranch" data-toggle="modal" data-target="#asignModal">Asignar</a></td>
                                    <td>0</td>
                                @else
                                    <td>{{$employee->branchoffice->name}}</td>
                                    <td>{{$employee->branchoffice->vehicles->count()}}</td>
                                @endif
                                <td>{{$employee->salary}}</td>
                                <td>
                                    <a class="btn btn-sm btn-danger" data-id="{{$employee->id}}" id="deleteemployee" data-toggle="modal" data-target="#deleteModal">
                                        <i style="color: white;" class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    @if ($employees->total() > 0)
                        <div class="col-md-6 align-self-center">
                            <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{$employees->firstItem()}} a {{$employees->lastItem()}} de {{$employees->total()}}</p>
                        </div>
                        <div class="col-md-6">
                            <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                                <ul class="pagination">
                                    {{$employees->links()}}
                                </ul>
                            </nav>
                        </div>
                    @else

                    @endif
                </div>
            </div>
        </div>
        <!-- MODAL NUEVO -->
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <form action="{{ route('createEmployee') }}"  enctype="multipart/form-data"  method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header  primary">
                            <h5 class="modal-title" id="exampleModalLabel">Nueva empleado</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name"><strong>Nombre</strong></label>
                                        <input class="form-control"  placeholder="Cosme" type="text" name="name" autocomplete="nope"  required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name"><strong>Apellido</strong></label>
                                        <input class="form-control"  placeholder="Fulanito" type="text" name="last_name" autocomplete="nope"  required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Cedula</strong></label>
                                        <input class="form-control"  type="text" id="doc" name="documento" placeholder="1.111.1111" required/>
                                        <div id="form-group-document"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email"><strong>Correo</strong></label>
                                        <input class="form-control"  type="email" id="email" name="email" autocomplete="off"  placeholder="ejemplo@vitamventure.com" required/>
                                        <div id="form-group-email"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Direccion</strong></label>
                                        <input class="form-control"  type="text" name="address" autocomplete="nope" placeholder="Cr 64 #2-54" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone"><strong>Telefono</strong></label>
                                        <input class="form-control"  type="text" name="phone" placeholder="312569888" required/>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="photo"><strong>Foto de perfil</strong></label>
                                        <div class="custom-file">
                                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                            <input type="file" name="photo" class="custom-file-input" id="customFileLang" lang="es">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Salario</strong></label>
                                        <input class="form-control"  type="number" name="salary" placeholder="250.000" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Sucursal</strong></label>
                                        <select id="select-bran" name="branchoffice_id" placeholder="Seleccione una opción..."></select>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><strong>Contraseña</strong></label>
                                        <input class="form-control"  type="password" id="password" name="password" placeholder="******" required/>
                                        <div id="form-group-password"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- MODAL DELETE -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('deleteEmployee') }}" id="deleteForm" enctype="multipart/form-data"  method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="modal-content">
                            <div class="modal-header  primary">
                                <h5 class="modal-title" id="deleteModalLabel">Eliminar empleado</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <h3>¿Seguro de eliminar este empleado?<h3>
                                    <input class="form-control" type="hidden" name="iddelete" id="iddelete"/>
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
        <!-- MODAL ASIGN -->
        <div class="modal fade" id="asignModal" tabindex="-1" role="dialog" aria-labelledby="asignModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('asignBrEmployee') }}"  enctype="multipart/form-data"  method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header  primary">
                            <h5 class="modal-title" id="asignModalLabel">Asignar sucursal</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="form-group">
                                    @if ($branchoffices->count() < 1)
                                    <label for="address"><strong>No hay sucursales</strong></label>
                                    <a type="button" href="{{ route('branchoffices')}}" class="btn btn-primary btn-lg btn-block">Asignar una nueva</a>
                                    @else
                                    <label for="address"><strong>Sucursal</strong></label>
                                    <select id="select-branch2" name="branchoffice_id" placeholder="Seleccione una opción..."></select>
                                    @endif
                                </div>
                                <input class="form-control" type="hidden" name="idasign" id="idasign" required/>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            @if ($branchoffices->count() > 0)
                                <button type="submit" class="btn btn-success">Guardar</button>
                            @else

                            @endif
                        </div>
                    </div>
                </form>
            </div>
    </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/employees.js"></script>
@endpush
