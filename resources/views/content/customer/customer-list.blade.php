@extends('layouts/layoutMaster')

@section('title', 'lientes Creamoda')

@section('vendor-style')
    @vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
@endsection

@section('page-script')
    {{-- @vite('resources/assets/js/app-customer-list.js') --}}
@endsection

@section('content')
    <!-- customers List Table -->
    <div class="card">
        <div class="card-header border-bottom">
            <div class="row pb-2 gap-3 gap-md-0">
                <div class="col-md-6">
                    <h5 class="card-title mb-3">Lista de Clientes</h5>
                </div>
                <div class="col-md-3">
                    <!-- Campo de búsqueda -->
                    <input type="text" id="searchCustomer" class="form-control me-2" placeholder="Buscar clientes..."
                        aria-label="Buscar clientes...">
                    <!-- Botón para agregar nuevo usuario -->
                </div>
                <div class="col-md-3">
                    <!-- Botón para agregar nuevo usuario -->
                    <button type="button" class="add-new btn btn-primary waves-effect waves-light float-md-end"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
                        <i class="ti ti-plus me-1"></i>
                        <span class="d-none d-sm-inline-block">Agregar Nuevo Cliente</span>
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
            <table class=" table">
                <thead class="border-top">
                    <tr>
                        <th>#</th>
                        <th>Carnet</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Direccion</th>
                        <th>Estado</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $customer['ci_customer'] }}</td>
                            <td>{{ $customer['name_customer'] }}</td>
                            <td>{{ $customer['last_name_customer'] }}</td>
                            <td>{{ $customer['email_customer'] }}</td>
                            <td>{{ $customer['phone_customer'] }}</td>
                            <td>{{ $customer['address_customer'] }}</td>
                            <td>{{ $customer['deleted'] }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <!-- Botón de editar -->
                                    <a href="#editcustomerModal{{ $customer->id }}" class="text-body"
                                        data-bs-toggle="modal">
                                        <i class="ti ti-edit ti-sm me-2"></i>
                                    </a>
                                    <form action="{{ route('customer-delete', $customer->id) }}" method="POST"
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
                        <!-- Modal de edición para cada usuario -->
                        <div class="modal fade" id="editcustomerModal{{ $customer->id }}" tabindex="-1"
                            aria-labelledby="editcustomerModalLabel{{ $customer->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editcustomerModalLabel{{ $customer->id }}">Editar
                                            Cliente</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('customer-update', $customer->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label class="form-label" for="edit_ci_customer{{ $customer->id }}">Carnet
                                                    De Identidad</label>
                                                <input type="number" class="form-control"
                                                    id="edit_ci_customer{{ $customer->id }}" name="ci_customer"
                                                    value="{{ $customer['ci_customer'] }}" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="edit_name{{ $customer->id }}">Nombre</label>
                                                <input type="text" class="form-control"
                                                    id="edit_name{{ $customer->id }}" name="name_customer"
                                                    value="{{ $customer['name_customer'] }}" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="edit_lastname{{ $customer->id }}">Apellido</label>
                                                <input type="text" class="form-control"
                                                    id="edit_lastname{{ $customer->id }}" name="last_name_customer"
                                                    value="{{ $customer['last_name_customer'] }}" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="edit_email{{ $customer->id }}">Correo</label>
                                                <input type="email" class="form-control"
                                                    id="edit_email{{ $customer->id }}" name="email_customer"
                                                    value="{{ $customer['email_customer'] }}" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="edit_phone{{ $customer->id }}">Celular</label>
                                                <input type="number" class="form-control"
                                                    id="edit_phone{{ $customer->id }}" name="phone_customer"
                                                    value="{{ $customer['phone_customer'] }}" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="edit_address{{ $customer->id }}">Direccion</label>
                                                <textarea class="form-control" id="edit_address{{ $customer->id }}" name="address_customer" rows="2"
                                                    required>{{ $customer['address_customer'] }}</textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Offcanvas to add new Customer -->

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
            aria-labelledby="offcanvasAddUserLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Agregar Cliente</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
                <form class="pt-0" action="{{ route('customer-add') }}">
                    @csrf
                    <!-- Title -->
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-category-title">Carnet De Identidad</label>
                        <input type="number" class="form-control @error('ci_customer') is-invalid @enderror"
                            id="ci_customer" placeholder="Carnet del cliente" name="ci_customer"
                            aria-label="category title">
                        @error('ci_customer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-category-title">Nombres Del Cliente</label>
                        <input type="text" class="form-control @error('name_customer') is-invalid @enderror"
                            id="name_customer" placeholder="Nombre Completo" name="name_customer"
                            aria-label="category title">
                        @error('name_customer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-category-title">Apellidos Del Cliente</label>
                        <input type="text" class="form-control @error('last_name_customer') is-invalid @enderror"
                            id="last_name_customer" placeholder="Apellido Completo" name="last_name_customer"
                            aria-label="category title">
                        @error('last_name_customer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-category-title">Correo Electronico</label>
                        <input type="text" class="form-control @error('email_customer') is-invalid @enderror"
                            id="email_customer" placeholder="Correo Electronico Del Cliente" name="email_customer"
                            aria-label="category title">
                        @error('email_customer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ecommerce-category-title">Telefono</label>
                        <input type="number" class="form-control @error('phone_customer') is-invalid @enderror"
                            id="phone_customer" placeholder="Carnet del cliente" name="phone_customer"
                            aria-label="category title">
                        @error('phone_customer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Direccion -->
                    <div class="mb-3">
                        <label class="form-label">Direccion</label>
                        <textarea class="form-control @error('address_customer') is-invalid @enderror" id="address_customer"
                            name="address_customer" rows="2" placeholder="Escribe aquí..."></textarea>
                        @error('address_customer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                    </div>
                    <!-- Submit and reset -->
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Agregar Cliente</button>
                        <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchCustomer');
            const tableRows = document.querySelectorAll('.table tbody tr');

            searchInput.addEventListener('input', function() {
                const searchText = this.value.trim().toLowerCase();

                tableRows.forEach(row => {
                    const tdText = row.innerText.trim().toLowerCase();
                    row.style.display = tdText.includes(searchText) ? '' : 'none';
                });
            });
        });
    </script>
@endsection
