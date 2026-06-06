<?php echo view('layout/header'); ?>

<section class="section section-vehiculos">
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

<?php echo view('layout/footer'); ?>