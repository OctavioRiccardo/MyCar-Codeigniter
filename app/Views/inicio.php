<?php echo view('layout/header'); ?>

<style>

    .section-vehiculos{
        padding: 40px 20px;
    }

    .titulo{
        margin-bottom: 30px;
        color: #1f2937;
        font-weight: bold;
    }

    .vehiculo-card{
        height: 100%;
        border-radius: 12px;
        transition: 0.3s;
    }

    .vehiculo-card:hover{
        transform: translateY(-5px);
    }

    .vehiculo-imagen{
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .vehiculo-placeholder{
        width: 100%;
        height: 220px;

        display: flex;
        align-items: center;
        justify-content: center;

        background-color: #e5e7eb;
        color: #6b7280;

        font-size: 18px;
        font-weight: bold;

        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .tipo-badge{
        margin-bottom: 12px;
    }

    .precio{
        font-size: 1.3rem;
        font-weight: bold;
        color: #16a34a;
    }

    .detalle{
        margin-bottom: 8px;
    }

</style>

<section class="section section-vehiculos">

    <div class="container">

        <h1 class="title titulo">
            Vehículos Disponibles
        </h1>

        <div class="columns is-multiline">

            <?php foreach($vehiculos as $vehiculo): ?>

                <div class="column is-12-mobile is-6-tablet is-4-desktop">

                    <div class="card vehiculo-card">

                        <!-- IMAGEN -->

                        <?php if(!empty($vehiculo['imagen'])): ?>

                            <div class="card-image">

                                <figure class="image">

                                    <img 
                                        src="<?= base_url($vehiculo['imagen']) ?>"
                                        alt="Vehículo"
                                        class="vehiculo-imagen"
                                    >

                                </figure>

                            </div>

                        <?php else: ?>

                            <div class="vehiculo-placeholder">
                                Sin Imagen
                            </div>

                        <?php endif; ?>

                        <!-- CONTENIDO -->

                        <div class="card-content">

                            <span class="tag is-dark tipo-badge">
                                <?= ucfirst($vehiculo['tipo_vehiculo']); ?>
                            </span>

                            <p class="title is-4">
                                <?= $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?>
                            </p>

                            <div class="content">

                                <p class="detalle">
                                    <strong>Año:</strong>
                                    <?= $vehiculo['anio']; ?>
                                </p>

                                <p class="detalle">
                                    <strong>Plazas:</strong>
                                    <?= $vehiculo['numero_plazas']; ?>
                                </p>

                                <p class="detalle">
                                    <strong>Motor:</strong>
                                    <?= $vehiculo['motor']; ?>
                                </p>

                                <p class="detalle">
                                    <strong>Kilometraje:</strong>
                                    <?= number_format($vehiculo['kilometraje'], 0, ',', '.'); ?> km
                                </p>

                                <p class="precio">
                                    $<?= number_format($vehiculo['precio_alquiler_dia'], 0, ',', '.'); ?> / día
                                </p>

                                <br>

                                <?php if($vehiculo['disponibilidad'] == 'disponible'): ?>

                                    <span class="tag is-success is-medium">
                                        Disponible
                                    </span>

                                <?php else: ?>

                                    <span class="tag is-danger is-medium">
                                        No Disponible
                                    </span>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>