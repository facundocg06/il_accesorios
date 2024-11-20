@extends('layouts/layoutMaster')

@section('title', 'eCommerce Store List - Apps')

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
    {{-- @vite('resources/assets/js/app-ecommerce-store-list.js') --}}
@endsection

@section('content')
    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light">CREAMODA /</span> Lista de Almacenes
    </h4>

    <div class="app-ecommerce-store">
        <!-- Store List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="row pb-2 gap-3 gap-md-0">
                    <div class="col-md-8">
                        <h5 class="card-title mb-3">Listar Almacenes</h5>
                    </div>
                    <div class="col-md-4">
                        <!-- Botón para agregar nuevo almacén -->
                        <button type="button" class="add-new btn btn-primary waves-effect waves-light float-md-end"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasEcommerceStoreList">
                            <i class="ti ti-plus me-1"></i>
                            <span class="d-none d-sm-inline-block">Agregar un Almacén</span>
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
                <table class="table border-top">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Almacén</th>
                            <th>Ubicación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stores as $store)
                            <tr>
                                <td></td>
                                <td>{{ $store['name'] }}</td>
                                <td>{{ $store['location'] }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!-- Botón para abrir el modal de edición -->
                                        <a href="#editStoreModal{{ $store->id }}" class="text-body"
                                            data-bs-toggle="modal">
                                            <i class="ti ti-edit ti-sm me-2"></i>
                                        </a>
                                        <form action="{{ route('store-delete', $store->id) }}" method="POST"
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
                            <div class="modal fade" id="editStoreModal{{ $store->id }}" tabindex="-1"
                                aria-labelledby="editStoreModalLabel{{ $store->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editStoreModalLabel{{ $store->id }}">
                                                Editar Almacén
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('store-update', $store->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <!-- Nombre -->
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="editNameStore{{ $store->id }}">Nombre</label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        id="editNameStore{{ $store->id }}" name="name"
                                                        value="{{ old('name', $store->name) }}">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- Ubicación -->
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="editLocationStore{{ $store->id }}">Ubicación</label>
                                                    <textarea class="form-control @error('location') is-invalid @enderror"
                                                        id="editLocationStore{{ $store->id }}" name="location" rows="4">{{ old('location', $store->location) }}</textarea>
                                                    @error('location')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
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
        </div>
        <!-- Offcanvas to add new store -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceStoreList"
            aria-labelledby="offcanvasEcommerceStoreListLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasEcommerceStoreListLabel" class="offcanvas-title">Nuevo Almacén</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body border-top">
                <form class="add-new-store pt-0" id="addNewStoreForm" method="POST" action="{{ route('store-add') }}">
                    @csrf
                    <!-- Nombre -->
                    <div class="mb-3">
                        <label class="form-label" for="addStoreName">Nombre</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="addStoreName"
                            name="name" placeholder="Ejemplo: Almacén Central" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Ubicación -->
                    <div class="mb-3">
                        <label class="form-label" for="addStoreLocation">Ubicación</label>
                        <textarea class="form-control @error('location') is-invalid @enderror" id="addStoreLocation"
                            name="location" placeholder="Ejemplo: Calle Principal, Edificio Central" rows="4">{{ old('location') }}</textarea>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Agregar</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
@endsection
