@extends('layouts.app')

@section('content')
    @foreach ($investor as $investor)
        @if ($investor->type != 2 && $investor->type != 3)
            <div class="container-fluid">
                {{ Breadcrumbs::render('investor', $in) }}
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <div class="card mb-3">
                            <div class="card-body text-center shadow">
                                @if ($investor->i_photo == '')
                                    <img class="rounded-circle mb-3 mt-4" src="/img/avatars/avatar1.jpeg" width="160" height="160">
                                @else
                                    <img class="rounded-circle mb-3 mt-4" src="/storage/{{$investor->i_photo}}" width="160" height="160">
                                @endif
                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#exampleModal">Cambiar foto</button></div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="text-primary font-weight-bold m-0">Vehiculos     --     {{$vehicles->count()}}</h6>
                            </div>
                            <div class="card-body scroll_s">
                                @foreach ($vehicles as $vehicle)
                                <h3 class="small font-weight-bold">{{$vehicle->placa}}
                                @if ($vehicle->state == 0)
                                    <span class="badge badge-success float-right">Vendida</span>
                                @else
                                    <span class="badge badge-primary float-right">Por vender</span>
                                @endif
                                </h3>
                                @endforeach
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
                                        <form action="{{ route('updateInvestor') }}"  enctype="multipart/form-data"  method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="first_name"><strong>Nombre</strong></label>
                                                        <input disabled class="form-control" type="text" value="{{$investor->i_name}}" name="first_name">
                                                        <input type="hidden" value="{{$investor->i_id}}" name="id">
                                                        <input type="hidden" value="{{$investor->id}}" name="idinvestor">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="last_name"><strong>Apellido</strong></label>
                                                        <input disabled class="form-control" type="text" value="{{$investor->i_lastN}}" name="last_name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="address"><strong>Cedula</strong></label>
                                                <input class="form-control" type="text" disabled name="documento" value="{{$investor->documento}}"/>
                                                <div id="form-group-document"></div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="password"><strong>Contraseña</strong></label>
                                                    <input class="form-control" type="password" id="pass" disabled name="password">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="email"><strong>Email Address</strong></label>
                                                        <input class="form-control" disabled type="email" name="email" value="{{$investor->i_email}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="address"><strong>Dirección</strong></label>
                                                <input class="form-control" type="text" disabled value="{{$investor->i_address}}" name="address">
                                            </div>
                                            <div class="form-group" id="type_invest">
                                                <label for="address"><strong>Tipo</strong></label>
                                                @if ($investor->type == 1)
                                                    <input class="form-control" name="type_investor" type="text" disabled value="Participante">
                                                @elseif($investor->type == 2)
                                                    <input class="form-control" name="type_investor" type="text" disabled value="Titular">
                                                @else
                                                    <input class="form-control" name="type_investor" type="text" disabled value="Inversionista simple">
                                                @endif
                                            </div>
                                            @if ($investor->type != 2 || $investor->type != 3)
                                                <div class="form-group" id="invest_tit">
                                                    <label for="address"><strong>Titular</strong></label>
                                                    <input class="form-control" type="text" disabled value="{{$investor->t_name}} {{$investor->t_lastN}}">
                                                </div>
                                            @endif
                                            <div class="form-row">
                                                <div class="col">

                                                </div>
                                                <div class="col">

                                                </div>
                                            </div>
                                            <div id="modal-buttons" class="form-group">
                                                <button disabled id="investorSave" class="btn btn-primary btn-sm" type="submit">Guardar</button>
                                                <button class="btn btn-info btn-sm" id="investorUpdate" type="button"><span>Actualizar</span></button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <input type="hidden" name="id" value="{{$investor->i_id}}"/>
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
        @else
            <div class="container-fluid">
                {{ Breadcrumbs::render('investor', $in) }}
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <div class="card mb-3">
                            <div class="card-body text-center shadow">
                                @if ($investor->user->photo == '')
                                    <img class="rounded-circle mb-3 mt-4" src="/img/avatars/avatar1.jpeg" width="160" height="160">
                                @else
                                    <img class="rounded-circle mb-3 mt-4" src="/storage/{{$investor->user->photo}}" width="160" height="160">
                                @endif
                                <div class="mb-3"><button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#exampleModal">Cambiar foto</button></div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="text-primary font-weight-bold m-0">Vehiculos     --     {{$vehicles->count()}}</h6>
                            </div>
                            <div class="card-body scroll_s">
                                @foreach ($vehicles as $vehicle)
                                    <h3 class="small font-weight-bold">{{$vehicle->placa}}
                                @if ($vehicle->state == 0)
                                    <span class="badge badge-success float-right">Vendida</span>
                                @else
                                    <span class="badge badge-primary float-right">Por vender</span>
                                @endif
                                </h3>
                                @endforeach
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
                                        <form action="{{ route('updateInvestor') }}"  enctype="multipart/form-data"  method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="first_name"><strong>Nombre</strong></label>
                                                        <input disabled class="form-control" type="text" value="{{$investor->user->name}}" name="first_name">
                                                        <input type="hidden" value="{{$investor->user_id}}" name="id">
                                                        <input type="hidden" value="{{$investor->id}}" name="idinvestor">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="last_name"><strong>Apellido</strong></label>
                                                        <input disabled class="form-control" type="text" value="{{$investor->user->last_name}}" name="last_name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="address"><strong>Cedula</strong></label>
                                                <input class="form-control" type="text" disabled name="documento" value="{{$investor->user->documento}}"/>
                                                <div id="form-group-document"></div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="password"><strong>Contraseña</strong></label>
                                                    <input class="form-control" type="password" id="pass" disabled name="password">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label for="email"><strong>Email Address</strong></label>
                                                        <input class="form-control" disabled type="email" name="email" value="{{$investor->user->email}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="address"><strong>Dirección</strong></label>
                                                <input class="form-control" type="text" disabled value="{{$investor->user->address}}" name="address">
                                            </div>
                                            <div class="form-group" id="type_invest">
                                                <label for="address"><strong>Tipo</strong></label>
                                                @if ($investor->type == 1)
                                                    <input class="form-control" name="type_investor" type="text" disabled value="Participante">
                                                @elseif($investor->type == 2)
                                                    <input class="form-control" name="type_investor" type="text" disabled value="Titular">
                                                @else
                                                    <input class="form-control" name="type_investor" type="text" disabled value="Inversionista simple">
                                                @endif
                                            </div>
                                            <div class="form-group" id="invest_tit"></div>
                                            <div class="form-row">
                                                <div class="col">

                                                </div>
                                                <div class="col">

                                                </div>
                                            </div>
                                            <div id="modal-buttons" class="form-group">
                                                <button disabled id="investorSave" class="btn btn-primary btn-sm" type="submit">Guardar</button>
                                            <button class="btn btn-info btn-sm" data-type="{{$investor->type}}" id="investorUpdate" type="button"><span>Actualizar</span></button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                        <input type="hidden" name="id" value="{{$investor->user->id}}"/>
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
        @endif
    @endforeach
@endsection
@push('scripts')
    <script src="/js/investors.js"></script>
@endpush
