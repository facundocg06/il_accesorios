@extends('layouts.layoutMaster')

@section('title', 'Reporte de Ventas por Producto')

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Reporte de Ventas para: {{ $product->name }}</h4>
    <p class="text-muted">Desde {{ $startDate }} hasta {{ $endDate }}</p>

    @if($sales->isEmpty())
    <div class="alert alert-info">
        No se encontraron ventas para el producto seleccionado en el rango de fechas.
    </div>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha de Venta</th>
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
                <td>{{ $sale['unit_price'] }}</td>
                <td>{{ $sale['total'] }}</td>
                <td>{{ $sale['payment_method'] }}</td>
                <td>{{ $sale['status'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <form action="{{route('reports.ventas.productos.email')}}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id}}">
        <input type="hidden" name="start_date" value="{{ $startDate }}">
        <input type="hidden" name="end_date" value="{{ $endDate }}">
        <div class="mb-3">
            <label for="recipient_email" class="form-label">Correo del Destinatario</label>
            <input type="email" name="recipient_email" id="recipient_email" class="form-control" placeholder="Ejemplo: destinatario@email.com" required>
        </div>
        <button type="submit" class="btn btn-success">Enviar por Email</button>
    </form>
    @endif


    <a href="{{ route('reports.ventas.producto.form') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection