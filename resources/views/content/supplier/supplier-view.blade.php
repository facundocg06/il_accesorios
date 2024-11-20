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
        <span class="text-muted fw-light">Stock Insumos /</span>Insumos del Proveedor:
        {{ $supplier->reason_social }}
    </h4>

    <!-- Order List Widget -->
    <div class="card mb-4">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div
                                    class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                    <div>
                                        <h4 class="mb-2">{{ $stockcount }}</h4>
                                        <p class="mb-0 fw-medium">Insumos</p>
                                    </div>
                                    <span class="avatar p-2 me-lg-4">
                                        <span class="avatar-initial bg-label-secondary rounded">
                                            <i class="ti-md ti ti-shopping-cart text-body"></i>
                                        </span>
                                    </span>
                                </div>
                                <hr class="d-none d-sm-block d-lg-none">
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="d-flex justify-content-between align-items-start card-widget-2 pb-3 pb-sm-0">
                                    <div>
                                        {{-- <h4 class="mb-2">{{ $purchaseDetailsCount }}</h4> --}}
                                        <p class="mb-0 fw-medium">Compras Realizadas</p>
                                    </div>
                                    <span class="avatar p-2 me-lg-4">
                                        <span class="avatar-initial bg-label-primary rounded">
                                            <i class="ti-md ti ti-wallet text-body"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formularios y tablas-->
    <div class="card" style="height: 320px; ">
        <div class="card-header border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-3">Listar Insumos</h5>
                <div class="col-md-4">
                    <a href="{{ route('purchase-list', $supplier->id) }}" class="add-new btn btn-primary waves-effect waves-light float-md-end">
                        <i class="ti ti-eye me-1"></i>
                        <span class="d-none d-sm-inline-block">Compras Realizadas</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <button type="button" class="add-new btn btn-primary waves-effect waves-light float-md-end"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasEcommerceStockList">
                        <i class="ti ti-plus me-1"></i>
                        <span class="d-none d-sm-inline-block">Agregar Insumo</span>
                    </button>
                </div>
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
            <input type="text" id="searchProduct" class="form-control mb-3"
                placeholder="Buscar Insumo por descripción...">

            <table class="table">
                <thead class="border-top">
                    <th></th>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </thead>
                <tbody id="stockProductionsTable">
                    @foreach ($stockProductions as $stockproduction)
                        <tr>
                            <td></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $stockproduction->name }}</td>
                            <td>{{ $stockproduction->description }}</td>
                            <td>{{ $stockproduction->price }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="#editstockproductionModal{{ $stockproduction->id }}" class="text-body"
                                        data-bs-toggle="modal">
                                        <i class="ti ti-edit ti-sm me-2"></i>
                                    </a>
                                    <form action="{{ route('stock-delete', $stockproduction->id) }}" method="POST"
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
                        <div class="modal fade" id="editstockproductionModal{{ $stockproduction->id }}" tabindex="-1"
                            aria-labelledby="editStockModalLabel{{ $stockproduction->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editStockModalLabel{{ $stockproduction->id }}">
                                            Editar Stock Insumo
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('stock-update', $stockproduction->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <!-- Nombre -->
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="name{{ $stockproduction->id }}">Nombre</label>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    id="name{{ $stockproduction->id }}" name="name"
                                                    value="{{ old('name', $stockproduction->name) }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            {{-- precio --}}
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="price{{ $stockproduction->id }}">Precio</label>
                                                <input type="number"
                                                    class="form-control @error('price') is-invalid @enderror"
                                                    id="price{{ $stockproduction->id }}" name="price"
                                                    value="{{ old('price', $stockproduction->price) }}" step="0.01">
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <!-- Descripción -->
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="editDescriptionstock{{ $stockproduction->id }}">Descripción</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror"
                                                    id="editDescriptionstock{{ $stockproduction->id }}" name="description" rows="4">{{ old('description', $stockproduction->description) }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <input type="hidden" name="suppliers_id" value="{{ $stockproduction->suppliers_id }}">
                                            <!-- Botones de acción -->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Guardar
                                                    Cambios</button>
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
        <!-- al hacer click al button agregar stock -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceStockList"
            aria-labelledby="offcanvasEcommerceStockListLabel">
            <!-- Offcanvas Header -->
            <div class="offcanvas-header py-4">
                <h5 id="offcanvasEcommerceStockListLabel" class="offcanvas-title">Agregar Insumo</h5>
                <button type="button" class="btn-close bg-label-secondary text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- agregar Insumo -->
            <div class="offcanvas-body border-top">
                <form class="pt-0" action="{{ route('supplier-stock-add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="suppliers_id" value="{{ $supplier->id }}">

                    <!-- nombre -->
                    <div class="mb-3">
                        <label class="form-label" for="name">Nombre Del Insumo</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Escribe el nombre del Insumo">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price">Precio</label>
                        <input type="number" class="form-control" id="price" name="price"
                            placeholder="Escribe el precio del Insumo" step="0.01">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Description -->
                    <div class="mb-3">
                        <label class="form-label">Descripcion</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Escribe aquí..."></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Submit and reset -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Agregar Stock Insumo</button>
                        <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script>
        document.getElementById('searchProduct').addEventListener('keyup', function() {
            var search = this.value.toLowerCase();
            var tableRows = document.getElementById('stockProductionsTable').getElementsByTagName('tr');
            for (var i = 0; i < tableRows.length; i++) {
                var description = tableRows[i].cells[2].textContent
                    .toLowerCase();
                if (description.includes(search)) {
                    tableRows[i].style.display = '';
                } else {
                    tableRows[i].style.display = 'none';
                }
            }
        });
    </script>

@endsection
