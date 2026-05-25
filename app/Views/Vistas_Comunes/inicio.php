<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



<section class="section section-vehiculos">
    <div class="container">

        <h1 class="title titulo">Vehículos Disponibles</h1>

        <div class="columns is-multiline">
            <?php foreach($vehiculos as $vehiculo): ?>
                
                <div class="column is-12-mobile is-6-tablet is-4-desktop">
                    <div class="vehiculo-card">
                        
                        <div class="card-top-section">

                            <?php if($vehiculo['disponibilidad'] == 'disponible'): ?>
                                <span class="tag is-success status-badge">Disponible</span>
                            <?php else: ?>
                                <span class="tag is-danger status-badge">No Disponible</span>
                            <?php endif; ?>

                            <?php if(!empty($vehiculo['imagen'])): ?>
                                <img src="<?= base_url($vehiculo['imagen']) ?>" alt="<?= $vehiculo['marca']; ?>" class="vehiculo-imagen">
                            <?php else: ?>
                                <div class="vehiculo-imagen" style="height:100px; display:flex; align-items:center; color:#cbd5e1;">
                                    <i class="fa-solid fa-car fa-3x"></i>
                                </div>
                            <?php endif; ?>

                        </div>

                        <div class="card-bottom-section">
                            <h2 class="vehiculo-nombre">
                                <?= $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?>
                            </h2>
                            <p class="vehiculo-subtitulo">
                                Tipo de Vehiculo: <?= ucfirst($vehiculo['tipo_vehiculo']); ?>
                            </p>

                            <div class="specs-group">
                                <div class="spec-item" title="Pasajeros">
                                    <i class="fa-solid fa-user"></i> 
                                    <?= $vehiculo['numero_plazas']; ?>
                                </div>
                                <div class="spec-item" title="Kilometraje">
                                    <i class="fa-solid fa-gauge-high"></i>
                                    <?= $vehiculo['kilometraje']; ?> KM
                                </div>
                            </div>

                            <div class="action-row">
                                <div class="precio-container">
                                    $<?= number_format($vehiculo['precio_alquiler_dia'], 0, ',', '.'); ?>
                                    <span class="precio-periodo">/por día</span>
                                </div>
                                
                                <a href="<?= site_url('cliente/vehiculo/' . $vehiculo['id_vehiculo']) ?>" class="btn-view-deal" style="text-decoration: none; text-align: center; display: inline-flex; align-items: center; justify-content: center;">
                                    Ver Detalle
                                </a>
                            </div>

                        </div>

                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php echo view('layout/footer'); ?>