@extends('layouts.app')

@section('content')
<div class="container-fluid">
    @foreach ($client as $client)
    {{ Breadcrumbs::render('client', $client) }}
    <div class="row mb-3">
        <div class="col-lg-5">
            <div class="card mb-3">
                <div class="card-body text-center shadow">
                    @if ($client->photo == '')
                        <img class="rounded-circle mb-3 mt-4" src="/img/avatars/avatar1.jpeg" width="160" height="160">
                    @else
                        <img class="rounded-circle mb-3 mt-4" src="/storage/{{$client->photo}}" width="160" height="160">
                    @endif
                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#exampleModal">Cambiar foto</button></div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="text-primary font-weight-bold m-0">Vehiculos</h6>
                </div>
                <div class="card-body">
                    @if ($client->sales->count() > 0)
                        @foreach ($client->sales as $sale)
                            <h4 class="small font-weight-bold">{{$sale->vehicle->placa}}<span class="float-right">{{$sale->vehicle->payments->count()}} pagos</span></h4>
                            <div class="progress progress-sm mb-3">
                                @if ($sale->vehicle->payments->count() <= 20)
                                    <div class="progress-bar bg-danger" aria-valuenow="{{$sale->vehicle->payments->count()}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ $sale->vehicle->payments->count()}}%;">
                                        <span class="sr-only">{{ $sale->vehicle->payments->count() }}</span>
                                    </div>
                                @elseif(($sale->vehicle->payments->count()/$sale->vehicle->amount)*100 > 20 && ($sale->vehicle->payments->count()/$sale->vehicle->amount)*100 < 50)
                                    <div class="progress-bar bg-warning" aria-valuenow="{{($sale->vehicle->payments->count()/$sale->vehicle->amount)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($sale->vehicle->payments->count())/$sale->vehicle->amount)*100 }}%;">
                                        <span class="sr-only">{{ (($sale->vehicle->payments->count())/$sale->vehicle->amount)*100 }}</span>
                                    </div>
                                @elseif(($sale->vehicle->payments->count()/$sale->vehicle->amount)*100 > 50 && ($sale->vehicle->payments->count()/$sale->vehicle->amount)*100 < 70)
                                    <div class="progress-bar bg-primary" aria-valuenow="{{($sale->vehicle->payments->count()/$sale->vehicle->amount)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($sale->vehicle->payments->count())/$sale->vehicle->amount)*100 }}%;">
                                        <span class="sr-only">{{ (($sale->vehicle->payments->count())/$sale->vehicle->amount)*100 }}</span>
                                    </div>
                                @elseif(($sale->vehicle->payments->count()/$sale->vehicle->amount)*100 > 70 && ($sale->vehicle->payments->count()/$sale->vehicle->amount)*100 < 100)
                                    <div class="progress-bar bg-info" aria-valuenow="{{($sale->vehicle->payments->count()/$sale->vehicle->amount)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($sale->vehicle->payments->count())/$sale->vehicle->amount)*100 }}%;">
                                        <span class="sr-only">{{ (($sale->vehicle->payments->count())/$sale->vehicle->amount)*100 }}</span>
                                    </div>
                                @elseif(($sale->vehicle->payments->count()/$sale->vehicle->amount)*100 == 100)
                                    <div class="progress-bar bg-success" aria-valuenow="{{($sale->vehicle->payments->count()/$sale->vehicle->amount)*100}}" aria-valuemin="0" aria-valuemax="100" style="width: {{ (($sale->vehicle->payments->count())/$sale->vehicle->amount)*100 }}%;">
                                        <span class="sr-only">{{ (($sale->vehicle->payments->count())/$sale->vehicle->amount)*100 }}</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <h4>No tiene Vehiculos</h4>
                        <button type="button" data-toggle="modal" data-target="#saleModal" class="btn btn-primary btn-lg btn-block">Vender un vehiculo</button>
                    @endif
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-body">
                    @if ($photo != false)
                        @foreach ($photos as $photo)
                            @if ($photo->photo1 == null)

                            @else
                                <img class="mb-3 mt-4" src="/storage/{{$photo->photo1}}" id="photo1" alt="Foto client {{$client->id}}" width="160" height="160">
                            @endif
                            @if ($photo->photo2 == null)
                                <form action="{{ route('updatePhotoClient') }}" id="form1" enctype="multipart/form-data"  method="POST">
                                    @csrf
                                    @method('PATCH')
                                        <input type="file" class="btn btn-primary btn-block"  name="photo2" id="photo1" value="Agregar foto 2" />
                                        <input type="hidden" name="id" value="{{$client->id}}"/>
                                </form><br>
                            @else
                                <img class="mb-3 mt-4" src="/storage/{{$photo->photo2}}" id="photo2" alt="Foto client {{$client->id}}" width="160" height="160">
                            @endif
                            @if ($photo->photo3 == null)
                                <form action="{{ route('updatePhotoClient') }}" id="form2" enctype="multipart/form-data"  method="POST">
                                    @csrf
                                    @method('PATCH')
                                        <input type="file" class="btn btn-primary btn-block"  name="photo3" id="photo2" value="Agregar foto 3" />
                                        <input type="hidden" name="id" value="{{$client->id}}"/>
                                </form>
                            @else
                                <img class="mb-3 mt-4" src="/storage/{{$photo->photo3}}" id="photo3" alt="Foto client {{$client->id}}" width="160" height="160">
                            @endif
                        @endforeach
                    @else
                        <h4>No tiene fotos</h4>
                        <form action="{{ route('updatePhotoClient') }}" id="form"  enctype="multipart/form-data"  method="POST">
                            @csrf
                            @method('PATCH')
                                <input type="file" class="btn btn-primary btn-block" value="Agregar" name="photo1" id="photo" value="Agregar foto 1"/>
                                <input type="hidden" name="id" value="{{$client->id}}"/>
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
                            <p class="text-primary m-0 font-weight-bold">Información del cliente</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('updateClient', $client->id) }}"  enctype="multipart/form-data"  method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="first_name"><strong>Nombre</strong></label>
                                            <input disabled class="form-control" type="text" value="{{$client->name}}" name="first_name" required>
                                            <input type="hidden" value="{{$client->id}}" name="idclient">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="last_name"><strong>Apellido</strong></label>
                                            <input disabled class="form-control" id="last_name" type="text" value="{{$client->last_name}}" name="last_name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="documento"><strong>Documento</strong></label>
                                    <input disabled class="form-control" id="documento" type="text" value="{{$client->documento}}" name="documento" required>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="celphone"><strong>Celular</strong></label>
                                        <input class="form-control" type="text" value="{{$client->celphone}}" id="celphone" disabled name="celphone" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="phone"><strong>Telefono fijo</strong></label>
                                        <input class="form-control" type="text" value="{{$client->phone}}" id="phone" disabled name="phone" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email"><strong>Email Address</strong></label>
                                    <input class="form-control" disabled type="email" value="{{$client->email}}" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="address"><strong>Dirección</strong></label>
                                    <input class="form-control" type="text" disabled value="{{$client->address}}" name="address" required>
                                </div>
                                <div id="modal-buttons" class="form-group">
                                    <button disabled id="clientSave" class="btn btn-primary btn-sm" type="submit">Guardar</button>
                                    <button class="btn btn-info btn-sm" id="clientUpdate" type="button"><span>Actualizar</span></button>
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
            <form action="{{ route('updatePhotoClient') }}"  enctype="multipart/form-data"  method="POST">
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
                            <input type="hidden" name="id" value="{{$client->id}}"/>
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
    {{-- MODAL PHOTOS VIEW --}}
    <div id="myModal" class="modalphoto">
        <!-- The Close Button -->
        <span id="close" class="close">&times;</span>
        <!-- Modal Content (The Image) -->
        <img class="modal-content" id="img01">
        <!-- Modal Caption (Image Text) -->
        <div id="caption"></div>
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
                                <input type="hidden" name="client_id" value="{{$client->id}}"/>
                            </div>
                            <div class="form-group">
                                <label for="address"><strong>Vehiculo</strong></label>
                                @if ($vehicles->count() > 0)
                                    <select name="vehicle_id" class="form-control" required>
                                        <option>Seleccione una opción</option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{$vehicle->id}}">{{$vehicle->placa}}</option>
                                        @endforeach
                                    </select>
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
@endsection
@push('scripts')
    <script src="/js/client.js"></script>
    <script src="/js/photos.js"></script>
@endpush
