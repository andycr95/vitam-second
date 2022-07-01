@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @foreach ($employee as $employee)
    {{ Breadcrumbs::render('employee', $employee) }}
    <div class="row mb-3">
        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body text-center shadow">
                    @if ($employee->user->photo == '')
                        <img class="rounded-circle mb-3 mt-4" src="/img/avatars/avatar1.jpeg" width="160" height="160">
                    @else
                        <img class="rounded-circle mb-3 mt-4" src="/storage/{{$employee->user->photo}}" width="160" height="160">
                    @endif
                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#exampleModal">Cambiar foto</button></div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Información de usuario</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('updateEmployee') }}"  enctype="multipart/form-data"  method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="first_name"><strong>Nombre</strong></label>
                                            <input disabled class="form-control" type="text" value="{{$employee->user->name}}" name="first_name">
                                            <input type="hidden" value="{{$employee->user_id}}" name="id">
                                            <input type="hidden" value="{{$employee->id}}" name="idemployee">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="last_name"><strong>Apellido</strong></label>
                                            <input disabled class="form-control" type="text" value="{{$employee->user->last_name}}" name="last_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address"><strong>Cedula</strong></label>
                                    <input class="form-control" type="text" disabled name="document" value="{{$employee->user->documento}}"/>
                                    <div id="form-group-document"></div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="password"><strong>Contraseña</strong></label>
                                        <input class="form-control" type="password" id="pass"  value="" disabled name="password">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="email"><strong>Email Address</strong></label>
                                            <input class="form-control" disabled type="email" value="{{$employee->user->email}}" name="email">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="address"><strong>Dirección</strong></label>
                                    <input class="form-control" type="text" disabled value="{{$employee->user->address}}" name="address">
                                </div>
                                <div class="form-row">
                                    @if ($employee->branchoffice != null)
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="city"><strong>Ciudad</strong></label>
                                                <input name="city" class="form-control" value="{{$employee->branchoffice->city->name}}" disabled>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="address"><strong>Sucursal</strong></label>
                                                <select name="branch" class="form-control" disabled>
                                                    <option value="{{$employee->branchoffice_id}}">{{$employee->branchoffice->name}}</option>
                                                    @foreach ($branchoffices as $branchoffice)
                                                        <option value="{{$branchoffice->id}}">{{$branchoffice->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div id="modal-buttons" class="form-group">
                                    <button disabled id="employeesave" class="btn btn-primary btn-sm" type="submit">Guardar</button>
                                    <button class="btn btn-info btn-sm" id="employeeUpdate" type="button"><span>Actualizar</span></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- MODAL PHOTO -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('updatePhoto') }}"  enctype="multipart/form-data"  method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header  primary">
                        <h5 class="modal-title" id="exampleModalLabel">Cambiar foto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="custom-file">
                                <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                                <input type="file" name="photo" class="custom-file-input" id="customFileLang" lang="es">
                            </div>
                            <input type="hidden" name="id" value="{{$employee->user->id}}"/>
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
</div>
@endsection
@push('scripts')
    <script src="/js/employees.js"></script>
@endpush
