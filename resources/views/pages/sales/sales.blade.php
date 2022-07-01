@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('sales') }}
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Ventas</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 text-nowrap">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#saleModal">
                                <i class="fa fa-plus"></i> Realizar una venta
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('sales')}}">
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
                                <th>Codigo</th>
                                <th>Cliente</th>
                                <th>Vehiculo</th>
                                <th>Sucursal</th>
                                <th>Fecha</th>
                                <th>Tipo de venta</th>
                                <th>Estado</th>
                                <th>Cuota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                            <tr>
                                @if ($sale->id < 10)
                                    <td><a href="{{ route('sale', $sale->id )}}">00{{$sale->id}}</a></td>
                                @elseif ($sale->id < 100)
                                    <td><a href="{{ route('sale', $sale->id )}}">0{{$sale->id}}</a></td>
                                @else
                                    <td><a href="{{ route('sale', $sale->id )}}">{{$sale->id}}</a></td>
                                @endif
                                <td>{{$sale->client->name}} {{$sale->client->last_name}}</td>
                                <td>{{$sale->vehicle->placa}}</td>
                                <td>{{$sale->branchoffice->name}}</td>
                                <td>{{$sale->date}}</td>
                                <td>{{$sale->typesale->name}}</td>
                                @if ($sale->state == 1)
                                    <td><span class="badge badge-primary">En proceso</span></td>
                                @else
                                    <td><span class="badge badge-success">Terminada</span></td>
                                @endif
                                <td class="precio">{{$sale->fee}}</td>
                                <td>
                                    <a class="btn btn-sm btn-danger" data-id="{{$sale->id}}" id="deleteSale" data-toggle="modal" data-target="#deleteModal">
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
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{$sales->firstItem()}} a {{$sales->lastItem()}} de {{$sales->total()}}</p>
                    </div>
                    <div class="col-md-6">
                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                {{$sales->links()}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- MODAL Sale -->
    <div class="modal fade" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="saleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('salevehicleclient') }}"  enctype="multipart/form-data"  method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header  primary">
                            <h5 class="modal-title" id="saleModalLabel">Vender un vehiculo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="address"><strong>Cliente</strong></label>
                                @if ($clients->count() > 0)
                                    <select id="select-client" name="client_id" placeholder="Seleccione una opción..."></select>
                                @else
                                    <a href="{{ route('clients')}}">Agregue un Cliente</a>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="address"><strong>Vehiculo</strong></label>
                                @if ($vehicles->count() > 0)
                                    <select id="select-vehi" name="vehicle_id" placeholder="Seleccione una opción..."></select>
                                @else
                                    <a href="{{ route('vehicles')}}">Agregue un vehiculo</a>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="address"><strong>Tipo de pago</strong></label>
                                <select name="typesale_id" class="form-control" required>
                                    <option>Seleccione una opción</option>
                                    @foreach ($typeSales as $typesale)
                                        <option value="{{$typesale->id}}">{{$typesale->name}}</option>
                                    @endforeach
                                </select>
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
            <!-- MODAL Delete -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{ route('deleteSale') }}"  enctype="multipart/form-data"  method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header  primary">
                                <h5 class="modal-title" id="deleteModalLabel">Terminar venta</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <h3>¿Seguro de terminar esta venta?<h3>
                                    <input class="form-control" type="hidden" name="id" id="iddelete" required/>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Eliminar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
@endsection
@push('scripts')
    <script src="/js/sale.js"></script>
@endpush
