<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Estilos inspirados en los Tokens de Diseño de Chakra UI (Paleta Esmeralda) */
    .login-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 75vh;
        padding: 40px 20px;
        background-color: #f9fafb; /* gray.50 */
        font-family: system-ui, -apple-system, sans-serif;
    }

    .login-card {
        background: #ffffff;
        border: 1px solid #e2e8f0; /* gray.200 */
        border-radius: 16px; /* rounded-2xl */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-xl */
        padding: 40px;
        width: 100%;
        max-width: 440px;
        transition: transform 0.2s ease;
    }

    .login-title {
        font-size: 1.85rem;
        font-weight: 800;
        color: #064e3b; /* emerald.900 */
        text-align: center;
        margin-bottom: 8px;
    }

    .login-subtitle {
        font-size: 0.95rem;
        color: #64748b; /* gray.500 */
        text-align: center;
        margin-bottom: 30px;
    }

    /* Mensaje de error / alerta */
    .alert-box {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 8px;
        padding: 12px 16px;
        color: #b91c1c;
        font-size: 0.9rem;
        margin-bottom: 20px;
        text-align: center;
    }

    /* Formularios y Inputs */
    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 0.9rem;
        font-weight: 600;
        color: #334155;
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
        color: #94a3b8;
        font-size: 1rem;
    }

    .form-input {
        width: 100%;
        padding: 10px 12px 10px 40px;
        font-size: 0.95rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #0f172a;
        background-color: #ffffff;
        transition: all 0.2s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.15);
    }

    /* Botón Submit */
    .btn-login-submit {
        width: 100%;
        background: linear-gradient(135deg, #059669 0%, #064e3b 100%);
        color: white;
        font-weight: 700;
        font-size: 1rem;
        padding: 12px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.3);
        transition: all 0.2s ease;
        margin-top: 10px;
    }

    .btn-login-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(5, 150, 105, 0.4);
    }

    .btn-login-submit:active {
        transform: translateY(1px);
    }

    .footer-links {
        margin-top: 24px;
        text-align: center;
        font-size: 0.9rem;
        color: #64748b;
    }

    .footer-links a {
        color: #059669;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .footer-links a:hover {
        color: #047857;
        text-decoration: underline;
    }
</style>

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
                        name="clave_usuario" 
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