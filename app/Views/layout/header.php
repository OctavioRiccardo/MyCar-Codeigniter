<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyCar - Alquiler de Vehículos</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background-color: #f4f4f4;
        }

        header{
            width: 100%;
            background-color: #1f2937;
            color: white;

            display: flex;
            justify-content: space-between;
            align-items: center;

            padding: 20px 40px;
        }

        .logo{
            font-size: 24px;
            font-weight: bold;
        }

        .header-buttons{
            display: flex;
            gap: 15px;
        }

        .header-buttons a{
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
            transition: 0.3s;
            font-weight: bold;
        }

        .login-btn{
            background-color: #2563eb;
            color: white;
        }

        .register-btn{
            background-color: #10b981;
            color: white;
        }

        .header-buttons a:hover{
            opacity: 0.85;
        }

    </style>
</head>

<body>

    <header>

        <div class="logo">
            MyCar - Alquiler de Vehículos
        </div>

        <div class="header-buttons">

            <a href="#" class="login-btn">
                Iniciar Sesión
            </a>

            <a href="#" class="register-btn">
                Registrarse
            </a>

        </div>

    </header>