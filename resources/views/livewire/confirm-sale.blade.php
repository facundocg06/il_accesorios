<div class="row invoice-preview">
    <!-- Invoice -->
    <div class=" invoice-sprint col-xl-9 col-md-8 col-12 mb-md-0 mb-4">
        <div class="card invoice-preview-card">
            <div class="card-body">
                <div
                    class="d-flex justify-content-between flex-xl-row flex-md-column flex-sm-row flex-column m-sm-3 m-0">
                    <div class="mb-xl-0 mb-4">
                        <div class="d-flex svg-illustration mb-4 gap-2 align-items-center">
                            <div class=""><img src="{{ asset('assets/img/il_accesorios/logoIL.jpeg') }}"
                                    class="w-50 h-100" alt="logo-il_accesorios"></div>
                        </div>
                    </div>
                    <div>
                        <h4 class="fw-medium mb-2"><strong>NIT : </strong>3278550</h4>
                        <div class="mb-2 pt-1">
                            <span>Factura N° :</span>
                            <span class="fw-medium">7858758</span>
                        </div>
                        <div class="pt-1">
                            <span>Fecha :</span>
                            <span class="fw-medium">{{ $sale['created_at'] ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-0" />
            <div class="card-body">
                <div class="row p-sm-3 p-0">
                    <div class="col-xl-6 col-md-12 col-sm-5 col-12 mb-xl-0 mb-md-4 mb-sm-0 mb-4">
                        <h6 class="mb-3"><strong>Razon Social : </strong>{{ $requestData['name_customer'] ?? 'N/A' }}
                        </h6>
                        <h6 class="mb-3"><strong>Fecha : </strong>12 De Julio de 2024</h6>
                    </div>
                    <div class="col-xl-6 col-md-12 col-sm-7 col-12">
                        <h6 class="mb-3"><strong>NIT/CI/CEX : </strong> {{ $requestData['ci_customer'] ?? 'N/A' }}
                        </h6>
                        <h6 class="mb-3"><strong>Cod. Cliente :</strong> {{ $sale['customer_id'] ?? 'N/A' }}</h6>
                    </div>
                </div>
            </div>
            <div class="table-responsive border-top">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th>Descripcion Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Descuento</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($requestData['products']) && is_array($requestData['products']))
                            @foreach ($requestData['products'] as $product)
                                <tr>
                                    <td class="text-nowrap">{{ $product['item'] }}</td>
                                    <td>{{ $product['price'] }} Bs.</td>
                                    <td>{{ $product['quantity'] }}</td>
                                    <td>0 Bs.</td>
                                    <td>{{ $product['price'] * $product['quantity'] }} Bs.</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">No hay productos.</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="3" class="align-top px-4 py-4">
                            </td>
                            <td class="text-end pe-3 py-4">
                                <p class="mb-2 pt-3">Subtotal:</p>
                                <p class="mb-2">Discount:</p>
                                <p class="mb-0 pb-3">Total:</p>
                            </td>
                            <td class="ps-2 py-4">
                                <p class="fw-medium mb-2 pt-3">{{ number_format($subtotal, 2) }} Bs.</p>
                                <p class="fw-medium mb-2">{{ number_format($discount, 2) }} Bs.</p>
                                <p class="fw-medium mb-0 pb-3">{{ number_format($total, 2) }} Bs.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-body mx-3">
                <div class="row">
                    <div class="col-12">
                        <span class="fw-medium">Nota:</span>
                        <span>Fue un placer trabajar con usted y su equipo. Esperamos que nos tenga en cuenta para
                            futuros proyectos. ¡Gracias!</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Invoice -->

    <!-- Invoice Actions -->
    <div class="col-xl-3 col-md-4 col-12 invoice-actions">
        <form action="{{ route('confirm-sale', ['id_sale' => $sale->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card">
                <div class="card-body">
                    <input type="hidden" id="id_sale" name="id_sale" value="{{ $sale->id }}">
                    <button type="submit" class="btn btn-primary d-grid w-100 mb-2">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="ti ti-send ti-xs me-2"></i>Confirmar Venta
                        </span>
                    </button>
                    <a class="btn btn-label-secondary d-grid w-100 mb-2" href="#" onclick="printInvoiceSprint()">
                        Imprimir
                    </a>
                </div>
            </div>
        </form>

        <hr class="my-0" />
        <!-- Mostrar mensajes de éxito o error -->
        @if (session()->has('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-warning mt-3">
                {{ session('error') }}
            </div>
        @endif
        @if ($qrCode)
            <div class="card">

                <div class="card-body">
                    <img src="{{ $qrCode }}" class="w-100" alt="">
                    <button class="btn btn-primary d-grid w-100" wire:click="consultarPago">
                        <span class="d-flex align-items-center justify-content-center text-nowrap">
                            <i class="ti ti-currency-dollar ti-xs me-2"></i>Consultar Pago
                        </span>
                    </button>
                </div>
            </div>
        @endif

    </div>

    <!-- /Invoice Actions -->
    @push('scripts')
        <script>
            function printInvoiceSprint() {
                var printContents = document.querySelector('.invoice-sprint').innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
        <script>
            document.addEventListener('livewire:load', function() {
                Livewire.on('pagoRealizado', mensaje => {
                    Livewire.emitTo('confirm-sale', 'pagoRealizadoMensaje', mensaje);
                });

                Livewire.on('pagoNoRealizado', mensaje => {
                    Livewire.emitTo('confirm-sale', 'pagoNoRealizadoMensaje', mensaje);
                });
            });
        </script>
    @endpush
</div>
