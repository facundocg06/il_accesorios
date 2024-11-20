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
            <form action="{{ route('purchase-update', $purchase->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="app-ecommerce">
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                        <div class="d-flex flex-column justify-content-center">
                            <h4 class="mb-1 mt-3">Editar Compra</h4>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <button class="btn btn-label-primary"
                                onclick="event.preventDefault(); window.history.back();">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Actualizar Compra</button>
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
                                    <select class="form-control select2" id="reason_social" name="supplier_id">
                                        <option value="">Seleccione el Proveedor</option>
                                        @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}"
                                                {{ $supplier->id == $purchase->supplier_id ? 'selected' : '' }}>
                                                {{ $supplier->reason_social }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="purchase_date" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="purchase_date" name="purchase_date"
                                        value="{{ $purchase->purchase_date->toDateString() }}">
                                </div>
                                <div class="mb-3">
                                    <label for="total_quantity" class="form-label">Monto Total</label>
                                    <input type="number" class="form-control" id="total_quantity" name="total_quantity"
                                        value="{{ $purchase->total_quantity }}" step="0.01">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4" style="max-height: 320px; overflow-y: auto;">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Productos</h5>
                            </div>
                            <div class="card-body">
                                <input type="text" id="searchProduct" class="form-control mb-3"
                                    placeholder="Buscar producto..." onkeyup="filterProducts()">
                                <table class="table" id="productsTable">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($purchase->purchaseDetails as $detail)
                                            <tr data-product-id="{{ $detail->stockProduction->id }}">
                                                <td>{{ $detail->stockProduction->name }}</td>
                                                <td>{{ $detail->stockProduction->price }} Bs</td>
                                                <td>
                                                    <input type="number"
                                                        name="products[{{ $detail->stockProduction->id }}][amount]"
                                                        value="{{ $detail->amount }}" class="form-control quantity-input"
                                                        data-id="{{ $detail->stockProduction->id }}"
                                                        data-price="{{ $detail->stockProduction->price }}">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control subtotal"
                                                        name="products[{{ $detail->stockProduction->id }}][subtotal]"
                                                        value="{{ $detail->amount * $detail->stockProduction->price }} Bs"
                                                        readonly>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger"
                                                        onclick="removeFromCart({{ $detail->stockProduction->id }})">Quitar</button>
                                                </td>
                                                <input type="hidden"
                                                    name="products[{{ $detail->stockProduction->id }}][deleted]"
                                                    value="0" class="delete-flag">
                                            </tr>
                                        @endforeach
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
            initializeCart();
        });

        let cart = {};

        function initializeCart() {
            document.querySelectorAll('.quantity-input').forEach(input => {
                const productId = input.getAttribute('data-id');
                const quantity = parseFloat(input.value);
                const price = parseFloat(input.getAttribute('data-price'));
                cart[productId] = {
                    quantity,
                    price,
                    element: input
                };
                updateSubtotal(input, quantity, price);
            });
            updateTotal();
        }

        function updateSubtotal(input, quantity, price) {
            const subtotalElement = input.closest('tr').querySelector('.subtotal');
            subtotalElement.value = `${(quantity * price).toFixed(2)} Bs`;
        }

        function updateTotal() {
            let total = 0;
            Object.values(cart).forEach(item => {
                total += item.quantity * item.price;
            });
            document.getElementById('total_quantity').value = total.toFixed(2);
        }

        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity-input')) {
                const productId = e.target.getAttribute('data-id');
                const quantity = parseFloat(e.target.value);
                const price = parseFloat(e.target.getAttribute('data-price'));
                if (quantity >= 1) {
                    cart[productId].quantity = quantity;
                    updateSubtotal(e.target, quantity, price);
                    updateTotal();
                } else {
                    e.target.value = cart[productId].quantity;
                }
            }
        });

        function removeFromCart(productId) {
            const row = document.querySelector(`tr[data-product-id="${productId}"]`);
            if (row) {
                row.querySelector('.delete-flag').value = '1';
                row.style.display = 'none';
                delete cart[productId];
                updateTotal();
            }
        }


        function filterProducts() {
            let input = document.getElementById('searchProduct');
            let filter = input.value.toUpperCase();
            let table = document.getElementById('productsTable');
            let tr = table.getElementsByTagName('tr');

            for (let i = 0; i < tr.length; i++) {
                let tdName = tr[i].getElementsByTagName('td')[0];
                if (tdName) {
                    let txtValueName = tdName.textContent || tdName.innerText;
                    if (txtValueName.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
@endsection
