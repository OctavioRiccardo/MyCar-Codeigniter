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

    /* Chakra UI Modal Custom Styles */
    .chakra-modal-portal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 1400;
        display: flex;
        align-items: center;
        justify-content: center;
        visibility: hidden;
        transition: visibility 0.2s;
    }

    .chakra-modal-portal.is-active {
        visibility: visible;
        transition: none;
    }

    .chakra-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.48);
        backdrop-filter: blur(5px);
        z-index: 1401;
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }

    .chakra-modal-portal.is-active .chakra-modal-overlay {
        opacity: 1;
    }

    .chakra-modal-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1402;
        pointer-events: none;
    }

    .chakra-modal-content {
        background: #ffffff;
        color: #1a202c;
        border-radius: 12px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02), 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        width: 100%;
        max-width: 448px;
        margin: 1.5rem;
        position: relative;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
        pointer-events: auto;
        
        transform: scale(0.95);
        opacity: 0;
        transition: transform 0.2s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.2s ease-in-out;
    }

    .chakra-modal-portal.is-active .chakra-modal-content {
        transform: scale(1);
        opacity: 1;
    }

    .chakra-modal-header {
        padding: 24px 24px 8px 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0;
    }

    .chakra-modal-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a202c;
        line-height: 1.2;
        margin: 0;
    }

    .chakra-modal-close-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        border-radius: 6px;
        color: #4a5568;
        cursor: pointer;
        transition: background-color 0.15s ease, color 0.15s ease;
        outline: none;
        padding: 0;
    }

    .chakra-modal-close-btn:hover {
        background-color: #edf2f7;
        color: #1a202c;
    }

    .chakra-modal-close-btn:active {
        background-color: #e2e8f0;
    }

    .chakra-modal-body {
        padding: 8px 24px 24px 24px;
        color: #2d3748;
        font-size: 1rem;
        line-height: 1.5;
        flex: 1;
    }

    .chakra-modal-desc {
        color: #4a5568;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 16px;
    }

    .chakra-modal-footer {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 12px;
        padding: 16px 24px 24px 24px;
    }

    .chakra-btn {
        display: inline-flex;
        appearance: none;
        align-items: center;
        justify-content: center;
        user-select: none;
        position: relative;
        white-space: nowrap;
        vertical-align: middle;
        outline: 2px solid transparent;
        outline-offset: 2px;
        width: auto;
        line-height: 1.2;
        border-radius: 8px;
        font-weight: 600;
        transition: all 200ms ease;
        height: 40px;
        min-width: 40px;
        font-size: 0.95rem;
        padding-left: 16px;
        padding-right: 16px;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .chakra-btn-outline {
        background: transparent;
        border-color: #cbd5e1;
        color: #334155;
    }

    .chakra-btn-outline:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
        color: #1e293b;
    }

    .chakra-btn-outline:active {
        background-color: #f1f5f9;
    }

    .chakra-btn-solid {
        background-color: #059669;
        color: white;
        box-shadow: 0 2px 4px rgba(5, 150, 105, 0.15);
    }

    .chakra-btn-solid:hover {
        background-color: #047857;
        box-shadow: 0 4px 8px rgba(5, 150, 105, 0.25);
        transform: translateY(-1px);
    }

    .chakra-btn-solid:active {
        background-color: #065f46;
        transform: translateY(0);
    }

    .chakra-desc-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 8px;
    }

    .chakra-desc-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        background-color: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 10px;
        transition: background-color 0.2s ease;
    }

    .chakra-desc-item:hover {
        background-color: #f1f5f9;
    }

    .chakra-desc-icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background-color: rgba(5, 150, 105, 0.08);
        color: #059669;
        font-size: 1rem;
    }

    .chakra-desc-content {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .chakra-desc-label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 2px;
    }

    .chakra-desc-value {
        font-size: 0.9rem;
        color: #0f172a;
        font-weight: 600;
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

        <form action="<?= $accion ?>" method="post">

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

            <!-- Apellido -->
            <div class="form-group">
                <label class="form-label">Apellido</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-signature input-icon"></i>
                    <input 
                        type="text" 
                        name="apellido_usuario" 
                        class="form-input" 
                        placeholder="ej. Pérez"
                        value="<?= old('apellido_usuario', $usuario['apellido_usuario'] ?? '') ?>"
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

<!-- Modal de Confirmación de Registro (Estilo Chakra UI) -->
<div class="chakra-modal-portal" id="confirmModal">
  <div class="chakra-modal-overlay" onclick="closeModal()"></div>
  <div class="chakra-modal-container">
    <div class="chakra-modal-content">
      <header class="chakra-modal-header">
        <h2 class="chakra-modal-title">Confirmar Registro</h2>
        <button class="chakra-modal-close-btn" type="button" onclick="closeModal()" aria-label="Cerrar modal">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </header>
      <div class="chakra-modal-body">
        <p class="chakra-modal-desc">Por favor, revisa que tus datos sean correctos antes de crear tu cuenta:</p>
        
        <div class="chakra-desc-list">
          <div class="chakra-desc-item">
            <div class="chakra-desc-icon-wrapper">
              <i class="fa-solid fa-user-tag"></i>
            </div>
            <div class="chakra-desc-content">
              <span class="chakra-desc-label">Nombre de Usuario</span>
              <span id="modal_nombre_usuario" class="chakra-desc-value"></span>
            </div>
          </div>

          <div class="chakra-desc-item">
            <div class="chakra-desc-icon-wrapper">
              <i class="fa-solid fa-signature"></i>
            </div>
            <div class="chakra-desc-content">
              <span class="chakra-desc-label">Apellido</span>
              <span id="modal_apellido_usuario" class="chakra-desc-value"></span>
            </div>
          </div>

          <div class="chakra-desc-item">
            <div class="chakra-desc-icon-wrapper">
              <i class="fa-solid fa-map-location-dot"></i>
            </div>
            <div class="chakra-desc-content">
              <span class="chakra-desc-label">Dirección</span>
              <span id="modal_direccion" class="chakra-desc-value"></span>
            </div>
          </div>

          <div class="chakra-desc-item">
            <div class="chakra-desc-icon-wrapper">
              <i class="fa-solid fa-phone"></i>
            </div>
            <div class="chakra-desc-content">
              <span class="chakra-desc-label">Teléfono</span>
              <span id="modal_telefono" class="chakra-desc-value"></span>
            </div>
          </div>
        </div>
      </div>
      <footer class="chakra-modal-footer">
        <button class="chakra-btn chakra-btn-outline" type="button" onclick="closeModal()">Corregir</button>
        <button class="chakra-btn chakra-btn-solid" type="button" onclick="submitForm()">Registrarme</button>
      </footer>
    </div>
  </div>
</div>

<?php echo view('layout/footer'); ?>

<!-- JAVASCRIPT para el control del formulario -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const formulario = document.querySelector('form');

    const nombreUsuario = document.querySelector('input[name="nombre_usuario"]');
    const claveUsuario = document.querySelector('input[name="clave_usuario"]');
    const apellidoUsuario = document.querySelector('input[name="apellido_usuario"]');
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
        // Apellido
        // =========================
        if (apellidoUsuario.value.trim() === '') {
            errores.push('El apellido es obligatorio.');
            marcarError(apellidoUsuario);
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
        // Mostrar errores o abrir modal
        // =========================
        if (errores.length > 0) {
            e.preventDefault();
            mostrarErrores(errores);
        } else {
            <?php if (!isset($usuario)): ?>
                e.preventDefault();
                document.getElementById('modal_nombre_usuario').textContent = nombreUsuario.value;
                document.getElementById('modal_apellido_usuario').textContent = apellidoUsuario.value;
                document.getElementById('modal_direccion').textContent = direccion.value || 'No especificada';
                document.getElementById('modal_telefono').textContent = telefono.value || 'No especificado';
                openModal();
            <?php endif; ?>
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

    // ====================================
    // Funciones del Modal
    // ====================================
    window.openModal = function() {
        document.getElementById('confirmModal').classList.add('is-active');
    };

    window.closeModal = function() {
        document.getElementById('confirmModal').classList.remove('is-active');
    };

    window.submitForm = function() {
        formulario.submit();
    };

});
</script>