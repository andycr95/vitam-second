<!DOCTYPE html>
<html>

<head>
    <style>
        * {
            font-size: 18px;
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 24px;
        }

        h3 {
            font-size: 14px;
        }

        h4 {
            font-size: 12px;
        }

        .ticket {
            margin: 8px;
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
        }

        th.producto {
            padding: 0 10px;
        }

        td.precio {
            text-align: right;
            font-size: 17px;
        }

        td.cantidad {
            text-align: left;
            font-size: 17px;
        }

        td.producto {
            text-align: center;
        }

        th {
            text-align: center;
        }

        .espacio {
            height: 20%;
        }


        .centrado {
            text-align: center;
            align-content: center;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .ticket {
            margin: 0;
            padding: 0;
        }

        body {
            text-align: center;
        }

        .fut{
            font-size: 12px
        }
        footer{
            width:100%;
            height:100px;
            position: absolute;
            bottom: 0;
        }
    </style>
</head>

<body>
    <div class="ticket centrado">
        <h1>VITAM VENTURE</h1>
        <h3>Nit: 1111814681-3</h3>
        <h3>Ciudad: {{$branch->city->name}}</h3>
        <h3>Sucursal: {{$branch->name}}</h3>
        <br>
        <h4>{{$date}}</h4>
        <h4>Recibo #{{$payment->id}}</h4>
        @if ($payment->user->id == 1)
            <h4>Vendedor: Vitam venture</h4>
        @else
            <h4>Vendedor: {{$payment->user->name}} {{$payment->user->name}}</h4>
        @endif
        <h4>Cliente: {{$client->name}}</h4>
        <h4>Vehicle: {{$vehicle->placa}}</h4>
        <br/>
        <table>
            <thead>
                <tr class="centrado">
                    <th class="cantidad">TIPO</th>
                    <th class="producto">CUOTA</th>
                    <th class="precio">$$</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $item)
                    <tr>
                        <td class="cantidad">{{$item->type}}</td>
                        <td class="producto">{{$item->amount}}</td>
                        <td class="precio">${{$item->amount}}</td>
                    </tr>
                @endforeach
            </tbody>
            <tr>
                <td class="cantidad">
                    <strong>Subtotal:</strong>
                </td>
                <td></td>
                <td class="precio">
                    ${{$subtotal}}
                </td>
            </tr>
            <tr>
                <td class="cantidad"><strong>Saldo:</strong></td>
                <td></td>
                <td class="precio">${{$credit_total}}</td>
            </tr>
            <tr>
                <td class="cantidad">
                    <strong>Total:</strong>
                </td>
                <td></td>
                <td class="precio">
                    {{$t}}
                </td>
            </tr>
        </table>
        <br>
        <br>
        <table>
            <tr>
                <td class="cantidad">
                    <strong>Cuotas faltantes:</strong>
                </td>
                <td>   </td>
                <td class="precio">
                    {{$payment->counter}}
                </td>
            </tr>
        </table>
        <footer>
            <p class="centrado">¡GRACIAS POR SU PAGO!</p>
            <p class="centrado fut">Conserve su recibo para cualquier 
            <br>tipo reclamo.
                <br>vitamventure.com</p>
        </footer>
    </div>
</body>

</html>
