<?php echo view('layout/header'); ?>

<section class="section section-vehiculos" style="min-height: 100vh;">
    <div class="container">
        
        <div class="box admin-box p-5">
            
            <div class="columns is-vcentered mb-5">
                <div class="column">
                    <h1 class="title is-3 has-text-dark mb-1 admin-box-title">
                        <i class="fa-solid fa-users-gear has-text-emerald-700 mr-2"></i>Administración de Clientes
                    </h1>
                    <h2 class="subtitle is-6 has-text-grey">
                        Listado, control de roles y estados de los usuarios registrados.
                    </h2>
                </div>
                <div class="column is-narrow">
                    <a href="<?= site_url('usuarios/crear') ?>" class="btn-chakra-primary">
                        <span class="icon">
                            <i class="fa-solid fa-user-plus"></i>
                        </span>
                        <span>Registrar Cliente</span>
                    </a>
                </div>
            </div>

            <?php if(session()->getFlashdata('mensaje')): ?>
                <div class="notification is-success is-light">
                    <button class="delete"></button>
                    <span class="icon mr-2">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>
                    <?= session()->getFlashdata('mensaje') ?>
                </div>
            <?php endif; ?>

            <div class="table-container">
                <table class="table is-hoverable is-striped is-fullwidth">
                    <thead>
                        <tr class="has-background-white-ter">
                            <th class="has-text-grey">ID</th>
                            <th>Usuario</th>
                            <th>Nombre y Apellido</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th class="has-text-centered">Rol</th>
                            <th>Fecha de Alta</th>
                            <th class="has-text-centered">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($usuarios)): ?>
                            <?php foreach($usuarios as $user): ?>
                                <tr>
                                    <td class="vertical-center">
                                        <span class="tag is-light is-normal has-text-weight-bold">
                                            #<?= $user['id_usuario'] ?>
                                        </span>
                                    </td>
                                    <td class="has-text-weight-semibold vertical-center">
                                        <?= esc($user['nombre_usuario']) ?>
                                    </td>
                                    <td class="vertical-center">
                                        <?= esc($user['nombre_usuario'] . ' ' . $user['apellido_usuario']) ?>
                                    </td>
                                    <td class="vertical-center">
                                        <span class="has-text-grey-dark">
                                            <?= esc($user['direccion'] ?? 'No especificada') ?>
                                        </span>
                                    </td>
                                    <td class="vertical-center">
                                        <?= esc($user['telefono'] ?? 'No especificado') ?>
                                    </td>
                                    <td class="has-text-centered vertical-center">
                                        <?php if($user['rol'] == 'administrador'): ?>
                                            <span class="tag is-info is-light has-text-weight-bold is-uppercase">
                                                <i class="fa-solid fa-user-shield mr-1"></i> Admin
                                            </span>
                                        <?php else: ?>
                                            <span class="tag is-light has-text-weight-bold is-uppercase">
                                                <i class="fa-solid fa-user mr-1"></i> Cliente
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="is-size-7 vertical-center">
                                        <?= esc($user['fecha_alta']) ?>
                                    </td>
                                    <td class="has-text-centered vertical-center">
                                        <div class="buttons is-centered are-small">
                                            <a href="<?= site_url('usuarios/editar/'.$user['id_usuario']) ?>" class="button is-warning is-light has-text-weight-bold">
                                                <span class="icon is-small">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </span>
                                                <span>Editar</span>
                                            </a>
                                            <a href="<?= site_url('usuarios/eliminar/'.$user['id_usuario']) ?>" class="button is-danger is-light has-text-weight-bold" onclick="return confirm('¿Seguro que desea dar de baja lógica a este cliente?')">
                                                <span class="icon is-small">
                                                    <i class="fa-solid fa-user-slash"></i>
                                                </span>
                                                <span>Baja</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="has-text-centered has-text-grey-light py-6">
                                    <span class="icon is-large block mb-2">
                                        <i class="fa-solid fa-user-xmark fa-2x"></i>
                                    </span>
                                    <p>No hay usuarios registrados en el sistema.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</section>

<style>
    .table td.vertical-center {
        vertical-align: middle;
    }
</style>

<?php echo view('layout/footer'); ?>