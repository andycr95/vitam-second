@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @foreach ($vehicle as $vehicle)
    {{ Breadcrumbs::render('vehicle', $vehicle) }}
    <div class="row mb-3">
        <div class="col-lg-5">
            @if (count($payments) > 0)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary font-weight-bold m-0">{{$vehicle->placa}}<span class="float-right">{{$payments->count()}} pagos</span></h6>
                    </div>
                    <div class="card-body">
                        <div class="progress progress-sm mb-3"> 
                            @if ($vehicle->amount != null)
                                @if (($payments->count()/$vehicle->amount)*100 <= 20)
                                    <div class="progress-bar bg-danger" aria-valuenow="{{($payments->count()/$vehicle->amount)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($payments->count())/$vehicle->amount)*100 }}%;">
                                        <span class="sr-only">{{ (($payments->count())/$vehicle->amount)*100 }}</span>
                                    </div>
                                @elseif(($payments->count()/$vehicle->amount)*100 > 20 && ($payments->count()/$vehicle->amount)*100 < 50)
                                    <div class="progress-bar bg-warning" aria-valuenow="{{($payments->count()/$vehicle->amount)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($payments->count())/$vehicle->amount)*100 }}%;">
                                        <span class="sr-only">{{ (($payments->count())/$vehicle->amount)*100 }}</span>
                                    </div>
                                @elseif(($payments->count()/$vehicle->amount)*100 > 50 && ($payments->count()/$vehicle->amount)*100 < 70)
                                    <div class="progress-bar bg-primary" aria-valuenow="{{($payments->count()/$vehicle->amount)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($payments->count())/$vehicle->amount)*100 }}%;">
                                        <span class="sr-only">{{ (($payments->count())/$vehicle->amount)*100 }}</span>
                                    </div>
                                @elseif(($payments->count()/$vehicle->amount)*100 > 70 && ($payments->count()/$vehicle->amount)*100 < 100)
                                    <div class="progress-bar bg-info" aria-valuenow="{{($payments->count()/$vehicle->amount)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($payments->count())/$vehicle->amount)*100 }}%;">
                                        <span class="sr-only">{{ (($payments->count())/$vehicle->amount)*100 }}</span>
                                    </div>
                                @elseif(($payments->count()/$vehicle->amount)*100 == 100)
                                    <div class="progress-bar bg-success" aria-valuenow="{{($payments->count()/$vehicle->amount)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($payments->count())/$vehicle->amount)*100 }}%;">
                                        <span class="sr-only">{{ (($payments->count())/$vehicle->amount)*100 }}</span>
                                    </div>
                                @endif
                            @endif
                        </div>
                        <div style="max-height: 300px; overflow-y: auto;">
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
                                        <td><p class="text-muted" style="font-size: 12px;">&nbsp;{{($pay->created_at)->diffForhumans()}}</p></td>
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
            <div class="card shadow mb-4">
                    <div class="card-body">
                        @if ($photo != false)
                            @foreach ($photos as $photo)
                                @if ($photo->photo1 == null)

                                @else
                                    <img class="mb-3 mt-4" src="/storage/{{$photo->photo1}}"  id="photo1" alt="{{$vehicle->placa}}" width="160" height="160">
                                @endif
                                @if ($photo->photo2 == null)
                                    <form action="{{ route('updatePhotovehicle') }}" id="form1" enctype="multipart/form-data"  method="POST">
                                        @csrf
                                        @method('PATCH')
                                            <input type="file" class="btn btn-primary btn-block" name="photo2" id="photo1" value="Agregar foto 2" />
                                            <input type="hidden" name="id" value="{{$vehicle->id}}"/>
                                    </form><br>
                                @else
                                    <img class="mb-3 mt-4" alt="{{$vehicle->placa}}" id="photo2" src="/storage/{{$photo->photo2}}" width="160" height="160">
                                @endif
                                @if ($photo->photo3 == null)
                                    <form action="{{ route('updatePhotovehicle') }}" id="form2" enctype="multipart/form-data"  method="POST">
                                        @csrf
                                        @method('PATCH')
                                            <input type="file" class="btn btn-primary btn-block"  name="photo3" id="photo2" value="Agregar foto 3" />
                                            <input type="hidden" name="id" value="{{$vehicle->id}}"/>
                                    </form>
                                @else
                                    <img class="mb-3 mt-4" alt="{{$vehicle->placa}}"  id="photo3" src="/storage/{{$photo->photo3}}" width="160" height="160">
                                @endif
                            @endforeach
                        @else
                            <h4>No tiene fotos</h4>
                            <form action="{{ route('updatePhotovehicle') }}" id="form"  enctype="multipart/form-data"  method="POST">
                                @csrf
                                @method('PATCH')
                                    <input type="file" class="btn btn-primary btn-block" value="Agregar" name="photo1" id="photo" value="Agregar foto 1"/>
                                    <input type="hidden" name="id" value="{{$vehicle->id}}"/>
                            </form>
                        @endif
                    </div>
                </div>
        </div>
        <div class="col-lg-7">
            <div class="row">
                <div class="col">
                    <div class="card shadow mb-3">
                        <div class="card-header py-3">
                            <p class="text-primary m-0 font-weight-bold">Información del vehiculo</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('updateVehicle', $vehicle->id) }}"  enctype="multipart/form-data"  method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="placa"><strong>Placa</strong></label>
                                            <input disabled class="form-control" type="text" value="{{$vehicle->placa}}" name="placa" required>
                                            <input type="hidden" value="{{$vehicle->id}}" name="id">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="model"><strong>Modelo</strong></label>
                                            <input disabled class="form-control" id="model" type="text" value="{{$vehicle->model}}" name="model" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="color"><strong>Color</strong></label>
                                            <input disabled class="form-control" id="color" type="text" value="{{$vehicle->color}}" name="color" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col">
                                            <label for="color"><strong>Precio</strong></label>
                                            <input disabled class="form-control" id="fee" type="text" value="{{$vehicle->fee}}" name="fee" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col">
                                            <label for="amount"><strong>Dias</strong></label>
                                            <input disabled class="form-control" id="amount" type="number" value="{{$vehicle->amount}}" name="amount" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="motor"><strong>Motor</strong></label>
                                        <input class="form-control" type="text" value="{{$vehicle->motor}}" id="motor" disabled name="motor" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="chasis"><strong>Chasis</strong></label>
                                        <input class="form-control" type="text" value="{{$vehicle->chasis}}" id="chasis" disabled name="chasis" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="investor"><strong>Propietario</strong></label>
                                            <select class="form-control" type="text" id="investor" disabled name="investor" required>
                                                <option value="{{$vehicle->investor->id}}">{{$vehicle->investor->user->name}} {{$vehicle->investor->user->last_name}}</option>
                                                @foreach ($investors as $iv)
                                                    <option value="{{$iv->id}}">{{$iv->user->name}} {{$iv->user->last_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="branchoffice"><strong>Sucursal</strong></label>
                                            <select class="form-control" type="text" id="branchoffice" disabled name="branchoffice" required>
                                                <option value="{{$vehicle->branchoffice->id}}">{{$vehicle->branchoffice->name}}</option>
                                                @foreach ($branchoffices as $bc)
                                                    <option value="{{$bc->id}}">{{$bc->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="modal-buttons" class="form-group">
                                    <button disabled id="vehicleSave" class="btn btn-primary btn-sm" type="submit">Guardar</button>
                                    <button class="btn btn-info btn-sm" id="vehicleUpdate" type="button"><span>Actualizar</span></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <div id="myModal" class="modalphoto">
        <!-- The Close Button -->
        <span id="close" class="close">&times;</span>
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">
        <!-- Modal Caption (Image Text) -->
        <div id="caption"></div>
    </div>
</div>
<form action="{{ route('ticketPayment') }}" id="ticketpaymentForm" enctype="multipart/form-data"  method="POST">
        @csrf
          <input type="hidden" name="id" id="idticket">
    </form>
@endsection
@push('scripts')
    <script src="/js/sale.js"></script>
    <script src="/js/vehicle.js"></script>
    <script src="/js/photos.js"></script>
@endpush
