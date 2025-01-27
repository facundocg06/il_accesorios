<!DOCTYPE html>

<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRARTE A POST VENTA</title>
    <meta name="description"
        content="A modern CRM Dashboard Template with reusable and flexible components for your SaaS web applications by hencework. Based on Bootstrap." />

    <link rel="icon" href="{{ asset('vendor/adminlte/dist/img/LOGOPOSTVENTA.jpg') }}" type="image/x-icon"
        style="border-radius: 50%;">

    <!-- CSS -->
    <link href="{{ asset('Template/dist/css/style.css') }}" rel="stylesheet" type="text/css">
</head>

<body>
    <!-- Wrapper -->
    <div class="hk-wrapper hk-pg-auth" data-footer="simple">
        <!-- Main Content -->
        <div class="hk-pg-wrapper py-0">
            <div class="hk-pg-body py-0">
                <!-- Container -->
                <div class="container-fluid">
                    <!-- Row -->
                    <div class="row auth-split">
                        <div
                            class="col-xl-5 col-lg-6 col-md-5 d-md-block d-none bg-primary-dark-3 bg-opacity-85 position-relative">
                            <img class="bg-img" src="{{ asset('vendor/adminlte/dist/img/LOGOPOSTVENTA.jpg') }}"
                                alt="bg-img">
                            <div class="auth-content py-8">
                                <div class="row">
                                    <div class="col-xxl-8 mx-auto">
                                        <div class="text-center">
                                            <h3 class="text-white mb-2">POST VENTA.</h3>
                                            <p class="text-white">Contactanos para darte <u>14 DIas FREE</u> </p>
                                        </div>
                                        <ul class="list-icon text-white mt-4">
                                            <li class="mb-1">
                                                <p><i class="ri-check-fill"></i><span>Aquiere tu membresia para tu empresa, y se lider en ventas </span></p>
                                            </li>
                                            <li class="mb-1">
                                                <p><i class="ri-check-fill"></i><span>Para que tengas un mejor control de todas las transacciones de tu empresa EMPIEZA YA</span></p>
                                            </li>
                                        </ul>
                                        <div class="row gx-3 mt-7">
                                            <div class="col-lg-6">
                                                <div class="card card-shadow">
                                                    <img class="card-img-top"
                                                        src="{{ asset('vendor/adminlte/dist/img/MOVIL.png') }}"
                                                        style="height: 340px" alt="Card image cap">
                                                    <div class="card-body">
                                                        <h5 class="card-title text-uppercase">MOVIL</h5>
                                                        <p class="card-text">Panel Administrativo responsivo para trabajar desde tu celular.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="row">
                                                    <div class="col-12 mb-4">
                                                        <div class="card card-shadow">
                                                            <img class="card-img-top"
                                                                src="{{ asset('vendor/adminlte/dist/img/Dashboard.png') }}"
                                                                alt="Card image cap">
                                                            <div class="card-body">
                                                                <h5 class="card-title text-uppercase">WEB
                                                                </h5>
                                                                <p class="card-text">Panel Administrativo para tus reportes de ventas</p>
                                                            </div>
                                                        </div>
                                                    </div>
													<div class="col-12">
                                                        <div class="card card-shadow">
                                                            <img class="card-img-top"
                                                                src="{{ asset('vendor/adminlte/dist/img/Allusers.png') }}"
                                                                alt="Card image cap">
                                                            <div class="card-body">
                                                                <h5 class="card-title text-uppercase">VENTAS
                                                                </h5>
                                                                <p class="card-text">Ten tus ventas digitalizadas ycon un solo click</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-6 col-md-7 col-sm-10 position-relative mx-auto">
                            <div class="auth-content flex-column pt-8 pb-md-8 pb-13">
                                <div class="text-center mb-7">
                                    <a class="navbar-brand me-0" href="{{ route('Pagina') }}">
                                        <img class=""
                                            src="{{ asset('vendor/adminlte/dist/img/LOGOPOSTVENTA.jpg') }}"
                                            alt="LOGO" style="width: 150px">
                                    </a>
                                </div>
                                <form class="w-100" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xxl-5 col-xl-7 col-lg-10 mx-auto">
                                            <h4 class="text-center mb-4">Registrese en POS</h4>

                                            <div class="row gx-3">
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label">Razon Social</label>
                                                    <input
                                                        class="form-control @error('razon_social') is-invalid @enderror"
                                                        id="razon_social" name="razon_social"
                                                        value="{{ old('razon_social') }}" type="text">
                                                    @error('razon_social')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label class="form-label">Nombre Titular</label>
                                                    <input class="form-control @error('name') is-invalid @enderror"
                                                        id="name" name="name" type="text"
                                                        value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label class="form-label">Apellido Titular</label>
                                                    <input class="form-control @error('lastname') is-invalid @enderror"
                                                        id="lastname" name="lastname" type="text"
                                                        value="{{ old('lastname') }}">
                                                    @error('lastname')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label">Email</label>
                                                    <input class="form-control @error('email') is-invalid @enderror"
                                                        id="email" name="email" placeholder="Nombre Empresa"
                                                        value="{{ old('email') }}" type="email">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label">Password</label>
                                                    <div class="input-group password-check">
                                                        <span class="input-affix-wrapper affix-wth-text">
                                                            <input
                                                                class="form-control @error('password') is-invalid @enderror"
                                                                placeholder="6+ characters" id="password"
                                                                name="password" type="password" required
                                                                autocomplete="new-password">
                                                            <a href="#"
                                                                class="input-suffix text-primary text-uppercase fs-8 fw-medium">
                                                                <span>Show</span>
                                                                <span class="d-none">Hide</span>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <label class="form-label">Confirmar Password</label>
                                                    <div class="input-group password-check">
                                                        <span class="input-affix-wrapper affix-wth-text">
                                                            <input
                                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                                placeholder="6+ characters" id="password-confirm"
                                                                name="password_confirmation" type="password" required
                                                                autocomplete="new-password">
                                                            <a href="#"
                                                                class="input-suffix text-primary text-uppercase fs-8 fw-medium">
                                                                <span>Show</span>
                                                                <span class="d-none">Hide</span>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    @error('password_confirmation')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label class="form-label">Celular</label>
                                                    <input class="form-control @error('celular') is-invalid @enderror"
                                                        id="celular" name="celular" type="number"
                                                        value="{{ old('celular') }}">
                                                    @error('celular')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <label class="form-label">Nit</label>
                                                    <input class="form-control @error('nit') is-invalid @enderror"
                                                        id="nit" name="nit" type="number"
                                                        value="{{ old('nit') }}">
                                                    @error('nit')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="form-check form-check-sm mb-3">
                                                <input type="checkbox" class="form-check-input" id="logged_in"
                                                    checked>
                                                <label class="form-check-label text-muted fs-8" for="logged_in">Al crear una cuenta, usted especifica que ha leído y está de acuerdo con nuestros Términos de uso y Política de privacidad. Podemos mantenerlo informado sobre las últimas actualizaciones a través de nuestra configuración de notificación predeterminada.</label>
                                            </div>
                                            <button type="submit"
                                                class="btn btn-primary btn-rounded btn-uppercase btn-block">Crear Cuenta Empresarial</button>
                                            <p class="p-xs mt-2 text-center">Usted ya es miembro ? <a
                                                    href="{{ route('login') }}"><u>Login</u></a></p>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                    <!-- /Row -->
                </div>
                <!-- /Container -->
            </div>
            <!-- /Page Body -->
        </div>
        <!-- /Main Content -->
    </div>
    <!-- /Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('Template/vendors/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('Template/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- FeatherIcons JS -->
    <script src="{{ asset('Template/dist/js/feather.min.js') }}"></script>

    <!-- Fancy Dropdown JS -->
    <script src="{{ asset('Template/dist/js/dropdown-bootstrap-extended.js') }}"></script>

    <!-- Simplebar JS -->
    <script src="{{ asset('Template/vendors/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Init JS -->
    <script src="{{ asset('Template/dist/js/init.js') }}"></script>
</body>

</html>
