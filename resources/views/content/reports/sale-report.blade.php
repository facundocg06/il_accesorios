@extends('layouts/layoutMaster')
@section('title', 'Reporte de Ventas')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Reporte de Ventas</h5>
                    <small class="text-muted">Desde: {{ $startDate }} | Hasta: {{ $endDate }}</small>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Fecha de Venta</th>
                                <th>Cantidad Total</th>
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
                                <td colspan="6" class="text-center">No hay ventas en este periodo.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <form action="{{ route('reports.ventas.email') }}" method="POST">
                        @csrf
                        <input type="hidden" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" value="{{ $endDate }}">
                        <div class="mb-3">
                            <label for="recipient_email" class="form-label">Correo del Destinatario</label>
                            <input type="email" name="recipient_email" id="recipient_email" class="form-control" placeholder="Ejemplo: destinatario@email.com" required>
                        </div>
                        <button type="submit" class="btn btn-success">Enviar por Email</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection