@extends('layouts/layoutMaster')

@section('title', 'Ajuste de Inventario')

@section('vendor-style')
@vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
@vite(['resources/assets/vendor/libs/select2/select2.js'])
@endsection





@section('content')
<div class="container">
    <h2 class="mb-4">Gestión de Roles y Permisos</h2>

    <div class="row">
        <!-- Crear Rol -->
        <div class="col-md-6">
            <h4>Crear Rol</h4>
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Nombre del Rol" required>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>

        <!-- Crear Permiso -->
        <div class="col-md-6">
            <h4>Crear Permiso</h4>
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Nombre del Permiso" required>
                    <button type="submit" class="btn btn-primary">Crear</button>
                </div>
            </form>
        </div>
    </div>

    <hr>

    <!-- Asignar Roles y Permisos -->
    <h4>Asignar Roles y Permisos</h4>
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>Usuario</th>
                <th>Roles</th>
                <th>Permisos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td><strong>{{ $user->username }}</strong></td>

                <!-- Asignar y Eliminar Roles -->
                <td>
                    <form action="{{ route('assign.role') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <select name="roles[]" class="form-select mb-2" multiple>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" @if($user->hasRole($role->name)) selected @endif>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success btn-sm w-100">Asignar Rol</button>
                    </form>

                    <!-- Lista de Roles con Botón para Eliminar -->
                    @foreach($user->roles as $role)
                    <div class="d-flex justify-content-between align-items-center border p-1 rounded mt-1">
                        <span>{{ $role->name }}</span>
                        <form action="{{ route('remove.role') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" name="role" value="{{ $role->name }}">
                            <button type="submit" class="btn btn-danger btn-sm">X</button>
                        </form>
                    </div>
                    @endforeach
                </td>

                <!-- Asignar y Eliminar Permisos -->
                <td>
                    <form action="{{ route('assign.permission') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <select name="permissions[]" class="form-select mb-2" multiple>
                            @foreach($permissions as $permission)
                            <option value="{{ $permission->name }}" @if($user->hasPermissionTo($permission->name)) selected @endif>{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-success btn-sm w-100">Asignar Permiso</button>
                    </form>

                    <!-- Lista de Permisos con Botón para Eliminar -->
                    @foreach($user->permissions as $permission)
                    <div class="d-flex justify-content-between align-items-center border p-1 rounded mt-1">
                        <span>{{ $permission->name }}</span>
                        <form action="{{ route('remove.permission') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="hidden" name="permission" value="{{ $permission->name }}">
                            <button type="submit" class="btn btn-danger btn-sm">X</button>
                        </form>
                    </div>
                    @endforeach
                </td>

                <!-- Eliminar Todos los Roles y Permisos -->
                <td>
                    <form action="{{ route('remove.role') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-warning btn-sm w-100 mb-1">Eliminar Todos los Roles</button>
                    </form>
                    <form action="{{ route('remove.permission') }}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <button type="submit" class="btn btn-warning btn-sm w-100">Eliminar Todos los Permisos</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection