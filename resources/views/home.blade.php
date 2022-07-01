@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
            <h3 class="text-dark mb-0">Dashboard</h3>
            @hasanyrole('Administrador|Empleado')
            <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="{{route('reports')}}"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generar reporte</a>
            @endhasanyrole
        </div>
        @hasanyrole('Administrador')
            <div class="row">
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow border-left-primary py-2">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col mr-2">
                                    <div class="text-uppercase text-primary font-weight-bold text-xs mb-1">
                                        <span>Ganacias (Mes)</span></div>
                                        @foreach ($salesMonth as $salesMonth)
                                            <div class="text-dark font-weight-bold h5 mb-0"><span>{{$t}}</span>                                    
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow border-left-success py-2">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col mr-2">
                                    <div class="text-uppercase text-success font-weight-bold text-xs mb-1">
                                        <span>Ganancias</span></div>
                                        @foreach ($sales as $sales)
                                            <div class="text-dark font-weight-bold h5 mb-0"><span>{{$sales->total_sales}}</span>                                    
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow border-left-info py-2">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col mr-2">
                                    <div class="text-uppercase text-info font-weight-bold text-xs mb-1">
                                        <span>Vehiculos disponibles</span></div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                        <div class="text-dark font-weight-bold h5 mb-0 mr-3"><span>{{$vehicles->count()}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto"><i class="fas fa-motorcycle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow border-left-warning py-2">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col mr-2">
                                    <div class="text-uppercase text-warning font-weight-bold text-xs mb-1">
                                        <span>pagos pendientes</span></div>
                                    <div class="text-dark font-weight-bold h5 mb-0"><span>{{count($late_pays)}}</span></div>
                                </div>
                                <div class="col-auto"><i class="far fa-calendar-times fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endhasanyrole
        <div class="row">
            <div class="col">
                <div class="card shadow mb-4"></div>
                <div class="card">
                    <div class="card-header">
                        <h5><span class="fa-stack"><i class="fa fa-circle fa-stack-2x text-muted"></i><i
                                    class="fa fa-dollar fa-stack-1x fa-inverse"></i></span>Ultimos pagos
                            registrados</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <h5>Nombre</h5>
                            </div>
                            <div class="col-md-7">
                                <h5>Monto</h5>
                            </div>
                        </div>
                        @foreach ($payment as $pay)
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="media">
                                        <div><img class="rounded-circle mr-3" src="/img/user-photo4.jpg"
                                                width="50" height="50"></div>
                                        <div class="media-body">
                                            <h4 style="font-size:14px">{{$pay->sale->client->name}}<span
                                                    class="badge badge-success"
                                                    style="font-size: 14px;">Activo</span></h4>
                                            <p class="text-muted" style="font-size: 12px;">&nbsp;{{($pay->created_at)->diffForhumans()}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4" id="{{$pay->id}}">
                                    <p>
                                        <span class="h3" style="font-size: 14px;">${{$pay->amount}}</span>
                                        <br />
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card shadow mb-4"></div>
            </div>
            <div class="col">
                    <div class="card shadow mb-4"></div>
                    <div class="card">
                        <div class="card-header">
                            <h5>
                                Ultimas ventas registradas
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <h5>Cliente</h5>
                                </div>
                                <div class="col-md-7">
                                    <h5>Vehiculo</h5>
                                </div>
                            </div>
                            @foreach ($sale as $sale)
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="media">
                                            <div><img class="rounded-circle mr-3" src="/img/user-photo4.jpg"
                                                    width="50" height="50"></div>
                                            <div class="media-body">
                                                <h4 style="font-size:14px">{{$sale->client->name}}<span
                                                        class="badge badge-success"
                                                        style="font-size: 14px;">Activo</span></h4>
                                                <p class="text-muted" style="font-size: 12px;">&nbsp;{{($sale->created_at)->diffForhumans()}}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <p><span class="h3"
                                                style="font-size: 14px;">{{$sale->vehicle->placa}}</span><br /><strong></strong><a
                                                href="{{ route('sale', $sale->id )}}" style="font-size: 12px;">Ver detalles</a></p>
                                        <p></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card shadow mb-4"></div>
                </div>
        </div>
    </div>
@endsection
