<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Reporte de Ventas</h2>
    <p><strong>Periodo:</strong> {{ $startDate }} - {{ $endDate }}</p>

    @if($product)
    <p><strong>Producto:</strong> {{ $product->name }}</p>
    @else
    <p><strong>Producto:</strong> Todos los productos</p>
    @endif

    <table>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Fecha de Venta</th>
            <th>Monto</th>
            <th>Estado de Venta</th>
            <th>Método de Pago</th>
        </tr>
        @foreach($sales as $sale)
        <tr>
            <td>{{ $sale->id }}</td>
            <td>{{ $sale->customer->name ?? 'Desconocido' }}</td>
            <td>{{ $sale->date }}</td>
            <td>${{ number_format($sale->total, 2) }}</td>
            <td>{{ $sale->status }}</td>
            <td>{{ $sale->payment_method }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>