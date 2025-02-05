<?php
    $containerNav =
        isset($configData['contentLayout']) && $configData['contentLayout'] === 'compact'
            ? 'container-xxl'
            : 'container-fluid';
    $navbarDetached = $navbarDetached ?? '';
?>

<!-- Navbar -->
<?php if(isset($navbarDetached) && $navbarDetached == 'navbar-detached'): ?>
    <nav class="layout-navbar <?php echo e($containerNav); ?> navbar navbar-expand-xl <?php echo e($navbarDetached); ?> align-items-center bg-navbar-theme"
        id="layout-navbar">
<?php endif; ?>
<?php if(isset($navbarDetached) && $navbarDetached == ''): ?>
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="<?php echo e($containerNav); ?>">
<?php endif; ?>

<!--  Brand demo (display only for navbar-full and hide on below xl) -->
<?php if(isset($navbarFull)): ?>
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
        <a href="<?php echo e(url('/')); ?>" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">
                <img src="<?php echo e(asset('assets/img/il_accesorios/logoIL.jpeg')); ?>" alt="logo-il_accesorios" class="w-100">
            </span>
            <span class="app-brand-text demo menu-text fw-bold"><?php echo e(config('variables.templateName')); ?></span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
            <i class="ti ti-x ti-sm align-middle"></i>
        </a>
    </div>
<?php endif; ?>

<!-- ! Not required for layout-without-menu -->
<?php if(!isset($navbarHideToggle)): ?>
    <div
        class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0<?php echo e(isset($menuHorizontal) ? ' d-xl-none ' : ''); ?> <?php echo e(isset($contentNavbar) ? ' d-xl-none ' : ''); ?>">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ti ti-menu-2 ti-sm"></i>
        </a>
    </div>
<?php endif; ?>

<div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

    <?php if(!isset($menuHorizontal)): ?>
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper mb-0">
                <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
                    <i class="ti ti-search ti-md me-2"></i>
                    <span class="d-none d-md-inline-block text-muted">Search (Ctrl+/)</span>
                </a>
            </div>
        </div>
        <!-- /Search -->
    <?php endif; ?>
    <ul class="navbar-nav flex-row align-items-center ms-auto">
        <?php if(isset($menuHorizontal)): ?>
            <!-- Search -->
            <li class="nav-item navbar-search-wrapper me-2 me-xl-0">
                <a class="nav-link search-toggler" href="javascript:void(0);">
                    <i class="ti ti-search ti-md"></i>
                </a>
            </li>
            <!-- /Search -->
        <?php endif; ?>
        <?php if($configData['hasCustomizer'] == true): ?>
            <!-- Style Switcher -->
            <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class='ti ti-md'></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                            <span class="align-middle"><i class='ti ti-sun me-2'></i>Dia</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                            <span class="align-middle"><i class="ti ti-moon me-2"></i>Noche</span>
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ Style Switcher -->
        <?php endif; ?>

        <!-- Quick links  -->
        <li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown"
                data-bs-auto-close="outside" aria-expanded="false">
                <i class='ti ti-layout-grid-add ti-md'></i>
            </a>
            <div class="dropdown-menu dropdown-menu-end py-0">
                <div class="dropdown-menu-header border-bottom">
                    <div class="dropdown-header d-flex align-items-center py-3">
                        <h5 class="text-body mb-0 me-auto">Atajos</h5>
                    </div>
                </div>
                <div class="dropdown-shortcuts-list scrollable-container">
                    <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                <i class="ti ti-users fs-4"></i>
                            </span>
                            <a href="<?php echo e(route('user-list')); ?>" class="stretched-link">Usuario</a>
                            <small class="text-muted mb-0">Administrar Usuario</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                <i class="ti ti-file-invoice fs-4"></i>
                            </span>
                            <a href="<?php echo e(route('customer-list')); ?>" class="stretched-link">Clientes</a>
                            <small class="text-muted mb-0">Gestiona los Clientes</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                <i class="ti ti-chart-bar fs-4"></i>
                            </span>
                            <a href="<?php echo e(route('supplier-list')); ?>" class="stretched-link">Proveedores</a>
                            <small class="text-muted mb-0">Anota tu Provedor</small>
                        </div>
                    </div>
                    <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                <i class="ti ti-calendar fs-4"></i>
                            </span>
                            <a href="<?php echo e(route('category-list')); ?>" class="stretched-link">Categorias</a>
                            <small class="text-muted mb-0">Appointments</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                <i class="ti ti-calendar fs-4"></i>
                            </span>
                            <a href="<?php echo e(route('product-list')); ?>" class="stretched-link">Productos</a>
                            <small class="text-muted mb-0">Carga tu Productos</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                <i class="ti ti-lock fs-4"></i>
                            </span>
                            <a href="<?php echo e(route('store-list')); ?>" class="stretched-link">Almacenes</a>
                            <small class="text-muted mb-0">Mira tus Almacenes</small>
                        </div>
                    </div>
                    <div class="row row-bordered overflow-visible g-0">
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                <i class="ti ti-lock fs-4"></i>
                            </span>
                            <a href="<?php echo e(route('sales-list')); ?>" class="stretched-link">Ventas</a>
                            <small class="text-muted mb-0">Mira tus Ventas</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                <i class="ti ti-settings fs-4"></i>
                            </span>
                            <a href="<?php echo e(url('pages/account-settings-account')); ?>" class="stretched-link">Reportes</a>
                            <small class="text-muted mb-0">Analiticos</small>
                        </div>
                        <div class="dropdown-shortcuts-item col">
                            <span class="dropdown-shortcuts-icon rounded-circle mb-2">
                                <i class="ti ti-lock fs-4"></i>
                            </span>
                            <a href="<?php echo e(route('store-list')); ?>" class="stretched-link">Compras</a>
                            <small class="text-muted mb-0">Mira tus Compras</small>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <!-- Quick links -->

        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                <div class="avatar avatar-online">
                    <img src="<?php echo e(asset('assets/img/il_accesorios/logoUser.jpg')); ?>"
                        alt class="h-auto rounded-circle">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item"
                        href="<?php echo e(Route::has('profile.show') ? route('profile.show') : url('pages/profile-user')); ?>">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar avatar-online">
                                    <img src="<?php echo e(asset('assets/img/il_accesorios/logoUser.jpg')); ?>"
                                        alt class="h-auto rounded-circle">
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <span class="fw-medium d-block">
                                    <?php if(Auth::check()): ?>
                                        <?php echo e(Auth::user()->username); ?>

                                    <?php else: ?>
                                        Sin Nombre
                                    <?php endif; ?>
                                </span>
                                <small class="text-muted"><?php echo e(Auth::user()->roles->first()->name); ?></small>
                            </div>
                        </div>
                    </a>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <?php if(Auth::check()): ?>
                    <li>
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class='ti ti-logout me-2'></i>
                            <span class="align-middle">Cerrar Sesion</span>
                        </a>
                    </li>
                    <form method="POST" id="logout-form" action="<?php echo e(route('logout')); ?>">
                        <?php echo csrf_field(); ?>
                    </form>
                <?php else: ?>
                    <li>
                        <a class="dropdown-item"
                            href="<?php echo e(Route::has('login') ? route('login') : url('auth/login-basic')); ?>">
                            <i class='ti ti-login me-2'></i>
                            <span class="align-middle">Login</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
        <!--/ User -->
    </ul>
</div>

<!-- Search Small Screens -->
<div class="navbar-search-wrapper search-input-wrapper <?php echo e(isset($menuHorizontal) ? $containerNav : ''); ?> d-none">
    <input type="text"
        class="form-control search-input <?php echo e(isset($menuHorizontal) ? '' : $containerNav); ?> border-0"
        placeholder="Search..." aria-label="Search...">
    <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
</div>
<?php if(isset($navbarDetached) && $navbarDetached == ''): ?>
    </div>
<?php endif; ?>
</nav>
<!-- / Navbar -->
<?php /**PATH /var/www/resources/views/layouts/sections/navbar/navbar.blade.php ENDPATH**/ ?>