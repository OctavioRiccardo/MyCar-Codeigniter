<?php echo view('layout/header'); ?>

<section class="section section-vehiculos" style="min-height: 100vh;">
    <div class="container">
        
        <div class="box admin-box p-5">
            
            <div class="columns is-vcentered mb-5">
                <div class="column">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <a href="<?= site_url('vehiculos') ?>" class="btn-chakra-light" style="padding: 8px 12px; height: auto;" title="Volver al Listado">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="title is-3 has-text-dark mb-1 admin-box-title" style="margin: 0;">
                                <i class="fa-solid fa-users-viewfinder has-text-emerald-700 mr-2"></i>Historial de Clientes por Vehículo
                            </h1>
                            <h2 class="subtitle is-6 has-text-grey" style="margin: 5px 0 0 0;">
                                Clientes que han alquilado el vehículo: <strong><?= esc($vehiculo['marca']) ?> <?= esc($vehiculo['modelo']) ?> (Año <?= esc($vehiculo['anio']) ?>)</strong>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <table class="table is-hoverable is-striped is-fullwidth">
                    <thead>
                        <tr class="has-background-white-ter">
                            <th class="has-text-grey">ID Cliente</th>
                            <th>Usuario</th>
                            <th>Nombre y Apellido</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Fecha Desde</th>
                            <th>Fecha Hasta</th>
                            <th class="has-text-centered">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($clientes)): ?>
                            <?php foreach($clientes as $cliente): ?>
                                <tr>
                                    <td class="vertical-center">
                                        <span class="tag is-light is-normal has-text-weight-bold">
                                            #<?= $cliente['id_usuario'] ?>
                                        </span>
                                    </td>

                                    <td class="has-text-weight-semibold vertical-center">
                                        <?= esc($cliente['nombre_usuario']) ?>
                                    </td>

                                    <td class="vertical-center">
                                        <?= esc($cliente['nombre_usuario'] . ' ' . $cliente['apellido_usuario']) ?>
                                    </td>

                                    <td class="vertical-center">
                                        <?= esc($cliente['telefono'] ?? 'No especificado') ?>
                                    </td>

                                    <td class="vertical-center">
                                        <span class="has-text-grey-dark">
                                            <?= esc($cliente['direccion'] ?? 'No especificada') ?>
                                        </span>
                                    </td>

                                    <td class="vertical-center">
                                        <span class="icon-text">
                                            <span class="icon has-text-grey-light"><i class="fa-regular fa-calendar"></i></span>
                                            <span><?= date('d/m/Y', strtotime($cliente['fecha_desde'])) ?></span>
                                        </span>
                                    </td>

                                    <td class="vertical-center">
                                        <span class="icon-text">
                                            <span class="icon has-text-grey-light"><i class="fa-regular fa-calendar"></i></span>
                                            <span><?= date('d/m/Y', strtotime($cliente['fecha_hasta'])) ?></span>
                                        </span>
                                    </td>

                                    <td class="has-text-centered vertical-center">
                                        <?php if($cliente['estado'] == 'reserva'): ?>
                                            <span class="tag is-warning is-light has-text-weight-bold is-uppercase">
                                                Reserva
                                            </span>
                                        <?php elseif($cliente['estado'] == 'alquiler'): ?>
                                            <span class="tag is-info is-light has-text-weight-bold is-uppercase">
                                                Alquilado
                                            </span>
                                        <?php elseif($cliente['estado'] == 'devuelto'): ?>
                                            <span class="tag is-success is-light has-text-weight-bold is-uppercase">
                                                Devuelto
                                            </span>
                                        <?php else: ?>
                                            <span class="tag is-danger is-light has-text-weight-bold is-uppercase">
                                                <?= esc(ucfirst($cliente['estado'])) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="has-text-centered has-text-grey-light py-6">
                                    <span class="icon is-large block mb-2">
                                        <i class="fa-solid fa-user-tag fa-2x"></i>
                                    </span>
                                    <p>Este vehículo no registra ningún alquiler por el momento.</p>
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
