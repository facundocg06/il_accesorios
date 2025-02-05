<?php $__env->startSection('title', 'Usuarios IL Accesorios'); ?>

<?php $__env->startSection('vendor-style'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss', 'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss', 'resources/assets/vendor/libs/select2/select2.scss', 'resources/assets/vendor/libs/@form-validation/form-validation.scss']); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/assets/vendor/libs/moment/moment.js', 'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js', 'resources/assets/vendor/libs/select2/select2.js', 'resources/assets/vendor/libs/@form-validation/popular.js', 'resources/assets/vendor/libs/@form-validation/bootstrap5.js', 'resources/assets/vendor/libs/@form-validation/auto-focus.js', 'resources/assets/vendor/libs/cleavejs/cleave.js', 'resources/assets/vendor/libs/cleavejs/cleave-phone.js']); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
    <?php echo app('Illuminate\Foundation\Vite')('resources/assets/js/app-user-list.js'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
            <?php if(session('success')): ?>
                <div class="alert alert-success d-flex align-items-center" role="alert">
                    <span class="alert-icon text-success me-2">
                        <i class="ti ti-check ti-xs"></i>
                    </span>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <span class="alert-icon text-danger me-2">
                        <i class="ti ti-ban ti-xs"></i>
                    </span>
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>
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
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td></td>
                            <td><?php echo e($user['first_name']); ?></td>
                            <td><?php echo e($user['last_name']); ?></td>
                            <td><?php echo e($user['email']); ?></td>
                            <td><?php echo e($user['phone']); ?></td>
                            <td><?php echo e($user->roles->first()->name); ?></td>
                            <td><?php echo e($user['deleted']); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <!-- Botón de editar -->
                                    <a href="#editUserModal<?php echo e($user->id); ?>" class="text-body" data-bs-toggle="modal">
                                        <i class="ti ti-edit ti-sm me-2"></i>
                                    </a>
                                    <form action="<?php echo e(route('user-delete', $user->id)); ?>" method="POST"
                                        style="display:inline;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-body delete-record"
                                            style="border: none; background: none; padding: 0; color: #007bff; cursor: pointer;">
                                            <i class="ti ti-trash ti-sm mx-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal de edición para cada usuario -->
                        <div class="modal fade" id="editUserModal<?php echo e($user->id); ?>" tabindex="-1"
                            aria-labelledby="editUserModalLabel<?php echo e($user->id); ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserModalLabel<?php echo e($user->id); ?>">Editar Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="<?php echo e(route('user-update', $user->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="mb-3">
                                                <label class="form-label" for="edit_name<?php echo e($user->id); ?>">Nombre</label>
                                                <input type="text" class="form-control" id="edit_name<?php echo e($user->id); ?>" name="name" value="<?php echo e($user['first_name']); ?>" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="edit_lastname<?php echo e($user->id); ?>">Apellido</label>
                                                <input type="text" class="form-control" id="edit_lastname<?php echo e($user->id); ?>" name="lastname" value="<?php echo e($user['last_name']); ?>" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="edit_email<?php echo e($user->id); ?>">Correo</label>
                                                <input type="email" class="form-control" id="edit_email<?php echo e($user->id); ?>" name="email" value="<?php echo e($user['email']); ?>" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="edit_phone<?php echo e($user->id); ?>">Celular</label>
                                                <input type="number" class="form-control" id="edit_phone<?php echo e($user->id); ?>" name="phone" value="<?php echo e($user['phone']); ?>" required />
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="edit_role<?php echo e($user->id); ?>">Rol del Usuario</label>
                                                <select id="edit_role<?php echo e($user->id); ?>" name="role" class="form-select">
                                                    <option value="Administrador" <?php echo e($user->roles->first()->name == 'Administrador' ? 'selected' : ''); ?>>Administrador</option>
                                                    <option value="Vendedor" <?php echo e($user->roles->first()->name == 'Vendedor' ? 'selected' : ''); ?>>Vendedor</option>
                                                    <option value="Asesor" <?php echo e($user->roles->first()->name == 'Asesor' ? 'selected' : ''); ?>>Asesor</option>
                                                    <option value="Cliente" <?php echo e($user->roles->first()->name == 'Cliente' ? 'selected' : ''); ?>>Cliente</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <form method="POST" class="add-new-user pt-0" action="<?php echo e(route('user-add')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label class="form-label" for="name">Nombre </label>
                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name"
                            placeholder="Diego..." name="name" aria-label="Diego..." />
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="lastname">Apellido</label>
                        <input type="text" class="form-control <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="lastname"
                            placeholder="Rios..." name="lastname" aria-label="Rios..." value="<?php echo e(old('lastname')); ?>" />
                        <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="text" id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="diego@example.com" aria-label="diego@example.com" name="email"
                            value="<?php echo e(old('email')); ?>" />
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" id="password"
                            class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="123*****"
                            aria-label="contraseña.." name="password" required />
                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone">Celular</label>
                        <input type="number" id="phone" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            placeholder="77049267" aria-label="77049267" name="phone" value="<?php echo e(old('phone')); ?>" />
                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="rolType">Rol del Usuario</label>
                        <select id="rolType" name="rolType" class="form-select <?php $__errorArgs = ['rolType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <option value="">Selecciona un rol</option>
                            <option value="Administrador" <?php if(old('rolType') == 'Administrador'): ?> selected <?php endif; ?>>Administrador
                            </option>
                            <option value="Vendedor" <?php if(old('rolType') == 'Vendedor'): ?> selected <?php endif; ?>>Vendedor</option>
                        </select>
                        <?php $__errorArgs = ['rolType'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/layoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/content/user/user-list.blade.php ENDPATH**/ ?>