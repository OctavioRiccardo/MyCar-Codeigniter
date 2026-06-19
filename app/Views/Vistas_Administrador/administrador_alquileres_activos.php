<?php echo view('layout/header'); ?>

<section class="section section-vehiculos" style="min-height: 100vh;">
    <div class="container">
        
        <div class="box admin-box p-5">
            
            <div class="columns is-vcentered mb-5">
                <div class="column">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <a href="<?= site_url('administrador/alquileres') ?>" class="btn-chakra-light" style="padding: 8px 12px; height: auto;" title="Volver al Listado">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="title is-3 has-text-dark mb-1 admin-box-title" style="margin: 0;">
                                <i class="fa-solid fa-car-side has-text-emerald-700 mr-2"></i>Vehículos Actualmente Alquilados
                            </h1>
                            <h2 class="subtitle is-6 has-text-grey" style="margin: 5px 0 0 0;">
                                Listado en tiempo real de vehículos en posesión de clientes.
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="notification is-success is-light">
                    <button class="delete"></button>
                    <span class="icon mr-2">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="table-container">
                <table class="table is-hoverable is-striped is-fullwidth">
                    <thead>
                        <tr class="has-background-white-ter">
                            <th class="has-text-grey">ID Alquiler</th>
                            <th>Vehículo</th>
                            <th>Tipo</th>
                            <th>Cliente</th>
                            <th>Teléfono</th>
                            <th>Fecha Desde</th>
                            <th>Fecha Hasta</th>
                            <th class="has-text-centered">Días</th>
                            <th class="has-text-centered">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($alquileres)): ?>
                            <?php foreach($alquileres as $alquiler): ?>
                                <tr>
                                    <td class="vertical-center">
                                        <span class="tag is-light is-normal has-text-weight-bold">
                                            #<?= $alquiler['id_alquiler'] ?>
                                        </span>
                                    </td>

                                    <td class="vertical-center">
                                        <span class="has-text-weight-medium">
                                            <?= esc($alquiler['marca']) ?> <?= esc($alquiler['modelo']) ?>
                                        </span>
                                    </td>

                                    <td class="vertical-center">
                                        <span class="tag is-info is-light has-text-weight-semibold">
                                            <?= ucfirst(esc($alquiler['tipo_vehiculo'])) ?>
                                        </span>
                                    </td>

                                    <td class="has-text-weight-semibold vertical-center">
                                        <?= esc($alquiler['nombre_usuario']) ?> <?= esc($alquiler['apellido_usuario']) ?>
                                    </td>

                                    <td class="vertical-center">
                                        <?= esc($alquiler['telefono'] ?? 'No especificado') ?>
                                    </td>

                                    <td class="vertical-center">
                                        <span class="icon-text">
                                            <span class="icon has-text-grey-light"><i class="fa-regular fa-calendar"></i></span>
                                            <span><?= date('d/m/Y', strtotime($alquiler['fecha_desde'])) ?></span>
                                        </span>
                                    </td>

                                    <td class="vertical-center">
                                        <span class="icon-text">
                                            <span class="icon has-text-grey-light"><i class="fa-regular fa-calendar"></i></span>
                                            <span><?= date('d/m/Y', strtotime($alquiler['fecha_hasta'])) ?></span>
                                        </span>
                                    </td>

                                    <td class="has-text-centered vertical-center has-text-weight-bold">
                                        <?= esc($alquiler['cantidad_dias']) ?>
                                    </td>

                                    <td class="has-text-centered vertical-center">
                                        <form action="<?= site_url('administrador/alquileres/devolucion/'.$alquiler['id_alquiler']) ?>" method="POST" style="display:inline;">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="button is-danger is-small has-text-weight-bold" onclick="return confirm('¿Confirmar la devolución de este vehículo?')">
                                                <span class="icon is-small"><i class="fa-solid fa-rotate-left"></i></span>
                                                <span>Registrar Devolución</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="has-text-centered has-text-grey-light py-6">
                                    <span class="icon is-large block mb-2">
                                        <i class="fa-solid fa-car-side fa-2x"></i>
                                    </span>
                                    <p>No existen vehículos alquilados en este momento.</p>
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
