<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">



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