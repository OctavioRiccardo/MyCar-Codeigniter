<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="login-container">
    <div class="login-card" style="max-width: 550px;">
        
        <h1 class="login-title">Resumen de Reserva</h1>
       
        <!-- Ficha de Detalles de la Reserva -->
        <div class="specs-card" style="margin-bottom: 25px;">
            <h2 class="specs-title">Detalles del Alquiler</h2>
            
            <table class="info-table">
                <tbody>
                    <tr>
                        <th>Vehículo</th>
                        <td><strong class="reserva-vehiculo-nombre"><?= esc($vehiculo['marca']) . ' ' . esc($vehiculo['modelo']) ?></strong></td>
                    </tr>
                    <tr>
                        <th>Año / Motor</th>
                        <td><?= esc($vehiculo['anio']) ?> | <?= esc($vehiculo['motor']) ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de Inicio</th>
                        <td><?= date('d/m/Y', strtotime($reserva['fecha_desde'])) ?></td>
                    </tr>
                    <tr>
                        <th>Días de Alquiler</th>
                        <td><?= esc($reserva['cantidad_dias']) ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de Devolución</th>
                        <td><strong class="reserva-fecha-hasta"><?= date('d/m/Y', strtotime($reserva['fecha_hasta'])) ?></strong></td>
                    </tr>
                    <tr>
                        <th>Precio por Día</th>
                        <td>$<?= number_format($vehiculo['precio_alquiler_dia'], 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Método de Pago</th>
                        <td><span class="tag is-info is-light has-text-weight-semibold" style="text-transform: capitalize; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; background-color: var(--slate-100); color: var(--slate-700); border: 1px solid var(--slate-200); font-family: var(--font-sans);"><i class="fa-solid fa-credit-card mr-1"></i><?= ucfirst(esc($reserva['metodopago'] ?? 'efectivo')) ?></span></td>
                    </tr>
                    <tr>
                        <th>Precio Total Est.</th>
                        <td class="precio-destacado">
                            <strong>$<?= number_format($reserva['precio_total'], 0, ',', '.') ?></strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <form action="<?= site_url('cliente/reservas/confirmar') ?>" method="post">
            <!-- Acciones -->
            <div style="display: flex; gap: 12px;">
                <a href="<?= site_url('cliente/reservar/' . $vehiculo['id_vehiculo']) ?>" class="chakra-btn chakra-btn-outline" style="flex: 1; text-align: center; display: inline-flex; justify-content: center; align-items: center; text-decoration: none;">
                    <i class="fa-solid fa-pen"></i> Modificar Datos
                </a>
                <button type="submit" class="chakra-btn chakra-btn-solid" style="flex: 1; border: none; font-family: var(--font-sans); background: linear-gradient(135deg, var(--emerald-600) 0%, var(--emerald-900) 100%);">
                    <i class="fa-solid fa-check"></i> Confirmar Reserva
                </button>
            </div>
        </form>

    </div>
</div>

<?php echo view('layout/footer'); ?>
