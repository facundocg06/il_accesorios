@extends('layouts/layoutMaster')

@section('title', 'Categorias IL Accesorios')

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
    @vite('resources/assets/js/app-ecommerce-category-list.js')
@endsection

@section('content')
    <h4 class="py-3 mb-2">
        <span class="text-muted fw-light">IL Accesorios /</span> Lista de Categorias
    </h4>

    <div class="app-ecommerce-category">
        <!-- Category List Table -->
        <div class="card">
            <div class="card-header border-bottom">
                <div class="row pb-2 gap-3 gap-md-0">
                    <div class="col-md-8">
                        <h5 class="card-title mb-3">Listar Categorias</h5>
                    </div>
                    <div class="col-md-4">
                        <!-- Botón para agregar nuevo usuario -->
                        <button type="button" class="add-new btn btn-primary waves-effect waves-light float-md-end"
                            data-bs-toggle="offcanvas" data-bs-target="#offcanvasEcommerceCategoryList">
                            <i class="ti ti-plus me-1"></i>
                            <span class="d-none d-sm-inline-block">Agregar una Categoria</span>
                        </button>
                    </div>
                </div>
                <div class="row pb-2 gap-3 gap-md-0 mt-2">
                    <div class="col-md-4">
                        <!-- Campo de búsqueda -->
                        <input type="text" id="searchCategory" class="form-control" placeholder="Buscar Categoría">
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
                <table class="table border-top" id="categoryTable">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Categoria</th>
                            <th>Descripcion</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td></td>
                                <td>{{ $category['name_category'] }}</td>
                                <td>{{ $category['description_category'] }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <!-- Botón para abrir el modal de edición -->
                                        <a href="#editCategoryModal{{ $category->id }}" class="text-body"
                                            data-bs-toggle="modal">
                                            <i class="ti ti-edit ti-sm me-2"></i>
                                        </a>
                                        <form action="{{ route('category-delete', $category->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-body delete-record"
                                                style="border: none; background: none; padding: 0; color: #007bff; cursor: pointer;">
                                                <i class="ti ti-trash ti-sm mx-2"></i>
                                            </button>
                                        </form>
                                        <a href="javascript:;" class="text-body dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown"><i class="ti ti-dots-vertical ti-sm mx-1"></i></a>
                                        <div class="dropdown-menu dropdown-menu-end m-0">
                                            <a href="#" class="dropdown-item">Ver</a>
                                            <a href="#" class="dropdown-item">Suspender</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal de Edición -->
                            <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1"
                                aria-labelledby="editCategoryModalLabel{{ $category->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editCategoryModalLabel{{ $category->id }}">
                                                Editar Categoria
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('category-update', $category->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <!-- Nombre -->
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="editNameCategory{{ $category->id }}">Nombre</label>
                                                    <input type="text"
                                                        class="form-control @error('name_category') is-invalid @enderror"
                                                        id="editNameCategory{{ $category->id }}" name="name_category"
                                                        value="{{ old('name_category', $category->name_category) }}">
                                                    @error('name_category')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <!-- Descripción -->
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        for="editDescriptionCategory{{ $category->id }}">Descripción</label>
                                                    <textarea class="form-control @error('description_category') is-invalid @enderror"
                                                        id="editDescriptionCategory{{ $category->id }}" name="description_category" rows="4">{{ old('description_category', $category->description_category) }}</textarea>
                                                    @error('description_category')
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
        <!-- Offcanvas to add new customer -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceCategoryList"
            aria-labelledby="offcanvasEcommerceCategoryListLabel">
            <!-- Offcanvas Header -->
            <div class="offcanvas-header py-4">
                <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">Agregar Categoria</h5>
                <button type="button" class="btn-close bg-label-secondary text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <!-- Offcanvas Body -->
            <div class="offcanvas-body border-top">
                <form class="pt-0" method="POST" action="{{ route('category-add') }}">
                    @csrf
                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-category-title">Title</label>
                        <input type="text" class="form-control @error('name_category') is-invalid @enderror"
                            id="name_category" placeholder="Escribe..." name="name_category"
                            aria-label="category title">
                        @error('name_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Descripción -->
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-category-description">Descripcion</label>
                        <textarea class="form-control @error('description_category') is-invalid @enderror"
                            placeholder="Escribe..." id="description_category" name="description_category"
                            aria-label="category description" rows="8"></textarea>
                        @error('description_category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Guardar</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript para el buscador -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('searchCategory');
            const tableRows = document.querySelectorAll('#categoryTable tbody tr');

            searchInput.addEventListener('keyup', function () {
                const searchText = searchInput.value.toLowerCase();

                tableRows.forEach(row => {
                    const categoryText = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

                    if (categoryText.includes(searchText)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
