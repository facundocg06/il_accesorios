<!DOCTYPE html>
<html>

<head>
    <title>Reporte de Ajustes de Inventario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .header-info {
            margin-bottom: 20px;
        }

        .total-row {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h1>Reporte de Ajustes de Inventario</h1>
    <div class="header-info">
        <p>Tienda: <strong>{{ $store->name }}</strong></p>
        <p>Tipo de Ajuste: <strong>{{ ucfirst($adjustmentType) }}</strong></p>
        <p>Período: {{ $startDate }} - {{ $endDate }}</p>
    </div>

    @if(empty($reportData))
    <p>No hay ajustes en este periodo.</p>
    @else
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Producto</th>
                <th>Glosa</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData as $row)
            <tr>
                <td>{{ $row['date'] }}</td>
                <td>{{ $row['user'] }}</td>
                <td>{{ $row['product'] }}</td>
                <td>{{ $row['detail'] }}</td>
                <td>{{ $row['quantity'] }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4"><strong>Total de Ajustes</strong></td>
                <td><strong>{{ collect($reportData)->sum('quantity') }}</strong></td>
            </tr>
        </tfoot>
    </table>
    @endif

    <p style="margin-top: 20px; font-size: 12px; color: #666;">
        Este reporte fue generado el {{ now()->format('d/m/Y H:i:s') }} por {{ $userName }}.
    </p>
</body>

</html>