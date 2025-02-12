<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Ajustes de Inventario</title>
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
    <h2>Reporte de Ajustes de Inventario</h2>
    <p><strong>Fecha:</strong> {{ now()->format('d/m/Y') }}</p>
    <table>
        <tr>
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Producto</th>
            <th>Detalle</th>
            <th>Cantidad</th>
        </tr>
        @foreach($reportData as $data)
        <tr>
            <td>{{ $data['date'] }}</td>
            <td>{{ $data['user'] }}</td>
            <td>{{ $data['product'] }}</td>
            <td>{{ $data['detail'] }}</td>
            <td>{{ $data['quantity'] }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>