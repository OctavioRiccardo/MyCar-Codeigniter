<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



<div class="detail-section">
    <div class="container">
        
        <div class="detail-card">
            
            <div class="detail-header">
                <h1 class="detail-title">
                    <?= esc($vehiculo['marca']) . ' ' . esc($vehiculo['modelo']) ?>
                </h1>
                <p class="detail-subtitle">
                    <span class="status-badge <?= $vehiculo['disponibilidad'] == 'disponible' ? 'available' : 'unavailable' ?>">
                        <?= esc($vehiculo['disponibilidad']) ?>
                    </span>
                    <span>•</span>
                    <span>Modelo <?= esc($vehiculo['anio']) ?></span>
                </p>
            </div>
            
            <div class="detail-grid">
                
                <!-- Columna Izquierda: Imagen -->
                <div class="image-container">
                    <?php if(!empty($vehiculo['imagen'])): ?>
                        <img src="<?= base_url($vehiculo['imagen']) ?>" alt="<?= esc($vehiculo['marca']) . ' ' . esc($vehiculo['modelo']) ?>" class="vehicle-img">
                    <?php else: ?>
                        <div style="text-align: center; color: #94a3b8;">
                            <i class="fa-solid fa-car fa-5x"></i>
                            <p style="margin-top: 14px; font-weight: 600;">Sin Imagen Disponible</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Columna Derecha: Ficha Técnica -->
                <div>
                    <div class="specs-card">
                        <h2 class="specs-title">Ficha Técnica</h2>
                        
                        <table class="info-table">
                            <tbody>
                                <tr>
                                    <th>Tipo de Vehículo</th>
                                    <td><?= ucfirst(esc($vehiculo['tipo_vehiculo'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Plazas disponibles</th>
                                    <td><?= esc($vehiculo['numero_plazas']) ?> Personas</td>
                                </tr>
                                <tr>
                                    <th>Motorización</th>
                                    <td><?= esc($vehiculo['motor']) ?></td>
                                </tr>
                                <tr>
                                    <th>Kilometraje actual</th>
                                    <td><?= number_format($vehiculo['kilometraje'], 0, ',', '.') ?> KM</td>
                                </tr>
                                <tr>
                                    <th>Precio Alquiler / Día</th>
                                    <td class="precio-destacado">
                                        <strong>$<?= number_format($vehiculo['precio_alquiler_dia'], 0, ',', '.') ?></strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <?php if (!session()->get('logueado')): ?>
                        <div class="login-alert-box">
                            <i class="fa-solid fa-circle-info"></i>
                            <div>
                                Para poder reservar este vehículo, necesitas tener una cuenta en nuestra plataforma. 
                                <a href="<?= site_url('login') ?>">Inicia sesión aquí</a> o 
                                <a href="<?= site_url('usuarios/crear') ?>">regístrate gratis</a>.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>

            <!-- Fila de Acciones -->
            <div class="detail-actions">
                <a href="<?= site_url('/') ?>" class="chakra-btn chakra-btn-outline">
                    <i class="fa-solid fa-arrow-left"></i> Volver al Catálogo
                </a>

                <?php if (session()->get('logueado')): ?>
                    <?php if ($vehiculo['disponibilidad'] == 'disponible'): ?>
                        <a href="<?= site_url('cliente/reservar/' . $vehiculo['id_vehiculo']) ?>" class="chakra-btn chakra-btn-solid">
                            <i class="fa-solid fa-calendar-check"></i> Reservar Alquiler
                        </a>
                    <?php else: ?>
                        <button class="chakra-btn chakra-btn-disabled" disabled>
                            <i class="fa-solid fa-ban"></i> No Disponible para Reserva
                        </button>
                    <?php endif; ?>
                <?php else: ?>
                    <button class="chakra-btn chakra-btn-disabled" disabled title="Inicia sesión para reservar">
                        <i class="fa-solid fa-lock"></i> Reservar Alquiler
                    </button>
                <?php endif; ?>
            </div>

        </div>

    </div>
</div>

<?php echo view('layout/footer'); ?>
