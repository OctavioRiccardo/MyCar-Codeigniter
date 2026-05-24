<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MyCar - Alquiler de Vehículos</title>

    <!-- Bulma -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background-color: #f9fafb;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-family: system-ui, -apple-system, sans-serif;
        }

        /* Navbar Principal */
        .navbar-mycar {
            background-color: #0f172a;
            padding: 8px 30px;
            min-height: 105px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .navbar-mycar .navbar-item,
        .navbar-mycar .navbar-link {
            color: #f8fafc;
        }

        .navbar-mycar .navbar-item:hover,
        .navbar-mycar .navbar-link:hover {
            background-color: transparent !important;
            color: #5eead4 !important;
        }

        /* Contenedor Logo */
        .logo-container {
            display: flex;
            align-items: center;
            padding: 0 !important;
        }

        /* Logo */
        .logo-img {
            height: 95px !important;
            max-height: 95px !important;
            width: auto;
            max-width: 360px;
            object-fit: contain;
            display: block;
        }

        /* Botón Login */
        .btn-login {
            background-color: #334155;
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background-color: #475569;
            color: white;
        }

        /* Botón Registro */
        .btn-register {
            background: linear-gradient(135deg, #059669 0%, #064e3b 100%);
            color: white;
            border: none;
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(5, 150, 105, 0.25);
            transition: all 0.2s ease;
        }

        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 12px rgba(5, 150, 105, 0.35);
            color: white;
        }

        /* Responsive */
        @media screen and (max-width: 768px) {

            .navbar-mycar {
                padding: 8px 15px;
                min-height: 85px;
            }

            .logo-img {
                height: 75px !important;
                max-height: 75px !important;
                max-width: 280px;
            }

            .buttons {
                display: flex;
                gap: 8px;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-mycar"
        role="navigation"
        aria-label="main navigation">

        <!-- Logo -->
        <div class="navbar-brand">

            <a class="navbar-item logo-container"
                href="<?= base_url('/') ?>">

                <img
                    src="<?= base_url('assets/img/logomycar.png') ?>"
                    alt="Logo MyCar"
                    class="logo-img">

            </a>

        </div>

        <!-- Botones -->
        <div class="navbar-menu is-active">

            <div class="navbar-end">

                <div class="navbar-item">

                    <div class="buttons">

                        <a href="#"
                            class="button btn-login">

                            <span class="icon">
                                <i class="fa-solid fa-user"></i>
                            </span>

                            <span>Iniciar Sesión</span>

                        </a>

                        <a href="<?= site_url('usuarios/crear') ?>"
                            class="button btn-register">

                            <span class="icon">
                                <i class="fa-solid fa-user-plus"></i>
                            </span>

                            <span>Registrarse</span>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </nav>