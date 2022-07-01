@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <?php setlocale(LC_TIME, 'Spanish');      ?>
    @foreach ($sale as $sale)
    {{ Breadcrumbs::render('sale', $sale) }}
    <div class="row">
        <div class="col-lg-5">
            @if (count($allPayments) > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary font-weight-bold m-0"><span class="float-right">{{$payments->count()}} pagos</span></h6>
                    </div>
                    <div class="card-body">
                        <div style="max-height: 350px; overflow-y: auto;">
                            <table class="table dataTable my-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Monto</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allPayments as $pay)
                                    <tr>
                                        <td>
                                            @if ($pay->type == 'pago')
                                                <h4 style="font-size: 14px;"><span class="badge badge-success">Pago</span></h4></td>
                                            @else
                                                <h4 style="font-size: 14px;"><span class="badge badge-info">Abono</span></h4></td>
                                            @endif
                                        <td><span class="h3" style="font-size: 14px;">${{$pay->amount}}</span><br /><strong></strong></td>
                                        <td><p class="text-muted" style="font-size: 12px;">&nbsp;{{($pay->created_at)->formatLocalized('%Y-%B-%d  %H:%M:%S')}}</p></td>
                                        <td>
                                            <a class="btn btn-sm btn-success" data-id="{{$pay->id}}" data-placa="{{$pay->sale->vehicle->placa}}" id="ticketpayment">
                                                <i style="color: white;" class="fas fa-hand-holding-usd"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-7">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-12">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Información de venta</p>
                            <label for="fee"><strong>   Estado</strong></label>
                            @if ($sale->state == 1)
                                <span class="badge badge-primary">En proceso</span>
                            @else
                                <span class="badge badge-success">Terminada</span>
                            @endif
                        </div>
                        <div class="card-body">
                            <form action=""  enctype="multipart/form-data"  method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="first_name"><strong>Cliente</strong></label>
                                            <input disabled class="form-control" type="text" value="{{$sale->client->name}} {{$sale->client->last_name}}" name="first_name">
                                            <input type="hidden" value="{{$sale->id}}" name="id">
                                        </div>
                                    </div> 
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="branchoffice_id"><strong>Sucursal</strong></label>
                                            <select name="branchoffice_id" class="form-control" disabled>
                                            <option style="color: red;" value="{{$sale->branchoffice_id}}">{{$sale->branchoffice->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="date"><strong>Fecha de venta</strong></label>
                                            <input class="form-control" type="text" disabled value="{{$sale->date}}" name="date">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="placa"><strong>Placa del vehiculo</strong></label>
                                            <input class="form-control" type="text" disabled value="{{$sale->vehicle->placa}}" name="placa">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fee"><strong>Coutas faltantes</strong></label>
                                            <input class="form-control" type="text" disabled value="{{$sale->amount - $payments->count()}}" name="fee">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fee"><strong>Tipo de venta</strong></label>
                                            <input class="form-control" type="text" disabled value="{{$sale->typesale->name}}" name="fee">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="fee"><strong>Couta</strong></label>
                                            <input class="form-control precio" type="text" disabled value="{{$sale->fee}}" name="fee">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    @if ($allPayments->count() > 0)
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="fee"><strong>Ultimo pago</strong></label>
                                                <input class="form-control" type="text" disabled value="{{($payment->created_at)->diffForhumans()}}" name="fee">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <form action="{{ route('ticketPayment') }}" id="ticketpaymentForm" enctype="multipart/form-data"  method="POST">
        @csrf
          <input type="hidden" name="id" id="idticket">
    </form>
</div>
@endsection
@push('scripts')
    <script src="/js/sale.js"></script>
@endpush
