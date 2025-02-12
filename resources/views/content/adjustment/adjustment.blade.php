@extends('layouts/layoutMaster')

@section('title', 'Ajuste de Inventario')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/select2/select2.js'])
@endsection

@section('content')
<form action="{{ route('inventory-adjustments.store') }}" method="POST" id="adjustmentForm">
    @csrf
    <div class="row invoice-add">
        <div class="col-lg-9 col-12 mb-lg-0 mb-4">
            <div class="card invoice-preview-card">
                <div class="card-body">
                    <div class="row m-sm-4 m-0">
                        <div class="col-md-7 mb-md-0 mb-4 ps-0">
                            <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                                <div class="">
                                    <img src="{{ asset('assets/img/il_accesorios/logoIL.jpeg') }}" class="w-50 h-100" alt="logo-il_accesorios">
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3 mx-n4" />

                    <!-- Campos Generales -->
                    <div class="row p-sm-4 p-0">
                        <div class="col-md-12 mb-3">
                            <label for="description" class="form-label fw-medium">Descripción</label>
                            <input type="text" class="form-control" id="description" name="description" placeholder="Opcional">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="store_id" class="form-label fw-medium">Tienda</label>
                            <select name="store_id" id="store_id" class="form-select store-select" required>
                                <option value="">Seleccionar Tienda</option>
                                @foreach ($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="type" class="form-label fw-medium">Tipo de Movimiento</label>
                            <select name="type" id="type" class="form-select" required>
                                <option value="Ingreso">Ingreso</option>
                                <option value="Egreso">Egreso</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-3 mx-n4" />

                    <!-- Contenedor de productos -->
                    <div class="source-item pt-4 px-0 px-sm-4">
                        <div id="productsContainer">
                            <!-- Template del producto -->
                            <div class="product-item mb-3">
                                <div class="d-flex border rounded position-relative pe-0">
                                    <div class="row w-100 p-3">
                                        <div class="col-md-8">
                                            <p class="mb-2">Producto</p>
                                            <select name="products[0][product_id]" class="form-select product-select" required>
                                                <option value="">Seleccione un Producto</option>
                                                @foreach ($products as $product)
                                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <p class="mb-2">Cantidad</p>
                                            <input type="number" class="form-control" name="products[0][quantity]" placeholder="1" min="1" required>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm delete-product" style="display: none;">
                                                <i class="ti ti-x"></i> Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary" id="addProduct">
                                    <i class="ti ti-plus me-1"></i>
                                    <span class="align-middle">Agregar Producto</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3 mx-n4" />
                </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="col-lg-3 col-12 invoice-actions">
            <div class="card mb-4">
                <div class="card-body">
                    <button class="btn btn-success d-grid w-100 mb-2" type="submit">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="ti ti-send ti-xs me-2"></i> Registrar Ajuste
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar Select2 en los selectores fijos
        $('#store_id').select2();
        initializeSelect2ForProducts();

        let productCounter = 0;

        // Función para inicializar Select2 en los productos
        function initializeSelect2ForProducts() {
            $('.product-select').each(function() {
                if (!$(this).data('select2')) {
                    $(this).select2({
                        dropdownParent: $(this).closest('.product-item')
                    });
                }
            });
        }

        // Función para añadir nuevo producto
        document.getElementById('addProduct').addEventListener('click', function() {
            productCounter++;

            // Clonar el primer producto
            const template = document.querySelector('.product-item').cloneNode(true);

            // Actualizar los nombres de los campos
            const select = template.querySelector('select');
            const input = template.querySelector('input');
            const deleteBtn = template.querySelector('.delete-product');

            select.name = `products[${productCounter}][product_id]`;
            input.name = `products[${productCounter}][quantity]`;

            // Limpiar valores
            select.value = '';
            input.value = '';

            // Mostrar botón de eliminar
            deleteBtn.style.display = 'block';

            // Añadir el nuevo producto al contenedor
            document.getElementById('productsContainer').appendChild(template);

            // Reinicializar Select2 en el nuevo select
            $(select).select2({
                dropdownParent: $(template)
            });
        });

        // Delegación de eventos para el botón eliminar
        document.getElementById('productsContainer').addEventListener('click', function(e) {
            if (e.target.closest('.delete-product')) {
                e.target.closest('.product-item').remove();
            }
        });
    });
</script>
@endpush