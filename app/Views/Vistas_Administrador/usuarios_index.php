<?php echo view('layout/header'); ?>

<section class="section">
    <div class="container">
        <h1 class="title">Administración de Usuarios</h1>

        <?php if(session()->getFlashdata('mensaje')): ?>
            <div class="notification is-success">
                <?= session()->getFlashdata('mensaje') ?>
            </div>
        <?php endif; ?>

        <div class="buttons">
            <a href="<?= site_url('usuarios/crear') ?>" class="button is-primary">Registrar Cliente</a>
        </div>

        <div class="table-container">
            <table class="table is-striped is-fullwidth">
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
                                <td><?= $user['id_usuario'] ?></td>
                                <td><?= esc($user['nombre_usuario']) ?></td>
                                <td><?= esc($user['apellido_usuario']) ?></td>
                                <td><?= esc($user['direccion']) ?></td>
                                <td><?= esc($user['telefono']) ?></td>
                                <td><span class="tag <?= $user['rol'] == 'administrador' ? 'is-info' : 'is-light' ?>"><?= esc($user['rol']) ?></span></td>
                                <td><?= esc($user['fecha_alta']) ?></td>
                                <td>
                                    <div class="buttons are-small">
                                        <a href="<?= site_url('usuarios/editar/'.$user['id_usuario']) ?>" class="button is-warning">Editar</a>
                                        <a href="<?= site_url('usuarios/eliminar/'.$user['id_usuario']) ?>" class="button is-danger" onclick="return confirm('¿Seguro que desea dar de baja lógica a este cliente?')">Baja</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="has-text-centered">No hay usuarios registrados.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php echo view('layout/footer'); ?>
