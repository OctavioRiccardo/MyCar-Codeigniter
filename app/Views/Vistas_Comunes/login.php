<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



<div class="login-container">
    <div class="login-card">
        
        <h1 class="login-title">Iniciar Sesión</h1>
        <p class="login-subtitle">Ingresa a tu cuenta de MyCar para reservar vehículos</p>

        <?php if(session()->getFlashdata('error_login')): ?>
            <div class="alert-box">
                <?= session()->getFlashdata('error_login') ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('login/validar') ?>" method="post">

            <!-- Nombre de Usuario -->
            <div class="form-group">
                <label class="form-label">Nombre de Usuario</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user input-icon"></i>
                    <input 
                        type="text" 
                        name="nombre_usuario" 
                        class="form-input" 
                        placeholder="Ingresa tu usuario"
                        value="<?= old('nombre_usuario') ?>"
                        required
                    >
                </div>
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <label class="form-label">Contraseña</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Ingresa tu contraseña"
                        required
                    >
                </div>
            </div>

            <button type="submit" class="btn-login-submit">
                Entrar
            </button>

            <div class="footer-links">
                ¿No tienes cuenta? <a href="<?= site_url('usuarios/crear') ?>">Regístrate aquí</a>
            </div>

        </form>

    </div>
</div>

<?php echo view('layout/footer'); ?>