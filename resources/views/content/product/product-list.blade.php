@extends('layouts/layoutMaster')

@section('title', 'Productos IL Accesorios')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/app-ecommerce-product-list.js'])
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productSearchInput = document.getElementById('productSearch');
            const productTableRows = document.querySelectorAll(
                '.card-datatable tbody tr[data-bs-toggle="collapse"]');

            productSearchInput.addEventListener('input', function() {
                const query = productSearchInput.value.toLowerCase();

                productTableRows.forEach(row => {
                    const productName = row.querySelector('td:nth-child(4)').textContent
                        .toLowerCase();
                    const productBarcode = row.querySelector('td:nth-child(1)').textContent
                        .toLowerCase();

                    if (productName.includes(query) || productBarcode.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection

@section('content')
    <!-- Product List Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Lista de Productos</h5>
                <div>
                    <a href="{{ route('product-add') }}" class="btn btn-primary me-2">Agregar Producto</a>
                </div>
            </div>
            <form action="{{ route('product-list') }}" class="mt-3">
                <div class="row row-cols-lg-auto g-3 align-items-center">
                    <div class="col-md-4">
                        <input type="text" id="productSearch" class="form-control" placeholder="Buscar Producto">
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="start_date" class="form-control" placeholder="Fecha de Inicio">
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="end_date" class="form-control" placeholder="Fecha de Fin">
                    </div>
                    <div class="col-md-4">
                        <select name="category" class="form-control select2">
                            <option value="">Seleccione Categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name_category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">Limpiar
                            Filtros</button>
                    </div>
                </div>
            </form>
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
                        <th>Cod Producto</th>
                        <th>Categoria</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Marca</th>
                        <th>Descripcion</th>
                        <th>qty</th>
                        <th>status</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr data-bs-toggle="collapse" data-bs-target="#stockSales-{{ $product->id }}"
                            class="accordion-toggle">
                            <td>{{ $product->barcode }}</td>
                            <td>{{ $product->category->name_category ?? 'N/A' }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->brand->name ?? 'N/A' }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->stockSales->sum('quantity') }}</td>
                            <td>{{ $product->deleted }}</td>
                            <td>
                                <!-- Aquí puedes agregar botones o enlaces para editar y eliminar productos -->
                                <a href="{{ route('product-edit', $product->id) }}" class="text-body"><i
                                        class="ti ti-edit ti-sm me-2"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="10" class="hiddenRow">
                                <div class="accordian-body collapse" id="stockSales-{{ $product->id }}">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Almacen</th>
                                                <th>Color</th>
                                                <th>Size</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->stockSales as $stock)
                                                <tr>
                                                    <td>{{ $stock->store->name ?? 'N/A' }}</td>
                                                    <td>{{ $stock->color->name ?? 'N/A' }}</td>
                                                    <td>{{ $stock->size->name ?? 'N/A' }}</td>
                                                    <td>{{ $stock->quantity }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection
