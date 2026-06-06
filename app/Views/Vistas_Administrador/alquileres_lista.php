<?php echo view('layout/header'); ?>

<section class="section section-vehiculos" style="min-height: 100vh;">
    <div class="container">
        
        <div class="box admin-box p-5">
            
            <div class="columns is-vcentered mb-5">
                <div class="column">
                    <h1 class="title is-3 has-text-dark mb-1">
                        <i class="fa-solid fa-file-invoice-dollar has-text-link mr-2"></i>Administración de Alquileres
                    </h1>
                    <h2 class="subtitle is-6 has-text-grey">
                        Gestión completa, historial y estados de alquileres realizados en la plataforma.
                    </h2>
                </div>
            </div>

            <div class="table-container">
                <table class="table is-hoverable is-striped is-fullwidth">
                    <thead>
                        <tr class="has-background-white-ter">
                            <th class="has-text-grey">ID</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Tipo</th>
                            <th>Fecha Desde</th>
                            <th>Fecha Hasta</th>
                            <th class="has-text-centered">Días</th>
                            <th>Método Pago</th>
                            <th class="has-text-centered">Estado</th>
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

                                    <td class="has-text-weight-semibold vertical-center">
                                        <?= esc($alquiler['nombre_usuario']) ?> <?= esc($alquiler['apellido_usuario']) ?>
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

                                    <td class="vertical-center">
                                        <span class="icon-text">
                                            <span class="icon has-text-grey-medium"><i class="fa-solid fa-credit-card"></i></span>
                                            <span><?= ucfirst(esc($alquiler['metodopago'])) ?></span>
                                        </span>
                                    </td>

                                    <td class="has-text-centered vertical-center">
                                        <?php if($alquiler['estado'] == 'reserva'): ?>
                                            <span class="tag is-warning is-light has-text-weight-bold is-uppercase">
                                                <i class="fa-solid fa-clock mr-1"></i> Reserva
                                            </span>
                                        <?php elseif($alquiler['estado'] == 'alquiler'): ?>
                                            <span class="tag is-info is-light has-text-weight-bold is-uppercase">
                                                <i class="fa-solid fa-car mr-1"></i> Alquilado
                                            </span>
                                        <?php elseif($alquiler['estado'] == 'devuelto'): ?>
                                            <span class="tag is-success is-light has-text-weight-bold is-uppercase">
                                                <i class="fa-solid fa-circle-check mr-1"></i> Devuelto
                                            </span>
                                        <?php else: ?>
                                            <span class="tag is-danger is-light has-text-weight-bold is-uppercase">
                                                <i class="fa-solid fa-circle-xmark mr-1"></i> <?= esc(ucfirst($alquiler['estado'])) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="has-text-centered has-text-grey-light py-6">
                                    <span class="icon is-large block mb-2">
                                        <i class="fa-solid fa-receipt fa-2x"></i>
                                    </span>
                                    <p>No existen alquileres registrados en la plataforma.</p>
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