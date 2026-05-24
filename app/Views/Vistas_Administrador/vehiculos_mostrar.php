<?php echo view('layout/header'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Estilos inspirados en los Tokens de Diseño de Chakra UI (Paleta Esmeralda) */
    .show-section {
        padding: 40px 20px;
        background-color: #f9fafb; /* gray.50 */
        min-height: 80vh;
        font-family: system-ui, -apple-system, sans-serif;
    }

    .show-card {
        background: #ffffff;
        border: 1px solid #e2e8f0; /* gray.200 */
        border-radius: 16px; /* rounded-2xl */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); /* shadow-xl */
        padding: 40px;
        max-width: 800px;
        margin: 0 auto;
    }

    .show-title {
        font-size: 2rem;
        font-weight: 800;
        color: #064e3b; /* emerald.900 */
        text-align: center;
        margin-bottom: 30px;
    }

    .show-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        align-items: center;
    }

    @media screen and (max-width: 600px) {
        .show-grid {
            grid-template-columns: 1fr;
        }
    }

    .image-container {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8fafc;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e2e8f0;
        min-height: 250px;
    }

    .vehicle-img {
        max-width: 100%;
        max-height: 250px;
        object-fit: contain;
    }

    /* Ficha Técnica */
    .info-table {
        width: 100%;
        border-collapse: collapse;
    }

    .info-table th {
        font-weight: 700;
        color: #475569;
        text-align: left;
        padding: 10px 0;
        border-bottom: 1px solid #edf2f7;
        width: 40%;
    }

    .info-table td {
        color: #0f172a;
        padding: 10px 0;
        border-bottom: 1px solid #edf2f7;
    }

    /* Badges */
    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-badge.available {
        background-color: #ecfdf5;
        color: #059669;
    }

    .status-badge.unavailable {
        background-color: #fef2f2;
        color: #dc2626;
    }

    /* Acciones */
    .show-actions {
        display: flex;
        justify-content: center;
        gap: 16px;
        margin-top: 40px;
        border-top: 1px solid #e2e8f0;
        padding-top: 30px;
    }

    .btn-chakra-primary {
        background: linear-gradient(135deg, #059669 0%, #064e3b 100%);
        color: white;
        font-weight: 700;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.3);
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-chakra-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 14px rgba(5, 150, 105, 0.4);
        color: white;
    }

    .btn-chakra-light {
        background-color: #edf2f7;
        color: #4a5568;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-chakra-light:hover {
        background-color: #e2e8f0;
        color: #4a5568;
    }
</style>

<div class="show-section">
    <div class="container">
        
        <div class="show-card">
            
            <h1 class="show-title"><?= esc($vehiculo['marca']) . ' ' . esc($vehiculo['modelo']) ?></h1>
            
            <div class="show-grid">
                
                <!-- Imagen -->
                <div class="image-container">
                    <?php if(!empty($vehiculo['imagen'])): ?>
                        <img src="<?= base_url($vehiculo['imagen']) ?>" alt="<?= esc($vehiculo['marca']) ?>" class="vehicle-img">
                    <?php else: ?>
                        <div style="text-align: center; color: #94a3b8;">
                            <i class="fa-solid fa-car fa-5x"></i>
                            <p style="margin-top: 10px; font-weight: 600;">Sin Imagen Cargada</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Ficha Técnica -->
                <div>
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <th>Tipo de Vehículo:</th>
                                <td><?= ucfirst(esc($vehiculo['tipo_vehiculo'])) ?></td>
                            </tr>
                            <tr>
                                <th>Año de Compra:</th>
                                <td><?= esc($vehiculo['anio']) ?></td>
                            </tr>
                            <tr>
                                <th>Plazas disponibles:</th>
                                <td><?= esc($vehiculo['numero_plazas']) ?> Personas</td>
                            </tr>
                            <tr>
                                <th>Motorización:</th>
                                <td><?= esc($vehiculo['motor']) ?></td>
                            </tr>
                            <tr>
                                <th>Kilometraje:</th>
                                <td><?= number_format($vehiculo['kilometraje'], 0, ',', '.') ?> KM</td>
                            </tr>
                            <tr>
                                <th>Precio Alquiler/Día:</th>
                                <td><strong>$<?= number_format($vehiculo['precio_alquiler_dia'], 0, ',', '.') ?></strong></td>
                            </tr>
                            <tr>
                                <th>Disponibilidad:</th>
                                <td>
                                    <span class="status-badge <?= $vehiculo['disponibilidad'] == 'disponible' ? 'available' : 'unavailable' ?>">
                                        <?= ucfirst(esc($vehiculo['disponibilidad'])) ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="show-actions">
                <a href="<?= site_url('vehiculos') ?>" class="btn-chakra-light">Volver al Listado</a>
                <a href="<?= site_url('vehiculos/edit/'.$vehiculo['id_vehiculo']) ?>" class="btn-chakra-primary">
                    <i class="fa-solid fa-pen-to-square"></i> Editar Vehículo
                </a>
            </div>

        </div>

    </div>
</div>

<?php echo view('layout/footer'); ?>
