@extends('layouts/layoutMaster')

@section('title', 'Generar Reporte de Ventas')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <!-- Mensajes de éxito o error -->
            @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5>Seleccionar Rango de Fechas</h5>
                    <small class="text-muted">Elige un rango para generar el reporte de ventas</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.ventas.generate') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Fecha Inicio</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Fecha Fin</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="product_id" class="form-label">Seleccionar Producto (Opcional)</label>
                            <select name="product_id" id="product_id" class="form-control">
                                <option value="">Todos los Productos</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Generar Reporte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection