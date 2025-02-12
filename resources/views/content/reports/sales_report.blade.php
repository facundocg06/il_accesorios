@extends('layouts/layoutMaster')

@section('title', 'Reporte de Ventas')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Reporte de Ventas</h5>
                    <p><strong>Periodo:</strong> {{ $startDate }} - {{ $endDate }}</p>
                    @if($product)
                    <p><strong>Producto:</strong> {{ $product->name }}</p>
                    @else
                    <p><strong>Producto:</strong> Todos los productos</p>
                    @endif
                </div>
                <div class="card-body">
                    <table class="table">
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
                        </tbody>
                    </table>

                    <!-- Botón para descargar PDF -->
                    <a href="{{ asset('storage/' . str_replace(storage_path('app/public/'), '', $pdfPath)) }}" class="btn btn-danger mt-3">
                        Descargar PDF
                    </a>

                    <!-- Formulario para enviar por correo -->
                    <form action="{{ route('reports.ventas.send') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="pdf_path" value="{{ $pdfPath }}">
                        <div class="mb-3">
                            <label for="recipient_email" class="form-label">Correo destinatario</label>
                            <input type="email" name="recipient_email" id="recipient_email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Enviar Reporte por Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection