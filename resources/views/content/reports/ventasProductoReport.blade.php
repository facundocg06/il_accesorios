@extends('layouts.layoutMaster')

@section('title', 'Reporte de Ventas por Producto')

@section('content')
<div class="container mt-4">
    <!-- Mensajes de alerta -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5>Generar Reporte de Ventas por Producto</h5>
            <small class="text-muted">Selecciona un producto y el rango de fechas</small>
        </div>
        <div class="card-body">
            <form action="{{ route('reports.ventas.producto.generate') }}" method="POST" id="salesReportForm">
                @csrf
                <div class="mb-3">
                    <label for="product_id" class="form-label">Producto</label>
                    <select name="product_id" id="product_id" class="form-select" required>
                        <option value="">Seleccione un producto</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Fecha de Inicio</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">Fecha Fin</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" required>
                    </div>
                </div>



                <div class="mb-3" id="emailContainer" style="display: none;">
                    <label for="recipient_email" class="form-label">Correo Electrónico</label>
                    <input type="email" name="recipient_email" id="recipient_email" class="form-control" placeholder="ejemplo@correo.com">
                </div>

                <button type="submit" class="btn btn-primary">Generar Reporte</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Mostrar o ocultar el campo de correo según el checkbox
    document.getElementById('send_email').addEventListener('change', function() {
        document.getElementById('emailContainer').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endpush