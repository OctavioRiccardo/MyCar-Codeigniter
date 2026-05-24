<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Estilos inspirados en Chakra UI (Paleta Esmeralda) */
    .admin-section {
        padding: 40px 20px;
        background-color: #f9fafb; /* gray.50 */
        min-height: 80vh;
        font-family: system-ui, -apple-system, sans-serif;
    }

    .admin-card {
        background: #ffffff;
        border: 1px solid #e2e8f0; /* gray.200 */
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        padding: 30px;
        margin-top: 20px;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .admin-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #064e3b; /* emerald.900 */
    }

    /* Tabla Chakra UI */
    .table-container {
        overflow-x: auto;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .chakra-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.95rem;
    }

    .chakra-table th {
        background-color: #f8fafc; /* slate.50 */
        color: #475569; /* slate.600 */
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 14px 20px;
        border-bottom: 2px solid #e2e8f0;
    }

    .chakra-table td {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        color: #1e293b; /* slate.800 */
    }

    .chakra-table tr:hover {
        background-color: #f1f5f9;
    }

    /* Badges de Disponibilidad */
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-badge.available {
        background-color: #ecfdf5; /* emerald.50 */
        color: #059669; /* emerald.600 */
    }

    .status-badge.unavailable {
        background-color: #fef2f2; /* red.50 */
        color: #dc2626; /* red.600 */
    }

    /* Botón Primary Gradiente */
    .btn-chakra-primary {
        background: linear-gradient(135deg, #059669 0%, #064e3b 100%);
        color: white;
        font-weight: 700;
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.3);
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-chakra-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(5, 150, 105, 0.4);
        color: white;
    }

    /* Grupo de Acciones */
    .actions-group {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        padding: 6px 12px;
        font-size: 0.85rem;
        font-weight: 700;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-action.show {
        background-color: #f0fdf4; /* emerald.50 */
        color: #059669;
    }

    .btn-action.show:hover {
        background-color: #d1fae5; /* emerald.100 */
    }

    .btn-action.edit {
        background-color: #fef3c7; /* amber.100 */
        color: #d97706;
    }

    .btn-action.edit:hover {
        background-color: #fde68a;
    }

    .btn-action.delete {
        background-color: #fee2e2; /* red.100 */
        color: #dc2626;
    }

    .btn-action.delete:hover {
        background-color: #fca5a5;
    }
</style>

<div class="admin-section">
    <div class="container">
        
        <div class="admin-card">
            
            <div class="admin-header">
                <h1 class="admin-title">Administración de Vehículos</h1>
                <a href="<?= site_url('vehiculos/new') ?>" class="btn-chakra-primary">
                    <i class="fa-solid fa-car-side"></i> Registrar Vehículo
                </a>
            </div>

            <div class="table-container">
                <table class="chakra-table">
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
                                    <td><strong>#<?= $v['id_vehiculo'] ?></strong></td>
                                    <td><?= esc($v['marca']) ?></td>
                                    <td><?= esc($v['modelo']) ?></td>
                                    <td><?= esc($v['anio']) ?></td>
                                    <td><span style="font-weight:600; color:#475569;"><?= ucfirst(esc($v['tipo_vehiculo'])) ?></span></td>
                                    <td><?= esc($v['numero_plazas']) ?></td>
                                    <td><?= esc($v['motor']) ?></td>
                                    <td><?= number_format($v['kilometraje'], 0, ',', '.') ?> KM</td>
                                    <td><strong>$<?= number_format($v['precio_alquiler_dia'], 0, ',', '.') ?></strong></td>
                                    <td>
                                        <span class="status-badge <?= $v['disponibilidad'] == 'disponible' ? 'available' : 'unavailable' ?>">
                                            <?= ucfirst(esc($v['disponibilidad'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="actions-group">
                                            <a href="<?= site_url('vehiculos/'.$v['id_vehiculo']) ?>" class="btn-action show">
                                                <i class="fa-solid fa-eye"></i> Ver
                                            </a>
                                            <a href="<?= site_url('vehiculos/edit/'.$v['id_vehiculo']) ?>" class="btn-action edit">
                                                <i class="fa-solid fa-pen-to-square"></i> Editar
                                            </a>
                                            <a href="<?= site_url('vehiculos/delete/'.$v['id_vehiculo']) ?>" class="btn-action delete" onclick="return confirm('¿Seguro que desea dar de baja lógica a este vehículo?')">
                                                <i class="fa-solid fa-trash-can"></i> Baja
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" style="text-align: center; color: #94a3b8; padding: 30px;">
                                    No hay vehículos registrados.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</div>

<?php echo view('layout/footer'); ?>
