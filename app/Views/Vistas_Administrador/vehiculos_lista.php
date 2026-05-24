<?php echo view('layout/header'); ?>

<section class="section">
    <div class="container">
        <h1 class="title">Administración de Vehículos</h1>

        <div class="buttons">
            <a href="<?= site_url('vehiculos/new') ?>" class="button is-primary">Registrar Vehículo</a>
        </div>

        <div class="table-container">
            <table class="table is-striped is-fullwidth">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Año</th>
                        <th>Tipo</th>
                        <th>Plazas</th>
                        <th>Motor</th>
                        <th>Kilometraje</th>
                        <th>Precio/Día</th>
                        <th>Disponibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($vehiculos)): ?>
                        <?php foreach($vehiculos as $v): ?>
                            <tr>
                                <td><?= $v['id_vehiculo'] ?></td>
                                <td><?= esc($v['marca']) ?></td>
                                <td><?= esc($v['modelo']) ?></td>
                                <td><?= esc($v['anio']) ?></td>
                                <td><?= ucfirst(esc($v['tipo_vehiculo'])) ?></td>
                                <td><?= esc($v['numero_plazas']) ?></td>
                                <td><?= esc($v['motor']) ?></td>
                                <td><?= number_format($v['kilometraje'], 0, ',', '.') ?> KM</td>
                                <td>$<?= number_format($v['precio_alquiler_dia'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="tag <?= $v['disponibilidad'] == 'disponible' ? 'is-success' : 'is-danger' ?>">
                                        <?= ucfirst(esc($v['disponibilidad'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="buttons are-small">
                                        <a href="<?= site_url('vehiculos/'.$v['id_vehiculo']) ?>" class="button is-info">Ver</a>
                                        <a href="<?= site_url('vehiculos/edit/'.$v['id_vehiculo']) ?>" class="button is-warning">Editar</a>
                                        <a href="<?= site_url('vehiculos/delete/'.$v['id_vehiculo']) ?>" class="button is-danger" onclick="return confirm('¿Seguro que desea dar de baja lógica a este vehículo?')">Baja</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="11" class="has-text-centered">No hay vehículos registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php echo view('layout/footer'); ?>
