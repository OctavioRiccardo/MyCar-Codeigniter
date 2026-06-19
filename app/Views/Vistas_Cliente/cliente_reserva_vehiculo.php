<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="login-container">
    <div class="login-card" style="max-width: 500px;">
        
        <h1 class="login-title">Reservar Vehículo</h1>
        <p class="login-subtitle">Elige las fechas para reservar tu vehículo</p>

        <!-- Resumen Breve del Vehículo -->
        <div style="background-color: var(--slate-50); border: 1px solid var(--slate-200); border-radius: var(--radius-lg); padding: 15px; margin-bottom: 25px; display: flex; align-items: center; gap: 15px;">
            <?php if(!empty($vehiculo['imagen'])): ?>
                <img src="<?= base_url($vehiculo['imagen']) ?>" alt="<?= esc($vehiculo['marca']) ?>" style="width: 100px; height: 75px; object-fit: contain; border-radius: var(--radius-md);">
            <?php else: ?>
                <div style="width: 100px; height: 75px; display: flex; align-items: center; justify-content: center; background-color: var(--slate-200); border-radius: var(--radius-md); color: var(--slate-500);">
                    <i class="fa-solid fa-car fa-2x"></i>
                </div>
            <?php endif; ?>
            <div>
                <h3 style="font-weight: 700; color: var(--slate-900); font-size: 1.05rem; margin: 0;">
                    <?= esc($vehiculo['marca']) . ' ' . esc($vehiculo['modelo']) ?>
                </h3>
                <p style="font-size: 0.85rem; color: var(--slate-500); margin: 2px 0 0 0;">
                    Precio por día: <span style="font-weight: 700; color: var(--emerald-700);">$<?= number_format($vehiculo['precio_alquiler_dia'], 0, ',', '.') ?></span>
                </p>
                <p style="font-size: 0.8rem; color: var(--slate-400); margin: 1px 0 0 0;">
                    Año <?= esc($vehiculo['anio']) ?> | Transmisión/Motor: <?= esc($vehiculo['motor']) ?>
                </p>
            </div>
        </div>

        <?php if(session()->getFlashdata('errors')): ?>
            <div class="error-box">
                <ul>
                    <?php foreach(session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('cliente/reservar/procesar') ?>" method="post">
            <input type="hidden" name="id_vehiculo" value="<?= esc($vehiculo['id_vehiculo']) ?>">

            <!-- Fecha Desde -->
            <div class="form-group">
                <label class="form-label">Fecha de Inicio (Desde)</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-calendar-days input-icon"></i>
                    <input 
                        type="date" 
                        name="fecha_desde" 
                        id="fecha_desde"
                        class="form-input" 
                        value="<?= old('fecha_desde', date('Y-m-d')) ?>"
                        min="<?= date('Y-m-d') ?>"
                        required
                    >
                </div>
            </div>

            <!-- Cantidad de Días -->
            <div class="form-group">
                <label class="form-label">Cantidad de Días a Alquilar</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-clock input-icon"></i>
                    <input 
                        type="number" 
                        name="cantidad_dias" 
                        id="cantidad_dias"
                        class="form-input" 
                        placeholder="Ej: 3"
                        min="1"
                        value="<?= old('cantidad_dias', '1') ?>"
                        required
                    >
                </div>
            </div>

            <!-- Método de Pago -->
            <div class="form-group">
                <label class="form-label">Método de Pago</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-credit-card input-icon"></i>
                    <select name="metodopago" id="metodopago" class="form-input" required style="width: 100%; border: 1px solid var(--slate-300); border-radius: var(--radius-md); font-family: var(--font-sans); cursor: pointer;">
                        <option value="efectivo" <?= old('metodopago') == 'efectivo' ? 'selected' : '' ?>>Efectivo</option>
                        <option value="tarjeta" <?= old('metodopago') == 'tarjeta' ? 'selected' : '' ?>>Tarjeta de Crédito / Débito</option>
                        <option value="transferencia" <?= old('metodopago') == 'transferencia' ? 'selected' : '' ?>>Transferencia Bancaria</option>
                    </select>
                </div>
            </div>

            <!-- Acciones -->
            <div style="display: flex; gap: 12px; margin-top: 25px;">
                <a href="<?= site_url('cliente/vehiculo/' . $vehiculo['id_vehiculo']) ?>" class="chakra-btn chakra-btn-outline" style="flex: 1; text-align: center; display: inline-flex; justify-content: center; align-items: center; text-decoration: none;">
                    Cancelar
                </a>
                <button type="submit" class="chakra-btn chakra-btn-solid" style="flex: 1; border: none; font-family: var(--font-sans);">
                    Ver Resumen
                </button>
            </div>

        </form>
    </div>
</div>

<?php echo view('layout/footer'); ?>
