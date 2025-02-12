@extends('layouts/layoutMaster')

@section('title', 'Ajuste de Inventario')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/select2/select2.js'])
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Registrar Ajuste de Inventario</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('inventory-adjustments.store') }}" method="POST">
            @csrf

            <div class="row row-cols-lg-auto g-3 align-items-center">


                <div class="col-md-4">
                    <label for="description" class="form-label">Descripción</label>
                    <input type="text" id="description" name="description" class="form-control" placeholder="Descripción (Opcional)">
                </div>

                <div class="col-md-4">
                    <label for="product_id" class="form-label">Producto</label>
                    <select name="product_id" id="product_id" class="form-control select2" required>
                        <option value="">Seleccione un Producto</option>
                        @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="store_id" class="form-label">Almacén</label>
                    <select name="store_id" id="store_id" class="form-control select2" required>
                        <option value="">Seleccione un Almacén</option>
                        @foreach ($stores as $store)
                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="type" class="form-label">Tipo de Ajuste</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="Ingreso">Ingreso</option>
                        <option value="Egreso">Egreso</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="quantity" class="form-label">Cantidad</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" min="1" required>
                </div>

                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary">Registrar Ajuste</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection