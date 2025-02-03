<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Ventas</title>
</head>

<body>
    <h1>Reporte de Ventas</h1>
    <p>Desde: {{ $startDate }}</p>
    <p>Hasta: {{ $endDate }}</p>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha de Venta</th>
                <th>Monto</th>
                <th>Estado de Venta</th>
                <th>Método de Pago</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->customer->name_customer }} {{ $sale->customer->last_name_customer }}</td>
                <td>{{ $sale->sale_date }}</td>
                <td>{{ $sale->total_quantity }}</td>
                <td>{{ $sale->sale_state }}</td>
                <td>{{ $sale->payment_method }}</td>
            </tr>

            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No hay ventas en este periodo.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Totales</strong></td>
                <td></td>
                <td><strong>${{ number_format($sales->sum('total_quantity'), 2) }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>