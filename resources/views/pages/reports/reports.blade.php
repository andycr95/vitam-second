@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Reportes</h3>
        </div>
        {{ Breadcrumbs::render('reports') }}
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Reportes</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <form action="{{ route('routesReport') }}"  enctype="multipart/form-data"  method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header  primary">
                                <h5 class="modal-title" id="exampleModalLabel">Generar reporte</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <div class="form-group">
                                        @hasanyrole('Empleado')
                                            <label>Tipo de reporte - Interesado</label>
                                            <select class="form-control" name="type_report_c_i" id="type_report_c_i">
                                                <option value="#">Seleccione una opcion</option>
                                                <option value="1">Clientes</option>
                                            </select>
                                        @endhasanyrole
                                        @hasanyrole('Administrador')
                                            <label>Tipo de reporte - Interesado</label>
                                            <select class="form-control" name="type_report_c_i" id="type_report_c_i">
                                                <option value="#">Seleccione una opcion</option>
                                                <option value="1">Clientes</option>
                                                <option value="2">Inversionista</option> 
                                            </select>
                                        @endhasanyrole
                                    </div>
                                    <div class="form-group" id="form_type_report_c_i">
                                        <label id="name_type_report">Tipo de reporte - Tiempo</label>
                                        <select class="form-control" name="type_report_t" id="type_report_t">
                                            <option value="#">Seleccione una opcion</option>
                                            <option value="1">Diario</option>
                                            <option value="2">Semanal</option>
                                            <option value="3">Mensual</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="form-control-i-t">
                                        <div class="form-group" id="form-control-i-c"></div>
                                        <div class="form-group" id="form-control-t"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary btn-sm d-none d-sm-inline-block" role="submit">
                                    <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generar reporte</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/reports.js"></script>
@endpush
