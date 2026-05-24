<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MyCar - Alquiler de Vehículos</title>

    <!-- Bulma CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">

    <style>

        body{
            background-color: #f4f4f4;
        }

        .navbar-mycar{
            background-color: #1f2937;
            padding: 10px 25px;
        }

        .navbar-mycar .navbar-item,
        .navbar-mycar .navbar-link{
            color: white;
        }

        .navbar-mycar .navbar-item:hover,
        .navbar-mycar .navbar-link:hover{
            background-color: transparent !important;
            color: #d1d5db !important;
        }

        .logo-text{
            font-size: 1.4rem;
            font-weight: bold;
            color: white !important;
        }

        .btn-login{
            background-color: #2563eb;
            color: white;
            border: none;
        }

        .btn-login:hover{
            background-color: #1d4ed8;
            color: white;
        }

        .btn-register{
            background-color: #10b981;
            color: white;
            border: none;
        }

        .btn-register:hover{
            background-color: #059669;
            color: white;
        }

    </style>
</head>

<body>

    <nav class="navbar navbar-mycar" role="navigation">

        <div class="navbar-brand">

            <a class="navbar-item logo-text" href="<?= base_url('/') ?>">
                MyCar - Alquiler de Vehículos
            </a>

        </div>

        <div class="navbar-menu is-active">

            <div class="navbar-end">

                <div class="navbar-item">

                    <div class="buttons">

                        <a href="#" class="button btn-login">
                            Iniciar Sesión
                        </a>

                        <a href="#" class="button btn-register">
                            Registrarse
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </nav>