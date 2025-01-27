<form method="POST" action="{{ route('register-sale') }}">
    @csrf
    <div class="row invoice-add">
        <!-- Invoice Add-->
        <div class="col-lg-9 col-12 mb-lg-0 mb-4">
            <div class="card invoice-preview-card">
                <div class="card-body">
                    <div class="row m-sm-4 m-0">
                        <div class="col-md-7 mb-md-0 mb-4 ps-0">
                            <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                                <div class=""><img src="{{ asset('assets/img/il_accesorios/logoIL.jpeg') }}"
                                        class="w-50 h-100" alt="logo-il_accesorios"></div>
                            </div>
                        </div>
                        <div class="col-md-5">
                        </div>
                    </div>

                    <hr class="my-3 mx-n4" />

                    <div class="row p-sm-4 p-0">
                        <div class="col-md-6 col-sm-7">
                            <div class="d-flex align-items-center mb-3">
                                <label for="salesperson" class="form-label me-4 fw-medium"> Nit/CI:</label>
                                <input type="text" class="form-control ms-3 customer" id="ci_customer"
                                    name="ci_customer" wire:model="ci_customer" placeholder="12*****" />
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <label for="salesperson" class="form-label me-4 fw-medium"> Celular:</label>
                                <input type="text" class="form-control ms-3" id="phone_customer"
                                    name="phone_customer" wire:model="phone_customer" placeholder="770*****" />
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-7">
                            <div class="d-flex align-items-center mb-3">
                                <label for="salesperson" class="form-label me-4 fw-medium"> Razon Social:</label>
                                <input type="text" class="form-control ms-3" id="name_customer" name="name_customer"
                                    wire:model="name_customer" placeholder="Diego" />
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <label for="salesperson" class="form-label me-4 fw-medium"> Correo (Opcional):</label>
                                <input type="text" class="form-control ms-3" id="email_customer"
                                    name="email_customer" wire:model="email_customer" placeholder="diego@gmail.com" />
                            </div>
                        </div>
                    </div>

                    <hr class="my-3 mx-n4" />

                    <div id="myForm" class="source-item pt-4 px-0 px-sm-4">
                        <div class="mb-3" data-repeater-list="products">
                            <div class="repeater-wrapper pt-0 pt-md-4" data-repeater-item>
                                <div class="d-flex border rounded position-relative pe-0">
                                    <div class="row w-100 p-3">
                                        <div wire:ignore class="col-md-6 col-12 mb-md-0 mb-3">
                                            <p class="mb-2 repeater-title">Item</p>

                                            <input class="form-control mb-3 product" name="item" id="item-0"
                                                type="text" placeholder="Select product">
                                            <input type="hidden" class="variety" name="variety_id" id="variety-0">

                                        </div>

                                        <div class="col-md-2 col-12 mb-md-0 mb-3">
                                            <p class="mb-2 repeater-title">Precio Unit</p>
                                            <input type="text" class="form-control invoice-item-price mb-3 price"
                                                name="price" id="price-0" value="0" placeholder="00"
                                                onchange="calculateSubtotal(0)" />
                                            <div>
                                                <span>Descuento:</span>
                                                <span class="discount me-2">0%</span>
                                            </div>
                                        </div>
                                        <div class="col-md-2 col-12 mb-md-0 mb-3">
                                            <p class="mb-2 repeater-title">Cantidad</p>
                                            <input type="text" class="form-control invoice-item-qty quantity"
                                                placeholder="1" value="1" min="1" name="quantity"
                                                id="quantity-0" onchange="calculateSubtotal(0)" />
                                        </div>
                                        <div class="col-md-2 col-12 pe-0">
                                            <p class="mb-2 repeater-title">Subtotal</p>
                                            <p class="mb-0 subtotal" id="subtotal-0"> 0 Bs.</p>
                                        </div>
                                    </div>
                                    <div
                                        class="d-flex flex-column align-items-center justify-content-between border-start p-2">
                                        <i class="ti ti-x cursor-pointer" data-repeater-delete></i>
                                        <div class="dropdown">
                                            <i class="ti ti-settings ti-xs cursor-pointer more-options-dropdown"
                                                role="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                data-bs-auto-close="outside" aria-expanded="false">
                                            </i>
                                            <div class="dropdown-menu dropdown-menu-end w-px-300 p-3"
                                                aria-labelledby="dropdownMenuButton">

                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label for="discountInput"
                                                            class="form-label">Descuento(%)</label>
                                                        <input type="number" class="form-control" id="discountInput"
                                                            min="0" max="100" />
                                                    </div>
                                                </div>
                                                <div class="dropdown-divider my-3"></div>
                                                <button type="button"
                                                    class="btn btn-label-primary btn-apply-changes">Aplicar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-4">
                            <div class="col-6">
                                <button type="button" class="btn btn-primary addItem" data-repeater-create>Agregar
                                    Item</button>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <div class="invoice-calculations">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="w-px-100">Subtotal:</span>
                                        <span class="fw-medium" id="invoiceSubtotal">0 Bs.</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="w-px-100">Descuento:</span>
                                        <span class="fw-medium">0 Bs.</span>
                                    </div>
                                    <hr />
                                    <div class="d-flex justify-content-between">
                                        <span class="w-px-100">Total:</span>
                                        <span class="fw-medium" id="invoiceTotal">0. Bs.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-3 mx-n4" />

                    <div class="row px-0 px-sm-4">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="note" class="form-label fw-medium">Nota:</label>
                                <textarea class="form-control" rows="2" id="note" placeholder="Nota de Venta"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Invoice Add-->

        <!-- Invoice Actions -->
        <div class="col-lg-3 col-12 invoice-actions">
            <div class="card mb-4">
                <div class="card-body">
                    <button class="btn btn-primary d-grid w-100 mb-2" type="submit">
                        <span class="d-flex align-items-center justify-content-center text-nowrap"><i
                                class="ti ti-send ti-xs me-2"></i>Registrar Venta</span>
                    </button>
                </div>
            </div>
            <div>
                <p class="mb-2">Metodo de Pago</p>
                <select class="form-select mb-4" id="payment_method" name="payment_method">
                    <option value="EFECTIVO">Efectivo</option>
                    <option value="QR">QR</option>
                    <option value="TARJETA">Tarjeta de Credito</option>
                </select>
                <div class="d-flex justify-content-between mb-2">
                    <label for="payment-terms" class="mb-0">Alguna confirmacion</label>
                    <label class="switch switch-primary me-0">
                        <input type="checkbox" class="switch-input" id="payment-terms" checked />
                        <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                        </span>
                        <span class="switch-label"></span>
                    </label>
                </div>
            </div>
        </div>


        <!-- /Invoice Actions -->
        @push('scripts')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/corejs-typeahead/1.3.1/typeahead.bundle.min.js"></script>
            <script>
                $(document).ready(function() {
                    var products =
                        @json($products); // Pasar los productos desde el componente Livewire a JavaScript
                    console.log(products)

                    // Configurar Bloodhound para manejar la fuente de datos
                    var productBloodhound = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('name', 'barcode'),
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        local: products.map(function(product) {
                            return {
                                id: product.id,
                                name: product.name,
                                size: product.size,
                                color: product.color,
                                barcode: product.barcode,
                                price: product.price,
                                quantity: product.quantity,
                            };
                        })
                    });

                    var itemCounter = 0;

                    // Función para inicializar Typeahead en un elemento dado
                    function initializeTypeahead(element) {
                        var inputId = 'typeahead-' + itemCounter; // Generar un ID único para Typeahead

                        $(element).typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                        }, {
                            name: inputId,
                            display: function(item) {
                                return item.name; // Mostrar solo el nombre en el campo de entrada
                            },
                            source: productBloodhound,
                            templates: {
                                suggestion: function(data) {
                                    return '<div>' + data.name + ' - ' + data.size + ' - ' + data.color +
                                        '</div>'; // Mostrar nombre, talla y color en las sugerencias
                                }
                            }
                        }).on('typeahead:select', function(event, selection) {
                            console.log('Selected value:', selection);
                            console.log(itemCounter);
                            $(element).typeahead('val', selection.name + ' - ' + selection.size + ' - ' + selection
                                .color);
                            $('#price-' + itemCounter).val(selection.price);
                            $('#variety-' + itemCounter).val(selection.id);
                            calculateSubtotal(itemCounter);

                        });
                    }



                    // Inicializar Typeahead para el primer elemento de la lista al cargar la página
                    initializeTypeahead('.product');

                    $('#myForm').on('click', '[data-repeater-create]', function() {
                        // Obtener el último ítem añadido
                        itemCounter++;
                        var $lastItem = $('[data-repeater-item]:last');
                        $lastItem.find('.product.tt-input').attr('id', 'item-' + itemCounter);
                        $lastItem.find('.variety').attr('id', 'variety-' + itemCounter);

                        $lastItem.find('.price').attr('id', 'price-' + itemCounter).attr('onchange',
                            'calculateSubtotal(' + itemCounter + ')');
                        $lastItem.find('.quantity').attr('id', 'quantity-' + itemCounter).attr('onchange',
                            'calculateSubtotal(' + itemCounter + ')').val(1);
                        $lastItem.find('.subtotal').attr('id', 'subtotal-' + itemCounter);
                        var $inputInsideLastItem = $lastItem.find('.product.tt-input');
                        console.log($inputInsideLastItem);
                        // Inicializar Typeahead en el input específico encontrado
                        initializeTypeahead($inputInsideLastItem);

                    });
                });
            </script>
            <script>
                // Initial function to calculate subtotal for each item
                function calculateSubtotal(index) {
                    var price = parseFloat(document.getElementById('price-' + index).value);
                    var quantity = parseFloat(document.getElementById('quantity-' + index).value);
                    var subtotal = price * quantity;
                    document.getElementById('subtotal-' + index).textContent = subtotal.toFixed(2) + ' Bs.';
                    calculateTotal();
                }

                // Function to calculate total
                function calculateTotal() {
                    var subtotals = document.querySelectorAll('.subtotal');
                    var total = 0;
                    subtotals.forEach(function(subtotal) {
                        total += parseFloat(subtotal.textContent.replace(' Bs.', ''));
                    });
                    document.getElementById('invoiceSubtotal').textContent = total.toFixed(2) + ' Bs.';
                    document.getElementById('invoiceTotal').textContent = total.toFixed(2) + ' Bs.';
                }

                document.addEventListener('DOMContentLoaded', function() {
                    document.querySelectorAll('.price, .quantity').forEach(function(input) {
                        input.addEventListener('change', calculateTotal);
                    });

                    document.querySelector('.addItem').addEventListener('click', function() {
                        setTimeout(function() {
                            var newIndex = document.querySelectorAll('[data-repeater-item]').length - 1;
                            document.getElementById('price-' + newIndex).addEventListener('change',
                                function() {
                                    calculateSubtotal(newIndex);
                                });
                            document.getElementById('quantity-' + newIndex).addEventListener('change',
                                function() {
                                    calculateSubtotal(newIndex);
                                });
                        }, 100);
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    var customers = @json($customers);
                    console.log(customers);

                    var customersBloodhound = new Bloodhound({
                        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('ci_customer', 'name_customer'),
                        queryTokenizer: Bloodhound.tokenizers.whitespace,
                        local: customers.map(function(customer) {
                            return {
                                id: customer.id,
                                ci_customer: customer.ci_customer,
                                name_customer: customer.name_customer,
                                phone_customer: customer.phone_customer,
                                email_customer: customer.email_customer
                            };
                        })
                    });

                    // Función para inicializar Typeahead en el campo de cliente
                    function initializeCustomerTypeahead() {
                        $('.customer').typeahead({
                            hint: true,
                            highlight: true,
                            minLength: 1
                        }, {
                            name: 'customer',
                            display: function(customer) {
                                return customer.ci_customer + ' - ' + customer.name_customer;
                            },
                            source: customersBloodhound,
                            templates: {
                                suggestion: function(data) {
                                    return '<div>' + data.ci_customer + ' - ' + data.name_customer + '</div>';
                                }
                            }
                        }).on('typeahead:select', function(event, selection) {
                            console.log('Selected customer:', selection);
                            // Setear los valores en los campos correspondientes
                            $('.customer').typeahead('val', selection.ci_customer);

                            $('#phone_customer').val(selection.phone_customer);
                            $('#name_customer').val(selection.name_customer);
                            $('#email_customer').val(selection.email_customer);
                        });
                    }

                    // Inicializar Typeahead para el campo de cliente
                    initializeCustomerTypeahead();
                });
            </script>
        @endpush

    </div>
</form>
