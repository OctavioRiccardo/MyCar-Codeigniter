<?php echo view('layout/header'); ?>

<section class="section section-vehiculos">

    <div class="container">

        <h1 class="title titulo">
            Mis Alquileres
        </h1>

        <?php if(empty($alquileres)): ?>

            <div class="notification is-warning has-text-centered">

                No tenés alquileres realizados.

            </div>

        <?php else: ?>

            <div class="columns is-multiline">

                <?php foreach($alquileres as $alquiler): ?>

                    <div class="column is-12-mobile is-6-tablet is-4-desktop">

                        <div class="vehiculo-card">

                            <div class="card-top-section">

                                <?php if($alquiler['estado'] == 'reserva'): ?>
                                    <span class="tag is-warning status-badge">
                                        Reservado
                                    </span>
                                <?php elseif($alquiler['estado'] == 'alquiler'): ?>
                                    <span class="tag is-info status-badge">
                                        Alquilado
                                    </span>
                                <?php elseif($alquiler['estado'] == 'devuelto'): ?>
                                    <span class="tag is-success status-badge">
                                        Devuelto
                                    </span>
                                <?php else: ?>
                                    <span class="tag is-danger status-badge">
                                        <?= esc(ucfirst($alquiler['estado'])) ?>
                                    </span>
                                <?php endif; ?>

                                <?php if(!empty($alquiler['imagen'])): ?>

                                    <img
                                        src="<?= base_url($alquiler['imagen']) ?>"
                                        alt="<?= $alquiler['marca']; ?>"
                                        class="vehiculo-imagen">

                                <?php else: ?>

                                    <div
                                        class="vehiculo-imagen"
                                        style="
                                            height:100px;
                                            display:flex;
                                            align-items:center;
                                            justify-content:center;
                                            color:#cbd5e1;
                                        ">

                                        <i class="fa-solid fa-car fa-3x"></i>

                                    </div>

                                <?php endif; ?>

                            </div>

                            <div class="card-bottom-section">

                                <h2 class="vehiculo-nombre">

                                    <?= $alquiler['marca'] . ' ' . $alquiler['modelo']; ?>

                                </h2>

                                <p class="vehiculo-subtitulo">

                                    Tipo de Vehículo:
                                    <?= ucfirst($alquiler['tipo_vehiculo']); ?>

                                </p>

                                <div class="specs-group">

                                    <div
                                        class="spec-item"
                                        title="Fecha Desde">

                                        <i class="fa-solid fa-calendar-days"></i>

                                        <?= date(
                                            'd/m/Y',
                                            strtotime($alquiler['fecha_desde'])
                                        ); ?>

                                    </div>

                                    <div
                                        class="spec-item"
                                        title="Fecha Hasta">

                                        <i class="fa-solid fa-calendar-check"></i>

                                        <?= date(
                                            'd/m/Y',
                                            strtotime($alquiler['fecha_hasta'])
                                        ); ?>

                                    </div>

                                </div>

                                <div class="specs-group">

                                    <div
                                        class="spec-item"
                                        title="Precio por Día">

                                        <i class="fa-solid fa-dollar-sign"></i>

                                        $<?= number_format(
                                            $alquiler['precio_alquiler_dia'],
                                            0,
                                            ',',
                                            '.'
                                        ); ?>/día

                                    </div>

                                </div>

                                <div class="action-row">

                                    <a
                                        href="<?= site_url(
                                            'mis-alquileres/resumen/' .
                                            $alquiler['id_alquiler']
                                        ) ?>"
                                        class="btn-view-deal"
                                        style="
                                            width:100%;
                                            text-decoration:none;
                                            text-align:center;
                                            display:inline-flex;
                                            align-items:center;
                                            justify-content:center;
                                        ">

                                        Ver Resumen

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

</section>

<?php echo view('layout/footer'); ?>