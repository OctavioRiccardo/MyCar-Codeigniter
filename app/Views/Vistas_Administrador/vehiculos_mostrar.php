<?php echo view('layout/header'); ?>

<section class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-8">
                <div class="box">
                    <h1 class="title has-text-centered"><?= esc($vehiculo['marca']) . ' ' . esc($vehiculo['modelo']) ?></h1>
                    
                    <div class="columns">
                        <div class="column is-6 has-text-centered">
                            <?php if(!empty($vehiculo['imagen'])): ?>
                                <img src="<?= base_url($vehiculo['imagen']) ?>" alt="<?= esc($vehiculo['marca']) ?>" style="max-height: 250px; object-fit: contain;">
                            <?php else: ?>
                                <div style="height: 250px; display: flex; align-items: center; justify-content: center; background: #f1f5f9; border-radius: 8px; color: #94a3b8;">
                                    <i class="fa-solid fa-car fa-5x"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="column is-6">
                            <table class="table is-fullwidth">
                                <tbody>
                                    <tr>
                                        <th>Tipo:</th>
                                        <td><?= ucfirst(esc($vehiculo['tipo_vehiculo'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Año:</th>
                                        <td><?= esc($vehiculo['anio']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Nro. de Plazas:</th>
                                        <td><?= esc($vehiculo['numero_plazas']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Motor:</th>
                                        <td><?= esc($vehiculo['motor']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Kilometraje:</th>
                                        <td><?= number_format($vehiculo['kilometraje'], 0, ',', '.') ?> KM</td>
                                    </tr>
                                    <tr>
                                        <th>Precio por Día:</th>
                                        <td>$<?= number_format($vehiculo['precio_alquiler_dia'], 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Disponibilidad:</th>
                                        <td>
                                            <span class="tag <?= $vehiculo['disponibilidad'] == 'disponible' ? 'is-success' : 'is-danger' ?>">
                                                <?= ucfirst(esc($vehiculo['disponibilidad'])) ?>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="buttons is-centered mt-5">
                        <a href="<?= site_url('vehiculos/edit/'.$vehiculo['id_vehiculo']) ?>" class="button is-warning">Editar</a>
                        <a href="<?= site_url('vehiculos') ?>" class="button is-light">Volver al Listado</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php echo view('layout/footer'); ?>
