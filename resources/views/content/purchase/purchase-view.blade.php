@extends('layouts/layoutMaster')

@section('title', 'eCommerce Order List - Apps')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'])
@endsection

@section('page-script')
    @vite(['resources/assets/js/app-ecommerce-order-list.js'])
@endsection

@section('content')
    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light">Productos Comprados /</span> FECHA: {{ $purchase->purchase_date->format('d/m/Y') }}
        <p>
            HORA: {{ $purchase->purchase_date->format('H:i:s') }}
        </p>
    </h4>



    <!-- Order List Widget -->


    <div class="container py-5">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="card-title">Lista De Compras</h4>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <!-- Compras Realizadas -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-center card-widget border-end pb-3 pb-sm-0">
                            <div>
                                <h4 class="mb-2">{{ $purchase->purchaseDetails->count() ?? '0' }}</h4>
                                <p class="mb-0 fw-medium">Compras Realizadas</p>
                            </div>
                            <span class="avatar p-2 me-lg-4">
                                <span class="avatar-initial bg-label-secondary rounded-circle">
                                    <i class="ti ti-shopping-cart text-body"></i>
                                </span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none">
                    </div>

                    <!-- Monto Total -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-center card-widget border-end pb-3 pb-sm-0">
                            <div>
                                <h4 class="mb-2">{{ $purchase->total_quantity }} Bs</h4>
                                <p class="mb-0 fw-medium">Monto Total</p>
                            </div>
                            <span class="avatar p-2 me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded-circle">
                                    <i class="ti ti-wallet text-body"></i>
                                </span>
                            </span>
                        </div>
                    </div>

                    <!-- Proveedores -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-center card-widget">
                            <div>
                                <h4 class="mb-2">{{ $purchase->supplier->reason_social }}</h4>
                                <p class="mb-0 fw-medium">Proveedor</p>
                            </div>
                            <span class="avatar p-2">
                                <span class="avatar-initial bg-label-secondary rounded-circle">
                                    <i class="ti ti-truck text-body"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- Product List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-3">Lista De Compra</h5>
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
                    <th></th>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                </thead>
                <tbody>
                    @foreach ($purchase->purchaseDetails as $index => $detail)
                        <tr>
                            <td></td>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $detail->stockProduction->name }}</td>
                            <td>{{ number_format($detail->stockProduction->price, 2) }} Bs</td>
                            <td>{{ $detail->amount }}</td>
                            <td>{{ number_format($detail->price_purchase_detail, 2) }} Bs</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
