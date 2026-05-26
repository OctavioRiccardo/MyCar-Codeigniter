<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



<div class="show-section">
    <div class="container">
        
        <div class="show-card">
            
            <h1 class="show-title"><?= esc($vehiculo['marca']) . ' ' . esc($vehiculo['modelo']) ?></h1>
            
            <div class="show-grid">
                
                <!-- Imagen -->
                <div class="image-container">
                    <?php if(!empty($vehiculo['imagen'])): ?>
                        <img src="<?= base_url($vehiculo['imagen']) ?>" alt="<?= esc($vehiculo['marca']) ?>" class="vehicle-img">
                    <?php else: ?>
                        <div style="text-align: center; color: #94a3b8;">
                            <i class="fa-solid fa-car fa-5x"></i>
                            <p style="margin-top: 10px; font-weight: 600;">Sin Imagen Cargada</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Ficha Técnica -->
                <div>
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <th>Tipo de Vehículo:</th>
                                <td><?= ucfirst(esc($vehiculo['tipo_vehiculo'])) ?></td>
                            </tr>
                            <tr>
                                <th>Año de Compra:</th>
                                <td><?= esc($vehiculo['anio']) ?></td>
                            </tr>
                            <tr>
                                <th>Plazas disponibles:</th>
                                <td><?= esc($vehiculo['numero_plazas']) ?> Personas</td>
                            </tr>
                            <tr>
                                <th>Motorización:</th>
                                <td><?= esc($vehiculo['motor']) ?></td>
                            </tr>
                            <tr>
                                <th>Kilometraje:</th>
                                <td><?= number_format($vehiculo['kilometraje'], 0, ',', '.') ?> KM</td>
                            </tr>
                            <tr>
                                <th>Precio Alquiler/Día:</th>
                                <td><strong>$<?= number_format($vehiculo['precio_alquiler_dia'], 0, ',', '.') ?></strong></td>
                            </tr>
                            <tr>
                                <th>Disponibilidad:</th>
                                <td>
                                    <span class="status-badge-inline <?= $vehiculo['disponibilidad'] == 'disponible' ? 'available' : 'unavailable' ?>">
                                        <?= esc(ucwords(str_replace('_', ' ', $vehiculo['disponibilidad']))) ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="show-actions">
                <a href="<?= site_url('vehiculos') ?>" class="btn-chakra-light">Volver al Listado</a>
                <a href="<?= site_url('vehiculos/edit/'.$vehiculo['id_vehiculo']) ?>" class="btn-chakra-primary">
                    <i class="fa-solid fa-pen-to-square"></i> Editar Vehículo
                </a>
            </div>

        </div>

    </div>
</div>

<?php echo view('layout/footer'); ?>
