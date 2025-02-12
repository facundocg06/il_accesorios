@extends('layouts/layoutMaster')

@section('title', 'Reporte de Ajustes de Inventario')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Reporte de Ajustes de Inventario</h5>
                    <small class="text-muted">
                        Tienda: {{ $store->name ?? 'No especificada' }} | Desde: {{ $startDate }} | Hasta: {{ $endDate }}
                    </small>
                </div>



                <div class="card-body">
                    <table class="table table-bordered">
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
                            @forelse ($reportData as $row)
                            <tr>
                                <td>{{ $row['date'] }}</td>
                                <td>{{ $row['user'] }}</td>
                                <td>{{ $row['product'] }}</td>
                                <td>{{ $row['detail'] }}</td>
                                <td>{{ $row['quantity'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay ajustes en este periodo.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if($pdfPath)
                    <div class="mt-3">
                        <h5>Reporte en PDF</h5>
                        <a href="{{ asset('storage/' . $pdfPath) }}" class="btn btn-primary" target="_blank">Ver PDF</a>
                    </div>
                    @endif

                    <form action="{{ route('reports.adjustments.send_email') }}" method="POST">
                        @csrf
                        <input type="hidden" name="store_id" value="{{ $store->id }}">
                        <input type="hidden" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" value="{{ $endDate }}">
                        <input type="hidden" name="pdf_path" value="{{ $pdfPath }}">
                        <input type="hidden" name="adjustment_type" value="{{ $adjustmentType }}">

                        <div class="mb-3">
                            <label for="recipient_email" class="form-label">Correo del Destinatario</label>
                            <input type="email" name="recipient_email" id="recipient_email" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success">Enviar por Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection