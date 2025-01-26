@if (session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
@extends('layouts/layoutMaster')
@section('title', 'Generar Reporte de Ventas')
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
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
                        <button type="submit" class="btn btn-primary">Generar Reporte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection