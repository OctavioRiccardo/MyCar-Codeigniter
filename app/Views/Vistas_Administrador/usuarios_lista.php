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

    /* Notificación de Éxito */
    .notify-box {
        background-color: #ecfdf5; /* emerald.50 */
        border: 1px solid #a7f3d0; /* emerald.200 */
        border-radius: 8px;
        padding: 12px 16px;
        color: #047857; /* emerald.700 */
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
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
        background-color: #f1f5f9; /* slate.100 */
    }

    /* Badges de Rol */
    .role-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .role-badge.admin {
        background-color: #e0f2fe; /* sky.100 */
        color: #0369a1; /* sky.700 */
    }

    .role-badge.client {
        background-color: #f1f5f9; /* slate.100 */
        color: #475569; /* slate.600 */
    }

    /* Botones estilo Chakra UI */
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

    /* Grupo de Botones de Acción */
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
        transition: background 0.2s ease, transform 0.1s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-action.edit {
        background-color: #fef3c7; /* amber.100 */
        color: #d97706; /* amber.600 */
    }

    .btn-action.edit:hover {
        background-color: #fde68a; /* amber.200 */
    }

    .btn-action.delete {
        background-color: #fee2e2; /* red.100 */
        color: #dc2626; /* red.600 */
    }

    .btn-action.delete:hover {
        background-color: #fca5a5; /* red.300 */
    }
</style>

<div class="admin-section">
    <div class="container">
        
        <div class="admin-card">
            
            <div class="admin-header">
                <h1 class="admin-title">Administración de Clientes</h1>
                <a href="<?= site_url('usuarios/crear') ?>" class="btn-chakra-primary">
                    <i class="fa-solid fa-user-plus"></i> Registrar Cliente
                </a>
            </div>

            <?php if(session()->getFlashdata('mensaje')): ?>
                <div class="notify-box">
                    <i class="fa-solid fa-circle-check"></i>
                    <?= session()->getFlashdata('mensaje') ?>
                </div>
            <?php endif; ?>

            <div class="table-container">
                <table class="chakra-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Nombre y Apellido</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Rol</th>
                            <th>Fecha de Alta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($usuarios)): ?>
                            <?php foreach($usuarios as $user): ?>
                                <tr>
                                    <td><strong>#<?= $user['id_usuario'] ?></strong></td>
                                    <td><?= esc($user['nombre_usuario']) ?></td>
                                    <td><?= esc($user['nombre_usuario'] . ' ' . $user['apellido_usuario']) ?></td>
                                    <td><?= esc($user['direccion'] ?? 'No especificada') ?></td>
                                    <td><?= esc($user['telefono'] ?? 'No especificado') ?></td>
                                    <td>
                                        <span class="role-badge <?= $user['rol'] == 'administrador' ? 'admin' : 'client' ?>">
                                            <?= esc($user['rol']) ?>
                                        </span>
                                    </td>
                                    <td><?= esc($user['fecha_alta']) ?></td>
                                    <td>
                                        <div class="actions-group">
                                            <a href="<?= site_url('usuarios/editar/'.$user['id_usuario']) ?>" class="btn-action edit">
                                                <i class="fa-solid fa-pen-to-square"></i> Editar
                                            </a>
                                            <a href="<?= site_url('usuarios/eliminar/'.$user['id_usuario']) ?>" class="btn-action delete" onclick="return confirm('¿Seguro que desea dar de baja lógica a este cliente?')">
                                                <i class="fa-solid fa-user-slash"></i> Baja
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" style="text-align: center; color: #94a3b8; padding: 30px;">
                                    No hay usuarios registrados en el sistema.
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
