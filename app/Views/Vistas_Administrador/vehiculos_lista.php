<?php echo view('layout/header'); ?>

<section class="section section-vehiculos" style="min-height: 100vh;">
    <div class="container">
        
        <div class="box admin-box p-5">
            
            <div class="columns is-vcentered mb-5">
                <div class="column">
                    <h1 class="title is-3 has-text-dark mb-1 admin-box-title">
                        <i class="fa-solid fa-car has-text-emerald-700 mr-2"></i>Administración de Vehículos
                    </h1>
                    <h2 class="subtitle is-6 has-text-grey">
                        Gestión de flota, disponibilidad, kilometraje y tarifas diarias de MyCar.
                    </h2>
                </div>
                <div class="column is-narrow">
                    <a href="<?= site_url('vehiculos/new') ?>" class="btn-chakra-primary">
                        <span class="icon">
                            <i class="fa-solid fa-car-side"></i>
                        </span>
                        <span>Registrar Vehículo</span>
                    </a>
                </div>
            </div>

            <div class="table-container">
                <table class="table is-hoverable is-striped is-fullwidth">
                    <thead>
                        <tr class="has-background-white-ter">
                            <th class="has-text-grey">ID</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Tipo</th>
                            <th class="has-text-centered">Plazas</th>
                            <th>Motor</th>
                            <th>Kilometraje</th>
                            <th>Precio/Día</th>
                            <th class="has-text-centered">Disponibilidad</th>
                            <th class="has-text-centered">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($vehiculos)): ?>
                            <?php foreach($vehiculos as $v): ?>
                                <tr>
                                    <td class="vertical-center">
                                        <span class="tag is-light is-normal has-text-weight-bold">
                                            #<?= $v['id_vehiculo'] ?>
                                        </span>
                                    </td>
                                    <td class="has-text-weight-semibold vertical-center">
                                        <?= esc($v['marca']) ?>
                                    </td>
                                    <td class="vertical-center">
                                        <?= esc($v['modelo']) ?>
                                    </td>
                                    <td class="vertical-center">
                                        <?= esc($v['anio']) ?>
                                    </td>
                                    <td class="vertical-center">
                                        <span class="tag is-white has-text-weight-semibold has-text-grey-dark">
                                            <?= ucfirst(esc($v['tipo_vehiculo'])) ?>
                                        </span>
                                    </td>
                                    <td class="has-text-centered vertical-center">
                                        <?= esc($v['numero_plazas']) ?>
                                    </td>
                                    <td class="vertical-center">
                                        <span class="is-size-7 code-text"><?= esc($v['motor']) ?></span>
                                    </td>
                                    <td class="vertical-center">
                                        <?= number_format($v['kilometraje'], 0, ',', '.') ?> KM
                                    </td>
                                    <td class="vertical-center has-text-weight-bold has-text-dark">
                                        $<?= number_format($v['precio_alquiler_dia'], 0, ',', '.') ?>
                                    </td>
                                    <td class="has-text-centered vertical-center">
                                        <?php if($v['disponibilidad'] == 'disponible'): ?>
                                            <span class="tag is-success is-light has-text-weight-bold is-uppercase">
                                                <i class="fa-solid fa-circle-check mr-1"></i> Disponible
                                            </span>
                                        <?php else: ?>
                                            <span class="tag is-danger is-light has-text-weight-bold is-uppercase">
                                                <i class="fa-solid fa-circle-xmark mr-1"></i> No Disponible
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="has-text-centered vertical-center">
                                        <div class="buttons is-centered are-small">
                                            <a href="<?= site_url('vehiculos/'.$v['id_vehiculo']) ?>" class="button is-info is-light has-text-weight-bold">
                                                <span class="icon is-small">
                                                    <i class="fa-solid fa-eye"></i>
                                                </span>
                                                <span>Ver</span>
                                            </a>
                                            <a href="<?= site_url('vehiculos/edit/'.$v['id_vehiculo']) ?>" class="button is-warning is-light has-text-weight-bold">
                                                <span class="icon is-small">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </span>
                                                <span>Editar</span>
                                            </a>
                                            <a href="<?= site_url('vehiculos/delete/'.$v['id_vehiculo']) ?>" class="button is-danger is-light has-text-weight-bold" onclick="return confirm('¿Seguro que desea dar de baja lógica a este vehículo?')">
                                                <span class="icon is-small">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </span>
                                                <span>Baja</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="has-text-centered has-text-grey-light py-6">
                                    <span class="icon is-large block mb-2">
                                        <i class="fa-solid fa-car-burst fa-2x"></i>
                                    </span>
                                    <p>No hay vehículos registrados en la plataforma.</p>
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
    .code-text {
        font-family: monospace;
        background-color: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
    }
</style>

<?php echo view('layout/footer'); ?>