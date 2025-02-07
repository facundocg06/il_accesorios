@extends('layouts/layoutMaster')

@section('title', 'Generar Reporte de Ajuste de Inventario')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Generar Reporte de Ajuste de Inventario</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.adjustments.generate') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="store_id" class="form-label">Seleccionar Almacén:</label>
                                <select name="store_id" id="store_id" class="form-control" required>
                                    @foreach($stores as $store)
                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="adjustment_type" class="form-label">Tipo de Ajuste:</label>
                                <select name="adjustment_type" id="adjustment_type" class="form-control" required>
                                    <option value="Ingreso">Ingreso</option>
                                    <option value="Egreso">Egreso</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Fecha de inicio:</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Fecha de fin:</label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Generar Reporte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection