<?php echo view('layout/header'); ?>

<section class="section section-vehiculos">

    <div class="container">

        <h1 class="title titulo">

            Resumen del Alquiler

        </h1>

        <div class="columns is-centered">

            <div class="column is-12-mobile is-10-tablet is-8-desktop">

                <div class="vehiculo-card">

                    <div class="card-top-section">

                        <?php if(!empty($alquiler['imagen'])): ?>

                            <img
                                src="<?= base_url($alquiler['imagen']) ?>"
                                alt="<?= $alquiler['marca']; ?>"
                                class="vehiculo-imagen">

                        <?php else: ?>

                            <div
                                class="vehiculo-imagen"
                                style="
                                    height:200px;
                                    display:flex;
                                    align-items:center;
                                    justify-content:center;
                                    color:#cbd5e1;
                                ">

                                <i class="fa-solid fa-car fa-4x"></i>

                            </div>

                        <?php endif; ?>

                    </div>

                    <div class="card-bottom-section">

                        <h2 class="vehiculo-nombre">

                            <?= $alquiler['marca'] ?>
                            <?= $alquiler['modelo'] ?>

                        </h2>

                        <p class="vehiculo-subtitulo">

                            Tipo de Vehículo:
                            <?= ucfirst($alquiler['tipo_vehiculo']); ?>

                        </p>

                        <hr>

                        <div class="specs-group">

                            <div class="spec-item">

                                <i class="fa-solid fa-calendar-days"></i>

                                Desde:
                                <?= date(
                                    'd/m/Y',
                                    strtotime($alquiler['fecha_desde'])
                                ); ?>

                            </div>

                            <div class="spec-item">

                                <i class="fa-solid fa-calendar-check"></i>

                                Hasta:
                                <?= date(
                                    'd/m/Y',
                                    strtotime($alquiler['fecha_hasta'])
                                ); ?>

                            </div>

                        </div>

                        <div class="specs-group">

                            <div class="spec-item">

                                <i class="fa-solid fa-clock"></i>

                                <?= $alquiler['cantidad_dias']; ?> días

                            </div>

                            <div class="spec-item">

                                <i class="fa-solid fa-dollar-sign"></i>

                                $<?= number_format(
                                    $alquiler['precio_alquiler_dia'],
                                    0,
                                    ',',
                                    '.'
                                ); ?>/día

                            </div>

                        </div>

                        <div class="specs-group">

                            <div class="spec-item">

                                <i class="fa-solid fa-credit-card"></i>

                                <?= ucfirst(esc($alquiler['metodopago'] ?? 'efectivo')); ?>

                            </div>

                            <div class="spec-item">

                                <i class="fa-solid fa-circle-check"></i>

                                <?= ucfirst($alquiler['estado']); ?>

                            </div>

                        </div>

                        <hr>

                        <div
                            class="action-row"
                            style="margin-top:20px;">

                            <div class="precio-container">

                                $<?= number_format(
                                    $precioTotal,
                                    0,
                                    ',',
                                    '.'
                                ); ?>

                                <span class="precio-periodo">

                                    Total del alquiler

                                </span>

                            </div>

                            <a
                                href="<?= site_url('mis-alquileres') ?>"
                                class="btn-view-deal"
                                style="
                                    text-decoration:none;
                                    display:inline-flex;
                                    align-items:center;
                                    justify-content:center;
                                ">

                                Volver

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<?php echo view('layout/footer'); ?>