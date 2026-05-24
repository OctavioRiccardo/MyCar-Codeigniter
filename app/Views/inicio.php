<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Estilos inspirados en los Tokens de Diseño de Chakra UI con paleta Esmeralda */
    .section-vehiculos {
        padding: 40px 20px;
        background-color: #f9fafb; /* gray.50 de Chakra */
    }

    .titulo {
        margin-bottom: 30px;
        color: #064e3b; /* emerald.900 para un título armónico */
        font-weight: 700;
        font-family: system-ui, -apple-system, sans-serif;
    }

    /* Contenedor de la Tarjeta (Chakra Box/Card) */
    .vehiculo-card {
        background: #ffffff;
        border: 1px solid #e2e8f0; 
        border-radius: 16px; 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        overflow: hidden;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        font-family: system-ui, -apple-system, sans-serif;
    }

    .vehiculo-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 15px -3px rgba(4, 120, 87, 0.15); /* Sombra sutil con tono esmeralda */
    }

    /* Zona Superior Grisácea (Donde va el auto) */
    .card-top-section {
        background-color: #f8f9fa;
        padding: 24px;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 180px;
    }

    /* Botón Flotante de Notificación (Chakra IconButton) */
    .bell-button {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0f172a;
        cursor: pointer;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.2s;
    }

    .bell-button:hover {
        color: #059669; /* emerald.600 */
        border-color: #a7f3d0; /* emerald.200 */
        background-color: #ecfdf5; /* emerald.50 */
    }

    .vehiculo-imagen {
        max-width: 90%;
        height: auto;
        object-fit: contain;
    }

    /* Badge o Logo del Proveedor ajustado a Verde Esmeralda */
    .provider-logo {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: #047857; /* emerald.700 */
        color: white;
        font-weight: 900;
        padding: 4px 12px;
        border-radius: 4px;
        font-size: 0.85rem;
        letter-spacing: -0.5px;
    }

    /* Cuerpo de la Tarjeta (Chakra CardBody) */
    .card-bottom-section {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    /* Textos principales */
    .vehiculo-nombre {
        font-size: 1.25rem; 
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .vehiculo-subtitulo {
        color: #64748b; 
        font-size: 0.95rem;
        margin-bottom: 16px;
    }

    /* Fila de Especificaciones (Chakra Flex/HStack) */
    .specs-group {
        display: flex;
        gap: 16px;
        margin-bottom: 20px;
        color: #334155;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .spec-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .spec-item i {
        color: #059669; /* Iconos en verde esmeralda discreto */
        font-size: 1rem;
    }

    /* Fila de Precio y Acción */
    .action-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: auto; 
    }

    .precio-container {
        font-size: 1.35rem;
        font-weight: 700;
        color: #047857; /* Precio destacado en Verde Esmeralda */
    }

    .precio-periodo {
        font-size: 0.9rem;
        color: #64748b;
        font-weight: 400;
    }

    /* Botón de Acción con Gradiente Verde Esmeralda */
    .btn-view-deal {
        background: linear-gradient(135deg, #059669 0%, #064e3b 100%);
        color: white;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.3);
        transition: all 0.2s ease;
    }

    .btn-view-deal:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 14px rgba(5, 150, 105, 0.4);
    }
    
    /* Badge de disponibilidad */
    .status-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: 0.75rem;
        font-weight: bold;
        padding: 4px 8px;
        border-radius: 20px;
    }
</style>

<section class="section section-vehiculos">
    <div class="container">

        <h1 class="title titulo">Vehículos Disponibles</h1>

        <div class="columns is-multiline">
            <?php foreach($vehiculos as $vehiculo): ?>
                
                <div class="column is-12-mobile is-6-tablet is-4-desktop">
                    <div class="vehiculo-card">
                        
                        <div class="card-top-section">

                            <?php if($vehiculo['disponibilidad'] == 'disponible'): ?>
                                <span class="tag is-success status-badge">Disponible</span>
                            <?php else: ?>
                                <span class="tag is-danger status-badge">No Disponible</span>
                            <?php endif; ?>

                            <?php if(!empty($vehiculo['imagen'])): ?>
                                <img src="<?= base_url($vehiculo['imagen']) ?>" alt="<?= $vehiculo['marca']; ?>" class="vehiculo-imagen">
                            <?php else: ?>
                                <div class="vehiculo-imagen" style="height:100px; display:flex; align-items:center; color:#cbd5e1;">
                                    <i class="fa-solid fa-car fa-3x"></i>
                                </div>
                            <?php endif; ?>

                        </div>

                        <div class="card-bottom-section">
                            <h2 class="vehiculo-nombre">
                                <?= $vehiculo['marca'] . ' ' . $vehiculo['modelo']; ?>
                            </h2>
                            <p class="vehiculo-subtitulo">
                                Tipo de Vehiculo: <?= ucfirst($vehiculo['tipo_vehiculo']); ?>
                            </p>

                            <div class="specs-group">
                                <div class="spec-item" title="Pasajeros">
                                    <i class="fa-solid fa-user"></i> 
                                    <?= $vehiculo['numero_plazas']; ?>
                                </div>
                                <div class="spec-item" title="Kilometraje">
                                    <i class="fa-solid fa-gauge-high"></i>
                                    <?= $vehiculo['kilometraje']; ?> KM
                                </div>
                            </div>

                            <div class="action-row">
                                <div class="precio-container">
                                    $<?= number_format($vehiculo['precio_alquiler_dia'], 0, ',', '.'); ?>
                                    <span class="precio-periodo">/por día</span>
                                </div>
                                
                                <button class="btn-view-deal">
                                    Ver Detalle
                                </button>
                            </div>

                        </div>

                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php echo view('layout/footer'); ?>