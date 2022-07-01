@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @foreach ($branchoffice as $branchoffice)
    {{ Breadcrumbs::render('branchoffice', $branchoffice) }}
    <h3 class="text-dark mb-4">Sucursal - {{$branchoffice->name}}</h3>
    <div class="row mb-3">
        <div class="col-lg-4">
            @if ($branchoffice->vehicles->count() > 0)
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="text-primary font-weight-bold m-0">Vehiculos</h6>
                </div>
                <div class="card-body scroll_s">
                    @foreach ($branchoffice->vehicles as $vehicle)
                        <h4 class="small font-weight-bold">{{$vehicle->placa}}
                        @if ($vehicle->state == 0)
                            <span class="badge badge-success float-right">Vendida</span>
                        @else
                            <span class="badge badge-primary float-right">Por vender</span>
                        @endif
                    </h4>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary font-weight-bold m-0">Empleados</h6>
                    </div>
                    <div class="card-body">
                        <table class="table dataTable my-0 scroll_s" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($branchoffice->employees  as $employee)
                                <tr>
                                    <td>{{$employee->user->name}} {{$employee->user->last_name}}</td>
                                    <td>{{$employee->user->phone}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Información de sucursal</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('updateBranchoffice', $branchoffice->id) }}" id="updateBranchofficeForm" enctype="multipart/form-data"  method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="first_name"><strong>Nombre</strong></label>
                                            <input disabled class="form-control" type="text" value="{{$branchoffice->name}}" name="first_name">
                                            <input type="hidden" value="{{$branchoffice->id}}" name="id">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="encargado"><strong>Encargado</strong></label>
                                            <select name="encargado" id="employee" class="form-control" disabled>
                                            <option style="color: red;" value="{{$branchoffice->employee_id}}">{{$branchoffice->employee->user->name}}</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{$employee->id}}">{{$employee->user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="address"><strong>Dirección</strong></label>
                                            <input class="form-control" type="text" disabled value="{{$branchoffice->address}}" name="address">
                                            <input type="hidden" value="{{$branchoffice->employee_id}}" name="last_e">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="city"><strong>Ciudad</strong></label>
                                            <select name="city" class="form-control" disabled>
                                            <option style="color: red;" value="{{$branchoffice->city_id}}">{{$branchoffice->city->name}}</option>
                                                @foreach ($cities as $city)
                                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="modal-buttons" class="form-group">
                                <button disabled id="branchSave" data-id="{{$branchoffice->employee_id}}" class="btn btn-primary btn-sm" type="button">Guardar</button>
                                    <button class="btn btn-info btn-sm" id="branchUpdate" type="button"><span>Actualizar</span></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
@push('scripts')
    <script src="/js/branchoffice.js"></script>
@endpush
