<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Estilos inspirados en los Tokens de Diseño de Chakra UI (Paleta Esmeralda) */
    .form-section {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
        padding: 40px 20px;
        background-color: #f9fafb; /* gray.50 */
        font-family: system-ui, -apple-system, sans-serif;
    }

    .form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0; /* gray.200 */
        border-radius: 16px; /* rounded-2xl */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-xl */
        padding: 40px;
        width: 100%;
        max-width: 600px;
    }

    .form-title {
        font-size: 1.85rem;
        font-weight: 800;
        color: #064e3b; /* emerald.900 */
        text-align: center;
        margin-bottom: 8px;
    }

    .form-subtitle {
        font-size: 0.95rem;
        color: #64748b; /* gray.500 */
        text-align: center;
        margin-bottom: 30px;
    }

    /* Grid de Formulario */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media screen and (max-width: 600px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full-width {
        grid-column: span 2;
    }

    @media screen and (max-width: 600px) {
        .form-group.full-width {
            grid-column: span 1;
        }
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #334155; /* gray.700 */
        margin-bottom: 6px;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 12px;
        color: #94a3b8; /* gray.400 */
        font-size: 1rem;
    }

    .form-input {
        width: 100%;
        padding: 10px 12px 10px 40px;
        font-size: 0.95rem;
        border: 1px solid #cbd5e1; /* gray.300 */
        border-radius: 8px;
        color: #0f172a;
        background-color: #ffffff;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #059669; /* emerald.600 */
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15); /* anillo focus esmeralda */
    }

    /* Selects */
    .form-select {
        width: 100%;
        padding: 10px 12px 10px 40px;
        font-size: 0.95rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #0f172a;
        background-color: #ffffff;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23475569' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
        transition: all 0.2s ease;
    }

    .form-select:focus {
        outline: none;
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15);
    }

    /* Acciones */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 20px;
        border-top: 1px solid #e2e8f0;
        padding-top: 20px;
    }

    .btn-chakra-primary {
        background: linear-gradient(135deg, #059669 0%, #064e3b 100%);
        color: white;
        font-weight: 700;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.3);
        transition: all 0.2s ease;
    }

    .btn-chakra-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(5, 150, 105, 0.4);
    }

    .btn-chakra-light {
        background-color: #edf2f7; /* gray.100 */
        color: #4a5568; /* gray.600 */
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-chakra-light:hover {
        background-color: #e2e8f0; /* gray.200 */
        color: #4a5568;
    }
</style>

<div class="form-section">
    <div class="form-card">
        
        <h1 class="form-title">Editar Vehículo</h1>
        <p class="form-subtitle">Modifica los detalles técnicos o la disponibilidad del vehículo</p>

        <form action="<?= site_url('vehiculos/update/'.$vehiculo['id_vehiculo']) ?>" method="post">
            
            <div class="form-grid">
                
                <!-- Tipo de Vehículo -->
                <div class="form-group">
                    <label class="form-label">Tipo de Vehículo</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-list input-icon"></i>
                        <select name="tipo_vehiculo" class="form-select" required>
                            <option value="auto" <?= $vehiculo['tipo_vehiculo'] == 'auto' ? 'selected' : '' ?>>Auto</option>
                            <option value="moto" <?= $vehiculo['tipo_vehiculo'] == 'moto' ? 'selected' : '' ?>>Moto</option>
                            <option value="camioneta" <?= $vehiculo['tipo_vehiculo'] == 'camioneta' ? 'selected' : '' ?>>Camioneta</option>
                        </select>
                    </div>
                </div>

                <!-- Marca -->
                <div class="form-group">
                    <label class="form-label">Marca</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-copyright input-icon"></i>
                        <input class="form-input" type="text" name="marca" value="<?= esc($vehiculo['marca']) ?>" required>
                    </div>
                </div>

                <!-- Modelo -->
                <div class="form-group">
                    <label class="form-label">Modelo</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-car-side input-icon"></i>
                        <input class="form-input" type="text" name="modelo" value="<?= esc($vehiculo['modelo']) ?>" required>
                    </div>
                </div>

                <!-- Año -->
                <div class="form-group">
                    <label class="form-label">Año</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-calendar-days input-icon"></i>
                        <input class="form-input" type="number" name="anio" min="1900" max="<?= date('Y')+1 ?>" value="<?= esc($vehiculo['anio']) ?>" required>
                    </div>
                </div>

                <!-- Número de Plazas -->
                <div class="form-group">
                    <label class="form-label">Número de Plazas</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-users input-icon"></i>
                        <input class="form-input" type="number" name="numero_plazas" min="1" value="<?= esc($vehiculo['numero_plazas']) ?>" required>
                    </div>
                </div>

                <!-- Motor -->
                <div class="form-group">
                    <label class="form-label">Motor</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-gears input-icon"></i>
                        <input class="form-input" type="text" name="motor" value="<?= esc($vehiculo['motor']) ?>" required>
                    </div>
                </div>

                <!-- Kilometraje -->
                <div class="form-group">
                    <label class="form-label">Kilometraje (KM)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-gauge-high input-icon"></i>
                        <input class="form-input" type="number" step="any" name="kilometraje" value="<?= esc($vehiculo['kilometraje']) ?>" required>
                    </div>
                </div>

                <!-- Precio por Día -->
                <div class="form-group">
                    <label class="form-label">Precio por Día ($)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-money-bill-wave input-icon"></i>
                        <input class="form-input" type="number" step="any" name="precio_alquiler_dia" value="<?= esc($vehiculo['precio_alquiler_dia']) ?>" required>
                    </div>
                </div>

                <!-- Imagen URL -->
                <div class="form-group full-width">
                    <label class="form-label">Imagen URL (Opcional)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-image input-icon"></i>
                        <input class="form-input" type="text" name="imagen" value="<?= esc($vehiculo['imagen']) ?>">
                    </div>
                </div>

                <!-- Disponibilidad -->
                <div class="form-group full-width">
                    <label class="form-label">Disponibilidad</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-circle-info input-icon"></i>
                        <select name="disponibilidad" class="form-select">
                            <option value="disponible" <?= $vehiculo['disponibilidad'] == 'disponible' ? 'selected' : '' ?>>Disponible</option>
                            <option value="no_disponible" <?= $vehiculo['disponibilidad'] == 'no_disponible' ? 'selected' : '' ?>>No Disponible</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <a href="<?= site_url('vehiculos') ?>" class="btn-chakra-light">Cancelar</a>
                <button type="submit" class="btn-chakra-primary">Actualizar Vehículo</button>
            </div>

        </form>

    </div>
</div>

<?php echo view('layout/footer'); ?>
