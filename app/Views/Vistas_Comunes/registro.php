<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Estilos inspirados en los Tokens de Diseño de Chakra UI (Paleta Esmeralda) */
    .register-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
        padding: 40px 20px;
        background-color: #f9fafb; /* gray.50 */
        font-family: system-ui, -apple-system, sans-serif;
    }

    .register-card {
        background: #ffffff;
        border: 1px solid #e2e8f0; /* gray.200 */
        border-radius: 16px; /* rounded-2xl */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-xl */
        padding: 40px;
        width: 100%;
        max-width: 520px;
        transition: transform 0.2s ease;
    }

    .register-title {
        font-size: 1.85rem;
        font-weight: 800;
        color: #064e3b; /* emerald.900 */
        text-align: center;
        margin-bottom: 8px;
    }

    .register-subtitle {
        font-size: 0.95rem;
        color: #64748b; /* gray.500 */
        text-align: center;
        margin-bottom: 30px;
    }

    /* Mensajes de error */
    .error-box {
        background-color: #fef2f2; /* red.50 */
        border: 1px solid #fecaca; /* red.200 */
        border-radius: 8px;
        padding: 12px 16px;
        color: #b91c1c; /* red.700 */
        font-size: 0.9rem;
        margin-bottom: 20px;
    }

    .error-box ul {
        margin-left: 20px;
        list-style-type: disc;
    }

    /* Formularios y Inputs estilo Chakra UI */
    .form-group {
        margin-bottom: 20px;
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

    /* Botón con gradiente de Chakra UI */
    .btn-register-submit {
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

    .btn-register-submit:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(5, 150, 105, 0.4);
    }

    .btn-register-submit:active {
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

<div class="register-container">
    <div class="register-card">
        
        <h1 class="register-title"><?= $titulo ?></h1>
        <p class="register-subtitle">Completa tus datos para ingresar al ecosistema de alquileres MyCar</p>

        <?php if(session()->getFlashdata('errors')): ?>
            <div class="error-box">
                <ul>
                    <?php foreach(session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('usuarios/confirmar') ?>" method="post">

            <!-- Nombre de Usuario -->
            <div class="form-group">
                <label class="form-label">Nombre de Usuario</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user-tag input-icon"></i>
                    <input 
                        type="text" 
                        name="nombre_usuario" 
                        class="form-input" 
                        placeholder="ej. juanperez"
                        value="<?= old('nombre_usuario', $usuario['nombre_usuario'] ?? '') ?>"
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
                        placeholder="Mínimo 8 caracteres"
                        minlength="8"
                        <?= isset($usuario) ? '' : 'required' ?>
                    >
                </div>
            </div>

            <!-- Nombre y Apellido -->
            <div class="form-group">
                <label class="form-label">Nombre y Apellido</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-signature input-icon"></i>
                    <input 
                        type="text" 
                        name="nombre_apellido" 
                        class="form-input" 
                        placeholder="ej. Juan Pérez"
                        value="<?= old('nombre_apellido', $usuario['nombre_apellido'] ?? '') ?>"
                        required
                    >
                </div>
            </div>

            <!-- Dirección -->
            <div class="form-group">
                <label class="form-label">Dirección</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-map-location-dot input-icon"></i>
                    <input 
                        type="text" 
                        name="direccion" 
                        class="form-input" 
                        placeholder="Dirección particular"
                        value="<?= old('direccion', $usuario['direccion'] ?? '') ?>"
                    >
                </div>
            </div>

            <!-- Teléfono -->
            <div class="form-group">
                <label class="form-label">Teléfono</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-phone input-icon"></i>
                    <input 
                        type="tel" 
                        name="telefono" 
                        class="form-input" 
                        placeholder="Número de contacto"
                        value="<?= old('telefono', $usuario['telefono'] ?? '') ?>"
                    >
                </div>
            </div>

            <button type="submit" class="btn-register-submit">
                <?= isset($usuario) ? 'Actualizar Datos' : 'Registrarse' ?>
            </button>

            <div class="footer-links">
                <?php if(!isset($usuario)): ?>
                    ¿Ya tienes una cuenta? <a href="<?= site_url('login') ?>">Inicia Sesión aquí</a>
                <?php else: ?>
                    <a href="<?= site_url('usuarios') ?>">Volver al Panel</a>
                <?php endif; ?>
            </div>

        </form>

    </div>
</div>

<?php echo view('layout/footer'); ?>

<!-- JAVASCRIPT para el control del formulario -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const formulario = document.querySelector('form');

    const nombreUsuario = document.querySelector('input[name="nombre_usuario"]');
    const claveUsuario = document.querySelector('input[name="clave_usuario"]');
    const nombreApellido = document.querySelector('input[name="nombre_apellido"]');
    const direccion = document.querySelector('input[name="direccion"]');
    const telefono = document.querySelector('input[name="telefono"]');

    formulario.addEventListener('submit', function (e) {

        let errores = [];

        // Limpiar errores visuales previos
        limpiarErrores();

        // =========================
        // Nombre de Usuario
        // =========================
        if (nombreUsuario.value.trim() === '') {
            errores.push('El nombre de usuario es obligatorio.');
            marcarError(nombreUsuario);
        }

        // =========================
        // Contraseña
        // =========================
        if (claveUsuario.hasAttribute('required') || claveUsuario.value.trim() !== '') {

            if (claveUsuario.value.trim() === '') {
                errores.push('La contraseña es obligatoria.');
                marcarError(claveUsuario);
            }
            else if (claveUsuario.value.length < 8) {
                errores.push('La contraseña debe tener al menos 8 caracteres.');
                marcarError(claveUsuario);
            }
        }

        // =========================
        // Nombre y Apellido
        // =========================
        if (nombreApellido.value.trim() === '') {
            errores.push('El nombre y apellido es obligatorio.');
            marcarError(nombreApellido);
        }

        // =========================
        // Dirección
        // =========================
        if (direccion.value.trim() === '') {
            errores.push('La dirección es obligatoria.');
            marcarError(direccion);
        }

        // =========================
        // Teléfono
        // =========================
        if (telefono.value.trim() === '') {
            errores.push('El teléfono es obligatorio.');
            marcarError(telefono);
        }

        // =========================
        // Mostrar errores
        // =========================
        if (errores.length > 0) {

            e.preventDefault();

            mostrarErrores(errores);
        }

    });

    // ====================================
    // Función marcar error visual
    // ====================================
    function marcarError(input) {
        input.style.borderColor = '#dc2626';
        input.style.boxShadow = '0 0 0 3px rgba(220, 38, 38, 0.15)';
    }

    // ====================================
    // Limpiar errores visuales
    // ====================================
    function limpiarErrores() {

        const inputs = document.querySelectorAll('.form-input');

        inputs.forEach(input => {
            input.style.borderColor = '#cbd5e1';
            input.style.boxShadow = 'none';
        });

        const errorAnterior = document.querySelector('.error-box-js');

        if (errorAnterior) {
            errorAnterior.remove();
        }
    }

    // ====================================
    // Mostrar errores arriba del formulario
    // ====================================
    function mostrarErrores(errores) {

        const divError = document.createElement('div');

        divError.classList.add('error-box');
        divError.classList.add('error-box-js');

        let html = '<ul>';

        errores.forEach(error => {
            html += `<li>${error}</li>`;
        });

        html += '</ul>';

        divError.innerHTML = html;

        const titulo = document.querySelector('.register-subtitle');

        titulo.insertAdjacentElement('afterend', divError);
    }

});
</script>