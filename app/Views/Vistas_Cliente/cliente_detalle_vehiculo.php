<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

    .detalle-section {
        padding: 50px 20px;
        background: #f9fafb;
        min-height: 100vh;
    }

    .detalle-container {
        max-width: 1200px;
        margin: auto;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .detalle-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    .detalle-imagen {
        background: #f8fafc;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .detalle-imagen img {
        width: 100%;
        max-width: 500px;
        object-fit: contain;
    }

    .detalle-info {
        padding: 40px;
    }

    .vehiculo-tipo {
        display: inline-block;
        background: #ecfdf5;
        color: #047857;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .vehiculo-titulo {
        font-size: 2.5rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 10px;
    }

    .vehiculo-anio {
        color: #64748b;
        font-size: 1.1rem;
        margin-bottom: 25px;
    }

    .specs-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px;
        margin-bottom: 30px;
    }

    .spec-card {
        background: #f8fafc;
        border-radius: 12px;
        padding: 18px;
    }

    .spec-card i {
        color: #059669;
        font-size: 1.3rem;
        margin-bottom: 10px;
    }

    .spec-title {
        color: #64748b;
        font-size: 0.9rem;
    }

    .spec-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
    }

    .precio-box {
        background: linear-gradient(135deg, #059669 0%, #064e3b 100%);
        color: white;
        border-radius: 16px;
        padding: 25px;
        margin-top: 20px;
    }

    .precio-label {
        font-size: 1rem;
        opacity: 0.9;
    }

    .precio-valor {
        font-size: 2.5rem;
        font-weight: 700;
    }

    .precio-periodo {
        font-size: 1rem;
    }

    .estado-disponibilidad {
        margin-top: 25px;
    }

    .btn-volver {
        display: inline-block;
        margin-top: 30px;
        background: #e2e8f0;
        color: #0f172a;
        padding: 12px 20px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-volver:hover {
        background: #cbd5e1;
    }

    @media(max-width: 768px) {

        .detalle-grid {
            grid-template-columns: 1fr;
        }

        .vehiculo-titulo {
            font-size: 2rem;
        }

        .specs-grid {
            grid-template-columns: 1fr;
        }
    }

</style>

<section class="detalle-section">

    <div class="detalle-container">

        <div class="detalle-grid">

            <div class="detalle-imagen">

                <?php if(!empty($vehiculo['imagen'])): ?>

                    <img 
                        src="<?= base_url($vehiculo['imagen']) ?>" 
                        alt="<?= $vehiculo['marca']; ?>"
                    >

                <?php else: ?>

                    <i class="fa-solid fa-car fa-6x" style="color:#cbd5e1;"></i>

                <?php endif; ?>

            </div>

            <div class="detalle-info">

                <span class="vehiculo-tipo">
                    <?= ucfirst($vehiculo['tipo_vehiculo']); ?>
                </span>

                <h1 class="vehiculo-titulo">
                    <?= $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?>
                </h1>

                <p class="vehiculo-anio">
                    Año <?= $vehiculo['anio']; ?>
                </p>

                <div class="specs-grid">

                    <div class="spec-card">
                        <i class="fa-solid fa-user-group"></i>

                        <div class="spec-title">
                            Plazas
                        </div>

                        <div class="spec-value">
                            <?= $vehiculo['numero_plazas']; ?>
                        </div>
                    </div>

                    <div class="spec-card">
                        <i class="fa-solid fa-gauge-high"></i>

                        <div class="spec-title">
                            Kilometraje
                        </div>

                        <div class="spec-value">
                            <?= number_format($vehiculo['kilometraje'], 0, ',', '.'); ?> KM
                        </div>
                    </div>

                    <div class="spec-card">
                        <i class="fa-solid fa-engine"></i>

                        <div class="spec-title">
                            Motor
                        </div>

                        <div class="spec-value">
                            <?= $vehiculo['motor']; ?>
                        </div>
                    </div>

                    <div class="spec-card">
                        <i class="fa-solid fa-circle-check"></i>

                        <div class="spec-title">
                            Estado
                        </div>

                        <div class="spec-value">

                            <?php if($vehiculo['disponibilidad'] == 'disponible'): ?>
                                Disponible
                            <?php else: ?>
                                No Disponible
                            <?php endif; ?>

                        </div>
                    </div>

                </div>

                <div class="precio-box">

                    <div class="precio-label">
                        Precio de alquiler
                    </div>

                    <div class="precio-valor">
                        $<?= number_format($vehiculo['precio_alquiler_dia'], 0, ',', '.'); ?>
                    </div>

                    <div class="precio-periodo">
                        por día
                    </div>

                </div>

                <a href="<?= base_url('/'); ?>" class="btn-volver">
                    <i class="fa-solid fa-arrow-left"></i>
                    Volver
                </a>

            </div>

        </div>

    </div>

</section>

<?php echo view('layout/footer'); ?>