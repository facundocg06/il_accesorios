@extends('layouts/layoutMaster')

@section('title', 'Mis Ventas')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/quill/typography.scss', 'resources/assets/vendor/libs/quill/katex.scss', 'resources/assets/vendor/libs/quill/editor.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/dropzone/dropzone.scss', 'resources/assets/vendor/libs/flatpickr/flatpickr.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/quill/katex.js', 'resources/assets/vendor/libs/quill/quill.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/dropzone/dropzone.js', 'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js', 'resources/assets/vendor/libs/flatpickr/flatpickr.js'])
@endsection

@section('page-script')
{{-- @vite(['resources/assets/js/app-ecommerce-product-add.js']) --}}
@endsection

@section('content')
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Mis Ventas</span>
</h4>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Filter</h5>
        <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
            <div class="col-md-4 product_status"></div>
            <div class="col-md-4 product_category"></div>
            <div class="col-md-4 product_stock"></div>
        </div>
    </div>
    <div class="card-datatable table-responsive">
        @if (session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <span class="alert-icon text-success me-2">
                <i class="ti ti-check ti-xs"></i>
            </span>
            {{ session('success') }}
        </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <span class="alert-icon text-danger me-2">
                <i class="ti ti-ban ti-xs"></i>
            </span>
            {{ session('error') }}
        </div>
        @endif
        <table class="table">
            <thead class="border-top">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha de Venta</th>
                    <th>Cantidad Total</th>
                    <th>Estado de Venta</th>
                    <th>Método de Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->customer->name_customer }} {{ $sale->customer->last_name_customer }}</td>
                    <td>{{ $sale->sale_date }}</td>
                    <td>{{ $sale->total_quantity }}</td>
                    <td>{{ $sale->sale_state }}</td>
                    <td>{{ $sale->payment_method }}</td>
                    <td>
                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#saleDetails{{ $sale->id }}" aria-expanded="false" aria-controls="saleDetails{{ $sale->id }}">
                            Ver Detalles
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="7" class="p-0">
                        <div class="collapse" id="saleDetails{{ $sale->id }}">
                            <div class="card card-body">
                                <h5>Detalles de Venta #{{ $sale->id }}</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio Unitario</th>
                                            <th>Cantidad</th>
                                            <th>Precio Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sale->details as $detail)
                                        <tr>
                                            <td>{{ $detail->stockSale->product->name }}</td>
                                            <td>{{ $detail->unitsale_price }}</td>
                                            <td>{{ $detail->amount }}</td>
                                            <td>{{ $detail->subtotal_price }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection