<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="show-section">
    <div class="container">
        
        <div class="show-card" style="max-width: 600px;">
            
            <h1 class="show-title">
                <i class="fa-solid fa-circle-user mr-2" style="color: var(--emerald-600);"></i>Mi Perfil
            </h1>
            
            <div class="has-text-centered mb-5">
                <p class="is-size-5 has-text-weight-bold has-text-dark">
                    <?= esc($usuario['nombre_usuario']) ?>
                </p>
                <p class="is-size-6 has-text-grey is-uppercase">
                    Rol: <?= esc($usuario['rol']) ?>
                </p>
            </div>

            <table class="info-table">
                <tbody>
                    <tr>
                        <th>Nombre y Apellido:</th>
                        <td><?= esc($usuario['nombre_usuario'] . ' ' . $usuario['apellido_usuario']) ?></td>
                    </tr>
                    <tr>
                        <th>Dirección:</th>
                        <td><?= esc($usuario['direccion'] ?? 'No especificada') ?></td>
                    </tr>
                    <tr>
                        <th>Teléfono:</th>
                        <td><?= esc($usuario['telefono'] ?? 'No especificado') ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de Registro:</th>
                        <td><?= date('d/m/Y', strtotime($usuario['fecha_alta'])) ?></td>
                    </tr>
                </tbody>
            </table>

            <div class="show-actions">
                <a href="<?= site_url('/') ?>" class="btn-chakra-light">Ir al Inicio</a>
            </div>

        </div>

    </div>
</div>

<?php echo view('layout/footer'); ?>
