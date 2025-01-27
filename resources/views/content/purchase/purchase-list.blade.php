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
        <span class="text-muted fw-light">Insumos Comprados /</span> Lista De Insumos Comprados
        @if($supplier)
            <p>{{ $supplier->reason_social }}</p>
        @else
            <p>Proveedor no encontrado.</p>
        @endif
    </h4>

    <!-- Order List Widget -->

    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                            <div>
                                <h4 class="mb-2">{{ $purchaseCount }}</h4>
                                <p class="mb-0 fw-medium">Notas De Compras</p>
                            </div>
                            <span class="avatar p-2 me-lg-4">
                                <span class="avatar-initial bg-label-secondary rounded">
                                    <i class="ti-md ti ti-shopping-cart text-body"></i>
                                </span>
                            </span>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none">
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                            <div>
                                <h4 class="mb-2">{{ $purchaseSumQuantity }}</h4>
                                <p class="mb-0 fw-medium">Inversión</p>
                            </div>
                            <span class="avatar p-2 me-sm-4">
                                <span class="avatar-initial bg-label-secondary rounded">
                                    <i class="ti-md ti ti-wallet text-body"></i>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-3">Listar Compras</h5>

                @if($supplier)
                    <a href="{{ route('purchase-add', ['supplierId' => $supplier->id]) }}" class="add-new btn btn-primary waves-effect waves-light">
                        <i class="ti ti-plus me-1"></i>
                        <span class="d-none d-sm-inline-block">Realizar Compra</span>
                    </a>
                @else
                    <p>Proveedor no encontrado.</p>
                @endif


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
                    <th>Fecha</th>
                    <th>Total Invertido</th>
                    <th>Proveedor</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    @foreach ($purchases as $purchase)
                        <tr>
                            <td></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $purchase->purchase_date }}</td>
                            <td>{{ $purchase->total_quantity }}</td>
                            <td>{{ $purchase->supplier->reason_social }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('purchase-view', $purchase->id) }}" class="text-body">
                                        <i class="ti ti-eye ti-sm me-2"></i>
                                    </a>

                                    {{-- <a href="{{ route('purchase-edit', $purchase->id) }}" class="text-body">
                                        <i class="ti ti-pencil ti-sm me-2"></i>
                                    </a> --}}
                                    <form action="{{ route('purchase-delete', $purchase->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-body delete-record" style="border: none; background: none; padding: 0; color: #007bff; cursor: pointer;">
                                            <i class="ti ti-trash ti-sm mx-2"></i>
                                        </button>
                                    </form>


                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
