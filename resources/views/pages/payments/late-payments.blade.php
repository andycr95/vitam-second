@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{ Breadcrumbs::render('late-payments') }}
        <div class="card shadow">
            <div class="card-header py-3">
                <p class="text-primary m-0 font-weight-bold">Recaudos retrasado</p>
            </div>
            <div class="card-body">
                <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                    <table class="table dataTable my-0" id="dataTable">
                        <thead>
                            <tr>
                                <th>Vehiculo</th>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th>Tipo</th>
                                <th>Faltantes</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                            <tr>
                                <td>{{$payment->vehicle->placa}}</td>
                                <td>{{$payment->sale->client->name}} {{$payment->sale->client->last_name}}</td>
                                <td class="precio">{{$payment->amount}}</td>
                                <td>{{$payment->type}}</td>
                                <td>{{$payment->counter}}</td>
                                <td>{{($payment->created_at)->diffForhumans()}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="/js/payment.js"></script>
@endpush
