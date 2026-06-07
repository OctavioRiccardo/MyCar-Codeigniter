<?php
if (
    session()->get('logueado') &&
    session()->get('rol') === 'administrador' &&
    (uri_string() === '' || uri_string() === '/' || strpos(uri_string(), 'cliente/') === 0)
) {
    header('Location: ' . site_url('administrador'));
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>MyCar - Alquiler de Vehículos</title>

    <!-- Bulma -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS Global -->
    <link rel="stylesheet"
        href="<?= base_url('assets/css/style.css?v=1.5') ?>">

</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-mycar"
        role="navigation"
        aria-label="main navigation">

        <!-- Logo -->
        <div class="navbar-brand">

            <a class="navbar-item logo-container"
                href="<?= (session()->get('logueado') && session()->get('rol') === 'administrador') ? site_url('administrador') : base_url('/') ?>">

                <img
                    src="<?= base_url('assets/img/logomycar.png') ?>"
                    alt="Logo MyCar"
                    class="logo-img">

            </a>

        </div>

        <!-- Menú -->
        <div class="navbar-menu is-active">

            <div class="navbar-end">

                <div class="navbar-item">

                    <!-- Usuario Logueado -->
                    <?php if(session()->get('logueado')): ?>

                        <div class="user-session">

                            <i class="fa-solid fa-circle-user"></i>

                            <span>
                                <?= session()->get('nombre_usuario') ?>
                            </span>

                        </div>

                    <?php endif; ?>

                    <!-- Botones -->
                    <div class="buttons">

                        <!-- ADMINISTRADOR -->
                        <?php if(
                            session()->get('logueado') &&
                            session()->get('rol') == 'administrador'
                        ): ?>

                            <!-- Panel Admin -->
                            <a href="<?= site_url('administrador') ?>"
                                class="button btn-login">
                                <span class="icon">
                                    <i class="fa-solid fa-gauge"></i>
                                </span>
                                <span>Panel</span>
                            </a>

                            <!-- Cerrar Sesión -->
                            <a href="<?= site_url('logout') ?>"
                                class="button btn-login">
                                <span class="icon">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </span>
                                <span>Cerrar Sesión</span>
                            </a>

                        <!-- CLIENTE -->
                        <?php elseif(session()->get('logueado')): ?>

                            <!-- Mi Perfil -->
                            <a href="<?= site_url('perfil') ?>"
                                class="button btn-login">

                                <span class="icon">
                                    <i class="fa-solid fa-user"></i>
                                </span>

                                <span>Mi Perfil</span>

                            </a>

                            <!-- Mis Alquileres -->
                            <a href="<?= site_url('mis-alquileres') ?>"
                                class="button btn-login">

                                <span class="icon">
                                    <i class="fa-solid fa-car-side"></i>
                                </span>

                                <span>Mis Alquileres</span>

                            </a>

                            <!-- Cerrar Sesión -->
                            <a href="<?= site_url('logout') ?>"
                                class="button btn-login">

                                <span class="icon">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </span>

                                <span>Cerrar Sesión</span>

                            </a>

                        <!-- VISITANTE -->
                        <?php else: ?>

                            <!-- Iniciar Sesión -->
                            <a href="<?= site_url('login') ?>"
                                class="button btn-login">

                                <span class="icon">
                                    <i class="fa-solid fa-user"></i>
                                </span>

                                <span>Iniciar Sesión</span>

                            </a>

                            <!-- Registrarse -->
                            <a href="<?= site_url('usuarios/crear') ?>"
                                class="button btn-register">

                                <span class="icon">
                                    <i class="fa-solid fa-user-plus"></i>
                                </span>

                                <span>Registrarse</span>

                            </a>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </nav>

</body>

</html>