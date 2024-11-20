@extends('layouts/layoutMaster')

@section('title', 'eCommerce PurchaseNotes Add - Apps')

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
    <div>
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <span class="alert-icon text-danger me-2">
                        <i class="ti ti-ban ti-xs"></i>
                    </span>
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('purchase-register') }}" method="POST">
                @csrf
                <div class="app-ecommerce">
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                        <div class="d-flex flex-column justify-content-center">
                            <h4 class="mb-1 mt-3">Registrar Compra</h4>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <button class="btn btn-label-primary"
                                onclick="event.preventDefault(); window.history.back();">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Registrar Compra</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Factura</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="reason_social" class="form-label">Proveedor</label>
                                    <input type="hidden" class="form-control" id="supplier_id" name="supplier_id"
                                        value="{{ $supplier->id }}" readonly>
                                    <input type="text" class="form-control" id="reason_social" name="reason_social"
                                        value="{{ $supplier->reason_social }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="purchase_date" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="purchase_date" name="purchase_date">
                                </div>
                                <div class="mb-3">
                                    <label for="total_quantity" class="form-label">Monto Total</label>
                                    <input type="number" class="form-control" id="total_quantity" name="total_quantity"
                                        readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Columna de Insumos -->
                    <div class="col-lg-8">
                        <div class="card mb-4" style="max-height: 320px; overflow-y: auto;">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Insumos</h5>
                            </div>
                            <div class="card-body">
                                <input type="text" id="searchProduct" class="form-control mb-3"
                                    placeholder="Buscar Insumo..." onkeyup="filterProducts()">
                                <table class="table" id="productsTable">
                                    <thead>
                                        <tr>
                                            <th>Insumo</th>
                                            <th>Descripcion</th>
                                            <th>Precio</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stockService as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->description }}</td>
                                                <td>{{ $product->price }} Bs</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        onclick="addToCart({{ $product->id }}, {{ $product->price }}, '{{ $product->name }}')">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="removeFromCart({{ $product->id }}, {{ $product->price }}, '{{ $product->name }}')">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detalle de Compra debajo de Insumos, dentro del formulario -->
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Detalle De Compra</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Insumo</th>
                                            <th>Cantidad</th>
                                            <th>Precio Venta</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartTable">
                                        <!-- Los detalles del carrito se renderizan aquí -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Seleccione el Proveedor",
                allowClear: true
            });
            document.getElementById('purchase_date').value = new Date().toISOString().substring(0, 10);
            renderCart();
        });

        let cart = {};

        function addToCart(productId, price, name) {
            if (!cart[productId]) {
                cart[productId] = {
                    quantity: 0,
                    price: parseFloat(price),
                    name: name
                };
            }
            cart[productId].quantity += 1;
            renderCart();
        }

        function removeFromCart(productId, price, name) {
            if (cart[productId] && cart[productId].quantity > 0) {
                cart[productId].quantity -= 1;
                if (cart[productId].quantity === 0) {
                    delete cart[productId];
                }
                renderCart();
            }
        }

        let index = 0;

        function renderCart() {
            const cartTable = document.getElementById('cartTable');
            let totalAmount = 0;
            cartTable.innerHTML = '';

            Object.keys(cart).forEach(productId => {
                if (cart[productId].quantity > 0) {
                    const productTotal = cart[productId].quantity * cart[productId].price;
                    totalAmount += productTotal;
                    const row = `<tr>
                <td>${cart[productId].name}</td>
                <td>${cart[productId].quantity}</td>
                <td>${productTotal.toFixed(2)} Bs</td>
                <td>
                    <input type="hidden" name="products[${index}][stock_production_id]" value="${productId}">
                    <input type="hidden" name="products[${index}][amount]" value="${cart[productId].quantity}">
                    <input type="hidden" name="products[${index}][price_purchase_detail]" value="${productTotal.toFixed(2)}">
                </td>
            </tr>`;
                    cartTable.innerHTML += row;
                    index++; // Incrementa el índice para el siguiente Insumo
                }
            });

            document.getElementById('total_quantity').value = totalAmount.toFixed(2);
        }



        function filterProducts() {
            let input = document.getElementById('searchProduct');
            let filter = input.value.toUpperCase();
            let table = document.getElementById('productsTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 0; i < tr.length; i++) {
                let tdName = tr[i].getElementsByTagName('td')[0];
                let tdCategory = tr[i].getElementsByTagName('td')[1];
                if (tdName && tdCategory) {
                    let txtValueName = tdName.textContent || tdName.innerText;
                    let txtValueCategory = tdCategory.textContent || tdCategory.innerText;
                    if (txtValueName.toUpperCase().indexOf(filter) > -1 || txtValueCategory.toUpperCase().indexOf(filter) >
                        -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection
