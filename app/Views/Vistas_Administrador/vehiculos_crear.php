<?php echo view('layout/header'); ?>

<section class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-6">
                <div class="box">
                    <h1 class="title has-text-centered">Registrar Vehículo</h1>

                    <form action="<?= site_url('vehiculos/create') ?>" method="post">
                        <div class="field">
                            <label class="label">Tipo de Vehículo</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="tipo_vehiculo" required>
                                        <option value="auto">Auto</option>
                                        <option value="moto">Moto</option>
                                        <option value="camioneta">Camioneta</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Marca</label>
                            <div class="control">
                                <input class="input" type="text" name="marca" placeholder="Toyota, Ford, etc." required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Modelo</label>
                            <div class="control">
                                <input class="input" type="text" name="modelo" placeholder="Corolla, Ranger, etc." required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Año</label>
                            <div class="control">
                                <input class="input" type="number" name="anio" min="1900" max="<?= date('Y')+1 ?>" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Número de Plazas</label>
                            <div class="control">
                                <input class="input" type="number" name="numero_plazas" min="1" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Motor</label>
                            <div class="control">
                                <input class="input" type="text" name="motor" placeholder="2.0, 150cc, etc." required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Kilometraje</label>
                            <div class="control">
                                <input class="input" type="number" step="any" name="kilometraje" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Precio por Día ($)</label>
                            <div class="control">
                                <input class="input" type="number" step="any" name="precio_alquiler_dia" required>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Imagen URL (Opcional)</label>
                            <div class="control">
                                <input class="input" type="text" name="imagen">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">Disponibilidad</label>
                            <div class="control">
                                <div class="select is-fullwidth">
                                    <select name="disponibilidad">
                                        <option value="disponible">Disponible</option>
                                        <option value="no_disponible">No Disponible</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="field is-grouped is-grouped-centered mt-5">
                            <div class="control">
                                <button type="submit" class="button is-primary">Guardar</button>
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
