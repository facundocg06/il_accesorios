@extends('layouts/layoutMaster')

@section('title', 'Usuarios IL Accesorios')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js'])
@endsection

@section('page-script')
@vite('resources/assets/js/app-user-list.js')
@endsection

@section('content')
<!-- Users List Table -->
<div class="card">
    <div class="card-header border-bottom">
        <div class="row pb-2 gap-3 gap-md-0">
            <div class="col-md-6">
                <h5 class="card-title mb-3">Lista de Usuarios</h5>
            </div>
            <div class="col-md-3">
                <!-- Campo de búsqueda -->
                <input type="text" id="searchUser" class="form-control me-2" placeholder="Buscar usuarios..."
                    aria-label="Buscar usuarios...">
            </div>
            <div class="col-md-3">
                <!-- Botón para agregar nuevo usuario -->
                <button type="button" class="add-new btn btn-primary waves-effect waves-light float-md-end"
                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser">
                    <i class="ti ti-plus me-1"></i>
                    <span class="d-none d-sm-inline-block">Agregar Nuevo Usuario</span>
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
        <table class="table" id="userTable">
            <thead class="border-top">
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Celular</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td></td>
                    <td>{{ $user['first_name'] }}</td>
                    <td>{{ $user['last_name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['phone'] }}</td>
                    <td>{{ $user->roles->first()->name }}</td>
                    <td>{{ $user['deleted'] }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            <!-- Botón de editar -->
                            <a href="#editUserModal{{ $user->id }}" class="text-body" data-bs-toggle="modal">
                                <i class="ti ti-edit ti-sm me-2"></i>
                            </a>
                            <form action="{{ route('user-delete', $user->id) }}" method="POST"
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
                <!-- Modal de edición para cada usuario -->
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1"
                    aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Editar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user-update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label" for="edit_name{{ $user->id }}">Nombre</label>
                                        <input type="text" class="form-control" id="edit_name{{ $user->id }}" name="name" value="{{ $user['first_name'] }}" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edit_lastname{{ $user->id }}">Apellido</label>
                                        <input type="text" class="form-control" id="edit_lastname{{ $user->id }}" name="lastname" value="{{ $user['last_name'] }}" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edit_email{{ $user->id }}">Correo</label>
                                        <input type="email" class="form-control" id="edit_email{{ $user->id }}" name="email" value="{{ $user['email'] }}" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edit_phone{{ $user->id }}">Celular</label>
                                        <input type="number" class="form-control" id="edit_phone{{ $user->id }}" name="phone" value="{{ $user['phone'] }}" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="edit_role{{ $user->id }}">Rol del Usuario</label>
                                        <select id="edit_role{{ $user->id }}" name="role" class="form-select">
                                            <option value="Administrador" {{ $user->roles->first()->name == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                            <option value="Vendedor" {{ $user->roles->first()->name == 'Vendedor' ? 'selected' : '' }}>Vendedor</option>
                                            <option value="Asesor" {{ $user->roles->first()->name == 'Asesor' ? 'selected' : '' }}>Asesor</option>
                                            <option value="Cliente" {{ $user->roles->first()->name == 'Cliente' ? 'selected' : '' }}>Cliente</option>
                                        </select>
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
    <!-- Offcanvas to add new user -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser"
        aria-labelledby="offcanvasAddUserLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Agregar Usuario</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
            <form method="POST" class="add-new-user pt-0" action="{{ route('user-add') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="name">Nombre </label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        placeholder="Diego..." name="name" aria-label="Diego..." />
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="lastname">Apellido</label>
                    <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname"
                        placeholder="Rios..." name="lastname" aria-label="Rios..." value="{{ old('lastname') }}" />
                    @error('lastname')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="text" id="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="diego@example.com" aria-label="diego@example.com" name="email"
                        value="{{ old('email') }}" />
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Contraseña</label>
                    <input type="password" id="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="123*****"
                        aria-label="contraseña.." name="password" required />
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="phone">Celular</label>
                    <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror"
                        placeholder="77049267" aria-label="77049267" name="phone" value="{{ old('phone') }}" />
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="rolType">Rol del Usuario</label>
                    <select id="rolType" name="rolType" class="form-select @error('rolType') is-invalid @enderror">
                        <option value="">Selecciona un rol</option>
                        <option value="Administrador" @if (old('rolType')=='Administrador' ) selected @endif>Administrador
                        </option>
                        <option value="Vendedor" @if (old('rolType')=='Vendedor' ) selected @endif>Vendedor</option>
                        </option>
                        <option value="Almacenero" @if (old('rolType')=='Almacenero' ) selected @endif>Almacenero</option>
                    </select>
                    @error('rolType')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Registrar</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
            </form>

        </div>
    </div>



</div>
<script>
    document.getElementById('searchUser').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#userTable tbody tr');

        rows.forEach(row => {
            const name = row.children[1].textContent.toLowerCase();
            const lastname = row.children[2].textContent.toLowerCase();
            const email = row.children[3].textContent.toLowerCase();

            if (name.includes(searchTerm) || lastname.includes(searchTerm) || email.includes(
                    searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection