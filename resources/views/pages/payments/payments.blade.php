@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('payments') }}
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-8 text-nowrap">
                        <p class="text-primary m-0 font-weight-bold">Recaudos</p>
                    </div>
                    <div class="col-md-4" style="text-align: end;">
                        <a class="btn btn-danger btn-sm d-none d-sm-inline-block" role="button" href="{{route('late-payments')}}">
                            <i class="fa fa-clock-o text-white-50"></i>&nbsp;Recuados retrasados
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8 text-nowrap">
                        <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                            <button class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#payModal">
                                <i class="fa fa-plus"></i> Registrar pago
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('payments')}}">
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
                                <th>Vehiculo</th>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Tipo</th>
                                <th></th>
                                @hasrole('Administrador')
                                    <th>Acciones</th>
                                @endhasrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                            <tr>
                                <td><a href="{{ route('sale', $payment->sale_id )}}">{{$payment->vehicle->placa}}</a></td>
                                <td>{{$payment->sale->client->name}} {{$payment->sale->client->last_name}}</td>
                                <td class="precio">{{$payment->amount}}</td>
                                <td>{{$payment->type}}</td>
                                <td>{{($payment->created_at)->diffForhumans()}}</td>
                                <td>
                                    @hasrole('Administrador')
                                        <a class="btn btn-sm btn-danger" data-id="{{$payment->id}}" data-placa="{{$payment->sale->vehicle->placa}}" id="deletepayment">
                                            <i style="color: white;" class="fas fa-trash"></i>
                                        </a>
                                    @endhasrole
                                        <a class="btn btn-sm btn-success" data-id="{{$payment->id}}" data-placa="{{$payment->sale->vehicle->placa}}" id="ticketpayment">
                                            <i style="color: white;" class="fas fa-hand-holding-usd"></i>
                                        </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-6 align-self-center">
                        <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Mostrando {{$payments->firstItem()}} a {{$payments->lastItem()}} de {{$payments->total()}}</p>
                    </div>
                    <div class="col-md-6">
                        <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                            <ul class="pagination">
                                {{$payments->links()}}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('createPayment') }}" id="paymentForm" enctype="multipart/form-data"  method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header  primary">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Pago</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="address"><strong>Vehiculo</strong></label>
					        <select id="select-tools" name="vehicle_id" placeholder="Seleccione una opción..."></select>
                        </div>
                        <div class="form-group">
                            <label for="type"><strong>Tipo</strong></label>
                            <select id="type" name="type" class="form-control" disabled required>
                                <option value="#">Seleccione una opción</option>
                                <option value="pago">Pago</option>
                                <option value="abono">Abono</option>
                            </select>
                        </div>
                        <div id="amount" class="form-group">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="saveButton" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <form action="{{ route('deletePayment') }}" id="deletepaymentForm" enctype="multipart/form-data"  method="POST">
        @csrf
          <input type="hidden" name="id" id="iddelete">
    </form>
    <form action="{{ route('testticketPayment') }}" id="testpaymentForm" enctype="multipart/form-data"  method="POST">
        @csrf
          <input type="hidden" name="id" id="idtest">
    </form>
    <form action="{{ route('ticketPayment') }}" id="ticketpaymentForm" enctype="multipart/form-data"  method="POST">
        @csrf
          <input type="hidden" name="id" id="idticket">
    </form>
@endsection
@push('scripts')
    <script src="/js/payment.js"></script>
@endpush
