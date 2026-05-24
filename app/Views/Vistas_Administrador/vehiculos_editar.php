<?php echo view('layout/header'); ?>

<section class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-6">
                <div class="box">
                    <h1 class="title has-text-centered">Editar Vehículo</h1>

                    <form action="<?= site_url('vehiculos/update/'.$vehiculo['id_vehiculo']) ?>" method="post">
                        <div class="field">
                            <label class="label">Tipo de Vehículo</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="tipo_vehiculo" required>
                                        <option value="auto" <?= $vehiculo['tipo_vehiculo'] == 'auto' ? 'selected' : '' ?>>Auto</option>
                                        <option value="moto" <?= $vehiculo['tipo_vehiculo'] == 'moto' ? 'selected' : '' ?>>Moto</option>
                                        <option value="camioneta" <?= $vehiculo['tipo_vehiculo'] == 'camioneta' ? 'selected' : '' ?>>Camioneta</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Marca</label>
                            <div class="control">
                                <input class="input" type="text" name="marca" value="<?= esc($vehiculo['marca']) ?>" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Modelo</label>
                            <div class="control">
                                <input class="input" type="text" name="modelo" value="<?= esc($vehiculo['modelo']) ?>" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Año</label>
                            <div class="control">
                                <input class="input" type="number" name="anio" min="1900" max="<?= date('Y')+1 ?>" value="<?= esc($vehiculo['anio']) ?>" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Número de Plazas</label>
                            <div class="control">
                                <input class="input" type="number" name="numero_plazas" min="1" value="<?= esc($vehiculo['numero_plazas']) ?>" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Motor</label>
                            <div class="control">
                                <input class="input" type="text" name="motor" value="<?= esc($vehiculo['motor']) ?>" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Kilometraje</label>
                            <div class="control">
                                <input class="input" type="number" step="any" name="kilometraje" value="<?= esc($vehiculo['kilometraje']) ?>" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Precio por Día ($)</label>
                            <div class="control">
                                <input class="input" type="number" step="any" name="precio_alquiler_dia" value="<?= esc($vehiculo['precio_alquiler_dia']) ?>" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Imagen URL (Opcional)</label>
                            <div class="control">
                                <input class="input" type="text" name="imagen" value="<?= esc($vehiculo['imagen']) ?>">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Disponibilidad</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="disponibilidad">
                                        <option value="disponible" <?= $vehiculo['disponibilidad'] == 'disponible' ? 'selected' : '' ?>>Disponible</option>
                                        <option value="no_disponible" <?= $vehiculo['disponibilidad'] == 'no_disponible' ? 'selected' : '' ?>>No Disponible</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="field is-grouped is-grouped-centered mt-5">
                            <div class="control">
                                <button type="submit" class="button is-primary">Actualizar</button>
                            </div>
                            <div class="control">
                                <a href="<?= site_url('vehiculos') ?>" class="button is-light">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php echo view('layout/footer'); ?>
