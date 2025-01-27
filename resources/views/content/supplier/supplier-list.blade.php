@extends('layouts/layoutMaster')

@section('title', 'eCommerce Product supplier - Apps')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss', 'resources/assets/vendor/libs/quill/typography.scss', 'resources/assets/vendor/libs/quill/katex.scss', 'resources/assets/vendor/libs/quill/editor.scss'])
@endsection

@section('page-style')
    @vite('resources/assets/vendor/scss/pages/app-ecommerce.scss')
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/quill/katex.js', 'resources/assets/vendor/libs/quill/quill.js'])
@endsection

@section('page-script')
    @vite('resources/assets/js/app-ecommerce-supplier-list.js')
@endsection

@section('content')
    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light">IL Accesorios /</span> Lista De Proveedores
    </h4>

    <div class="app-ecommerce-supplier">
        <!-- supplier listar -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-3">Lista de  Proveedores</h5>
                    <!-- Botón para agregar nuevo proveedor -->
                    <button type="button" class="add-new btn btn-primary waves-effect waves-light" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasEcommerceSupplierList">
                        <i class="ti ti-plus me-1"></i>
                        <span class="d-none d-sm-inline-block">Agregar una Proveedor</span>
                    </button>
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
                <table class="table border-top">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nit</th>
                            <th>Razon Social</th>
                            <th>Telefono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $supplier['nit_supplier'] }}</td>
                                <td>{{ $supplier['reason_social'] }}</td>
                                <td>{{ $supplier['phone_supplier'] }}</td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('supplier-view', $supplier->id) }}" class="text-body">
                                            <i class="ti ti-eye ti-sm me-2"></i>
                                        </a>
                                        <a href="#editsupplierModal{{ $supplier->id }}" class="text-body"
                                            data-bs-toggle="modal">
                                            <i class="ti ti-edit ti-sm me-2"></i>
                                        </a>
                                        <form action="{{ route('supplier-delete', $supplier->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-body delete-record"
                                                style="border: none; background: none; padding: 0; color: #007bff; cursor: pointer;">
                                                <i class="ti ti-trash ti-sm mx-2"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            <!-- Modal de Edición -->
                            <div class="modal fade" id="editsupplierModal{{ $supplier->id }}" tabindex="-1"
                                aria-labelledby="editsupplierModalLabel{{ $supplier->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editsupplierModalLabel{{ $supplier->id }}">
                                                Editar Proveedor
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>

                                        {{-- Falta POR HACER --}}
                                        <div class="modal-body">
                                            <form action="{{ route('supplier-update', $supplier->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <!-- nit_supplier -->
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="editNitSupplier{{ $supplier->id }}">Nombre</label>
                                                    <input type="text"
                                                        class="form-control @error('nit_supplier') is-invalid @enderror"
                                                        id="editNitSupplier{{ $supplier->id }}" name="nit_supplier"
                                                        value="{{ old('nit_supplier', $supplier->nit_supplier) }}">
                                                    @error('nit_supplier')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- Descripción -->
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="editReasonSocial{{ $supplier->id }}">Razon Social</label>
                                                    <textarea class="form-control @error('reason_social') is-invalid @enderror" id="editReasonSocial{{ $supplier->id }}"
                                                        name="reason_social" rows="4">{{ old('reason_social', $supplier->reason_social) }}</textarea>
                                                    @error('reason_social')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- phone_supplier -->
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="editPhoneSupplier{{ $supplier->id }}">Telefono</label>
                                                    <input type="text"
                                                        class="form-control @error('phone_supplier') is-invalid @enderror"
                                                        id="editPhoneSupplier{{ $supplier->id }}"
                                                        name="phone_supplier"
                                                        value="{{ old('phone_supplier', $supplier->phone_supplier) }}">
                                                    @error('phone_supplier')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- Botones de acción -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Offcanvas to add new customer -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceSupplierList"
            aria-labelledby="offcanvasEcommerceSupplierListLabel">
            <!-- Offcanvas Header -->
            <div class="offcanvas-header py-4">
                <h5 id="offcanvasEcommerceSupplierListLabel" class="offcanvas-title">Agregar Proveedor</h5>
                <button type="button" class="btn-close bg-label-secondary text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- Offcanvas Body -->
            <div class="offcanvas-body border-top">
                <form class="pt-0" action="{{ route('supplier-add') }}">
                    @csrf
                    <!-- nit_supplier -->
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-supplier-title">Nit</label>
                        <input type="text" class="form-control @error('nit_supplier') is-invalid @enderror"
                            id="nit_supplier" placeholder="Nit Proveedor" name="nit_supplier"
                            aria-label="supplier title">
                        @error('nit_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Reazon Social -->
                    <div class="mb-3">
                        <label class="form-label">Razon Social</label>
                        <textarea class="form-control @error('reason_social') is-invalid @enderror" id="reason_social" name="reason_social"
                            rows="4" placeholder="Escribe aquí..."></textarea>
                        @error('reason_social')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-supplier-title">Telefono</label>
                        <input type="text" class="form-control @error('phone_supplier') is-invalid @enderror"
                            id="phone_supplier" placeholder="Telefono Proveedor" name="phone_supplier"
                            aria-label="supplier title">
                        @error('phone_supplier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit and reset -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Agregar Proveedor</button>
                        <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
