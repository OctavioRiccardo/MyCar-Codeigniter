<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administrador - MyCar</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <style>
        /* Un pequeño toque extra interactivo para las tarjetas */
        .admin-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body class="has-background-light" style="min-height: 100vh;">

    <nav class="navbar is-link" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item has-text-weight-bold is-size-4" href="<?= base_url('/administrador') ?>">
                    <i class="fa-solid fa-car-side mr-2"></i> MyCar Admin
                </a>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <span class="has-text-weight-semibold">
                        <i class="fa-solid fa-user-shield mr-1"></i> <?= session()->get('nombre_usuario') ?>
                    </span>
                </div>
                <div class="navbar-item">
                    <a href="<?= base_url('logout') ?>" class="button is-danger is-light is-small">
                        <i class="fa-solid fa-right-from-bracket mr-1"></i> Salir
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <section class="section">
        <div class="container">

            <div class="block mb-6">
                <h1 class="title is-2 has-text-dark">
                    Panel de Administración
                </h1>
                <h2 class="subtitle is-5 has-text-grey">
                    Bienvenido de nuevo al sistema de gestión de MyCar.
                </h2>
            </div>

            <div class="columns is-multiline">

                <div class="column is-4">
                    <a href="<?= base_url('usuarios') ?>" class="box has-text-centered p-5 admin-card">
                        <span class="icon is-large has-text-info mb-3">
                            <i class="fa-solid fa-users fa-3x"></i>
                        </span>
                        <h3 class="title is-4 mb-2">Usuarios</h3>
                        <p class="subtitle is-6 has-text-grey">
                            Administrar clientes, roles y permisos de acceso.
                        </p>
                    </a>
                </div>

                <div class="column is-4">
                    <a href="<?= base_url('vehiculos') ?>" class="box has-text-centered p-5 admin-card">
                        <span class="icon is-large has-text-primary mb-3">
                            <i class="fa-solid fa-car fa-3x"></i>
                        </span>
                        <h3 class="title is-4 mb-2">Vehículos</h3>
                        <p class="subtitle is-6 has-text-grey">
                            Control de flota, categorías y estado de autos.
                        </p>
                    </a>
                </div>

                <div class="column is-4">
                    <a href="<?= base_url('administrador/alquileres') ?>" class="box has-text-centered p-5 admin-card">
                        <span class="icon is-large has-text-success mb-3">
                            <i class="fa-solid fa-file-contract fa-3x"></i>
                        </span>
                        <h3 class="title is-4 mb-2">Alquileres</h3>
                        <p class="subtitle is-6 has-text-grey">
                            Monitorear contratos, reservas, pagos y fechas.
                        </p>
                    </a>
                </div>

            </div>

        </div>
    </section>

</body>

</html>