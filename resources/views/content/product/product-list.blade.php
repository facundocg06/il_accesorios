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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const productSearchInput = document.getElementById('productSearch');
    const productTableRows = document.querySelectorAll('.card-datatable tbody tr[data-bs-toggle="collapse"]');

    productSearchInput.addEventListener('input', function() {
        const query = productSearchInput.value.toLowerCase();

        productTableRows.forEach(row => {
            const productName = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            const productBarcode = row.querySelector('td:nth-child(1)').textContent.toLowerCase();

            if (productName.includes(query) || productBarcode.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Modal logic to fill stock data
    $('#editStockModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);  // Button that triggered the modal
        var stockId = button.data('stock-id');
        var quantity = button.data('quantity');

        var modal = $(this);
        modal.find('#stockId').val(stockId);
        modal.find('#quantity').val(quantity);
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
                <div>
                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addStockModal">Agregar Stock</button>
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
                                                <th>ID</th>
                                                <th>Almacen</th>
                                                <th>Color</th>
                                                <th>Size</th>
                                                <th>Cantidad</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->stockSales as $stock)
                                                <tr>
                                                    <td>{{ $stock->id }}</td>
                                                    <td>{{ $stock->store->name ?? 'N/A' }}</td>
                                                    <td>{{ $stock->color->name ?? 'N/A' }}</td>
                                                    <td>{{ $stock->size->name ?? 'N/A' }}</td>
                                                    <td>{{ $stock->quantity }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-primary"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editStockModal"
                                                        data-stock-id="{{ $stock->id }}"
                                                        data-quantity="{{ $stock->quantity }}">
                                                    Editar
                                                </button>
                                                    </td>
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
<!-- Modal para editar el stock -->
<div class="modal fade" id="editStockModal" tabindex="-1" aria-labelledby="editStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStockModalLabel">Editar Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStockForm" action="{{ route('updateStock') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="stockId" name="stockId">
                    
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal para agregar stock -->
<div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStockModalLabel">Agregar Stock</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStockForm" action="{{ route('addStock') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="product" class="form-label">Producto</label>
                        <select name="product_id" id="product" class="form-control" required>
                            <option value="">Seleccione un Producto</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <select name="color_id" id="color" class="form-control" required>
                            <option value="">Seleccione un Color</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="size" class="form-label">Tamaño</label>
                        <select name="size_id" id="size" class="form-control" required>
                            <option value="">Seleccione un Tamaño</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="store" class="form-label">Almacén</label>
                        <select name="store_id" id="store" class="form-control" required>
                            <option value="">Seleccione un Almacén</option>
                            @foreach ($stores as $store)
                            <option value="{{ $store->id }}">{{ $store->name ?? 'N/A' }}</option>
                        @endforeach
                        </select>

                    </div>
                    
                    <button type="submit" class="btn btn-primary">Guardar Stock</button>
                </form>
            </div>
        </div>
    </div>
</div>




            
        </div>
    </div>

@endsection
