<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <h2>Reporte de Ventas - {{ $product->name }}</h2>
    <p>Período: {{ $startDate }} al {{ $endDate }}</p>
    <p>Generado por: {{ $userName }}</p>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
                <th>Método de Pago</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale['sale_date'] }}</td>
                <td>{{ $sale['quantity'] }}</td>
                <td>${{ number_format($sale['unit_price'], 2) }}</td>
                <td>${{ number_format($sale['total'], 2) }}</td>
                <td>{{ $sale['payment_method'] }}</td>
                <td>{{ $sale['status'] }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Totales</strong></td>
                <td></td>
                <td><strong>${{ number_format($sales->sum('total'), 2) }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>