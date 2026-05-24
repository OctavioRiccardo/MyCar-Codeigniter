<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $titulo ?></title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css"
    >
</head>

<body>

<section class="section">

    <div class="container">

        <div class="columns is-centered">

            <div class="column is-6">

                <div class="box">

                    <h1 class="title has-text-centered">
                        <?= $titulo ?>
                    </h1>

                    <?php if(session()->getFlashdata('errors')): ?>

                        <div class="notification is-danger">

                            <ul>

                                <?php foreach(session()->getFlashdata('errors') as $error): ?>

                                    <li><?= $error ?></li>

                                <?php endforeach; ?>

                            </ul>

                        </div>

                    <?php endif; ?>

                    <form action="<?= $accion ?>" method="post">

                        <div class="field">

                            <label class="label">
                                Nombre de Usuario
                            </label>

                            <div class="control">

                                <input
                                    class="input"
                                    type="text"
                                    name="nombre_usuario"
                                    value="<?= old('nombre_usuario', $usuario['nombre_usuario'] ?? '') ?>"
                                >

                            </div>

                        </div>

                        <div class="field">

                            <label class="label">
                                Contraseña
                            </label>

                            <div class="control">

                                <input
                                    class="input"
                                    type="password"
                                    name="clave_usuario"
                                >

                            </div>

                        </div>

                        <div class="field">

                            <label class="label">
                                Nombre y Apellido
                            </label>

                            <div class="control">

                                <input
                                    class="input"
                                    type="text"
                                    name="nombre_apellido"
                                    value="<?= old('nombre_apellido', $usuario['nombre_apellido'] ?? '') ?>"
                                >

                            </div>

                        </div>

                        <div class="field">

                            <label class="label">
                                Dirección
                            </label>

                            <div class="control">

                                <input
                                    class="input"
                                    type="text"
                                    name="direccion"
                                    value="<?= old('direccion', $usuario['direccion'] ?? '') ?>"
                                >

                            </div>

                        </div>

                        <div class="field">

                            <label class="label">
                                Teléfono
                            </label>

                            <div class="control">

                                <input
                                    class="input"
                                    type="text"
                                    name="telefono"
                                    value="<?= old('telefono', $usuario['telefono'] ?? '') ?>"
                                >

                            </div>

                        </div>

                        <div class="field is-grouped is-grouped-centered mt-5">

                            <div class="control">

                                <button
                                    type="submit"
                                    class="button is-primary"
                                >
                                    Guardar
                                </button>

                            </div>

                            <div class="control">

                                <a
                                    href="<?= site_url('usuarios') ?>"
                                    class="button is-light"
                                >
                                    Volver
                                </a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</section>

</body>

</html>