<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test Base de Datos</title>
</head>
<body>

    <h1>Prueba de Conexión MySQL</h1>

    <?php if ($estado): ?>

        <h2 style="color: green;">
            <?php echo $mensaje; ?>
        </h2>

    <?php else: ?>

        <h2 style="color: red;">
            <?php echo $mensaje; ?>
        </h2>

    <?php endif; ?>

</body>
</html>