<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .register-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
        padding: 40px 20px;
        background-color: #f9fafb;
        font-family: system-ui, -apple-system, sans-serif;
    }

    .register-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        padding: 40px;
        width: 100%;
        max-width: 520px;
    }

    .register-title {
        font-size: 1.8rem;
        font-weight: 800;
        color: #064e3b;
        text-align: center;
        margin-bottom: 25px;
    }

    .data-item {
        margin-bottom: 18px;
        padding: 14px;
        background: #f8fafc;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    .data-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 6px;
    }

    .data-value {
        font-size: 1rem;
        color: #0f172a;
    }

    .buttons-container {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .btn-confirm,
    .btn-cancel {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-confirm {
        background: linear-gradient(135deg, #059669 0%, #064e3b 100%);
        color: white;
    }

    .btn-cancel {
        background: #e2e8f0;
        color: #334155;
    }

    .btn-confirm:hover,
    .btn-cancel:hover {
        transform: translateY(-1px);
    }
</style>

<div class="register-container">

    <div class="register-card">

        <h1 class="register-title">
            Confirmar Registro
        </h1>

        <div class="data-item">
            <div class="data-label">Nombre de Usuario</div>
            <div class="data-value"><?= esc($usuario['nombre_usuario']) ?></div>
        </div>

        <div class="data-item">
            <div class="data-label">Contraseña</div>
            <div class="data-value">••••••••</div>
        </div>

        <div class="data-item">
            <div class="data-label">Nombre y Apellido</div>
            <div class="data-value"><?= esc($usuario['apellido_usuario']) ?></div>
        </div>

        <div class="data-item">
            <div class="data-label">Dirección</div>
            <div class="data-value"><?= esc($usuario['direccion']) ?></div>
        </div>

        <div class="data-item">
            <div class="data-label">Teléfono</div>
            <div class="data-value"><?= esc($usuario['telefono']) ?></div>
        </div>

        <!-- Confirmar -->
        <form action="<?= site_url('usuarios/guardarConfirmado') ?>" method="post">

            <div class="buttons-container">

                <button type="submit" class="btn-confirm">
                    Confirmar
                </button>

                <a href="<?= site_url('usuarios/create') ?>" 
                   class="btn-cancel"
                   style="text-align:center; text-decoration:none;">
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

<?php echo view('layout/footer'); ?>