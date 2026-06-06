<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



<div class="form-section">
    <div class="form-card">
        
        <h1 class="form-title">Registrar Vehículo</h1>
        <p class="form-subtitle">Agrega un nuevo vehículo a la flota de alquileres</p>

        <form action="<?= site_url('vehiculos/create') ?>" method="post">
            
            <div class="form-grid">
                
                <!-- Tipo de Vehículo -->
                <div class="form-group">
                    <label class="form-label">Tipo de Vehículo</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-list input-icon"></i>
                        <select name="tipo_vehiculo" class="form-select" required>
                            <option value="auto">Auto</option>
                            <option value="moto">Moto</option>
                            <option value="camioneta">Camioneta</option>
                        </select>
                    </div>
                </div>

                <!-- Marca -->
                <div class="form-group">
                    <label class="form-label">Marca</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-copyright input-icon"></i>
                        <input class="form-input" type="text" name="marca" placeholder="ej. Toyota" required>
                    </div>
                </div>

                <!-- Modelo -->
                <div class="form-group">
                    <label class="form-label">Modelo</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-car-side input-icon"></i>
                        <input class="form-input" type="text" name="modelo" placeholder="ej. Corolla" required>
                    </div>
                </div>

                <!-- Año -->
                <div class="form-group">
                    <label class="form-label">Año</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-calendar-days input-icon"></i>
                        <input class="form-input" type="number" name="anio" min="1900" max="<?= date('Y')+1 ?>" placeholder="ej. 2022" required>
                    </div>
                </div>

                <!-- Número de Plazas -->
                <div class="form-group">
                    <label class="form-label">Número de Plazas</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-users input-icon"></i>
                        <input class="form-input" type="number" name="numero_plazas" min="1" placeholder="ej. 5" required>
                    </div>
                </div>

                <!-- Motor -->
                <div class="form-group">
                    <label class="form-label">Motor</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-gears input-icon"></i>
                        <input class="form-input" type="text" name="motor" placeholder="ej. 2.0 / 250cc" required>
                    </div>
                </div>

                <!-- Kilometraje -->
                <div class="form-group">
                    <label class="form-label">Kilometraje (KM)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-gauge-high input-icon"></i>
                        <input class="form-input" type="number" step="any" name="kilometraje" placeholder="ej. 15000" required>
                    </div>
                </div>

                <!-- Precio por Día -->
                <div class="form-group">
                    <label class="form-label">Precio por Día ($)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-money-bill-wave input-icon"></i>
                        <input class="form-input" type="number" step="any" name="precio_alquiler_dia" placeholder="ej. 35000" required>
                    </div>
                </div>

                <!-- Imagen URL -->
                <div class="form-group full-width">
                    <label class="form-label">Imagen URL (Opcional)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-image input-icon"></i>
                        <input class="form-input" type="text" name="imagen" placeholder="Dirección de la imagen">
                    </div>
                </div>

                <!-- Disponibilidad -->
                <div class="form-group full-width">
                    <label class="form-label">Disponibilidad Inicial</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-circle-info input-icon"></i>
                        <select name="disponibilidad" class="form-select">
                            <option value="disponible">Disponible</option>
                            <option value="no_disponible">No Disponible</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <a href="<?= site_url('vehiculos') ?>" class="btn-chakra-light">Cancelar</a>
                <button type="submit" class="btn-chakra-primary">Guardar Vehículo</button>
            </div>

        </form>

    </div>
</div>

<?php echo view('layout/footer'); ?>
