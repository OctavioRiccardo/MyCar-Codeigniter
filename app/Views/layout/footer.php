    <footer class="footer footer-mycar">
        <div class="content has-text-centered">
            <p class="footer-authors">
                <i class="fa-solid fa-code"></i>
                Desarrollado por: <strong>Facundo Homola</strong> & <strong>Octavio Riccardo</strong>
            </p>
            <p class="footer-copyright">
                &copy; <?= date('Y'); ?> MyCar App. Todos los derechos reservados.
            </p>
        </div>
    </footer>

    <!-- Chakra UI Toast Implementation -->
    <script>
        class ChakraToast {
            static container = null;

            static init() {
                if (!document.getElementById('chakra-toast-container')) {
                    const container = document.createElement('div');
                    container.id = 'chakra-toast-container';
                    document.body.appendChild(container);
                    this.container = container;
                } else {
                    this.container = document.getElementById('chakra-toast-container');
                }
            }

            static show({ title, description = '', status = 'info', duration = 5000, isClosable = true }) {
                this.init();

                const toast = document.createElement('div');
                toast.className = `chakra-toast chakra-toast-${status}`;
                
                let iconClass = '';
                switch(status) {
                    case 'success':
                        iconClass = 'fa-solid fa-circle-check';
                        break;
                    case 'warning':
                        iconClass = 'fa-solid fa-triangle-exclamation';
                        break;
                    case 'error':
                        iconClass = 'fa-solid fa-circle-xmark';
                        break;
                    case 'info':
                    default:
                        iconClass = 'fa-solid fa-circle-info';
                        break;
                }

                toast.innerHTML = `
                    <span class="chakra-toast-icon"><i class="${iconClass}"></i></span>
                    <div class="chakra-toast-content">
                        <div class="chakra-toast-title">${title}</div>
                        ${description ? `<div class="chakra-toast-desc">${description}</div>` : ''}
                    </div>
                    ${isClosable ? `<button class="chakra-toast-close" aria-label="Close toast"><i class="fa-solid fa-xmark"></i></button>` : ''}
                `;

                if (isClosable) {
                    toast.querySelector('.chakra-toast-close').addEventListener('click', () => {
                        this.dismiss(toast);
                    });
                }

                this.container.appendChild(toast);

                // Trigger reflow for CSS animation
                toast.offsetHeight;
                toast.classList.add('is-visible');

                if (duration > 0) {
                    setTimeout(() => {
                        this.dismiss(toast);
                    }, duration);
                }
            }

            static dismiss(toast) {
                toast.classList.remove('is-visible');
                toast.addEventListener('transitionend', function handler(e) {
                    if (e.propertyName === 'opacity' || e.propertyName === 'transform') {
                        toast.remove();
                        toast.removeEventListener('transitionend', handler);
                    }
                });
            }
        }
    </script>

    <!-- CodeIgniter Flashdata Toast Triggers -->
    <?php if (session()->getFlashdata('toast_success')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                ChakraToast.show({
                    title: '¡Operación Exitosa!',
                    description: <?= json_encode(session()->getFlashdata('toast_success')) ?>,
                    status: 'success',
                    isClosable: true
                });
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('toast_warning')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                ChakraToast.show({
                    title: 'Atención',
                    description: <?= json_encode(session()->getFlashdata('toast_warning')) ?>,
                    status: 'warning',
                    isClosable: true
                });
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('mensaje')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                ChakraToast.show({
                    title: 'Mensaje del Sistema',
                    description: <?= json_encode(session()->getFlashdata('mensaje')) ?>,
                    status: 'success',
                    isClosable: true
                });
            });
        </script>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error_login')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                ChakraToast.show({
                    title: 'Error de Inicio de Sesión',
                    description: <?= json_encode(session()->getFlashdata('error_login')) ?>,
                    status: 'error',
                    isClosable: true
                });
            });
        </script>
    <?php endif; ?>

</body>
</html>