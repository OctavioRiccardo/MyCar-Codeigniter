<style>

    .container{
        width: 90%;
        margin: 40px auto;
    }

    .titulo{
        margin-bottom: 25px;
        color: #222;
    }

    .cards{
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
    }

    .card{
        background-color: white;
        border-radius: 10px;
        padding: 20px;

        box-shadow: 0 2px 8px rgba(0,0,0,0.1);

        transition: 0.3s;
    }

    .card:hover{
        transform: translateY(-5px);
    }

    .tipo{
        display: inline-block;
        background-color: #e5e7eb;
        color: #111827;

        padding: 5px 10px;
        border-radius: 5px;

        margin-bottom: 12px;
        font-size: 14px;
        font-weight: bold;
    }

    .modelo{
        font-size: 22px;
        margin-bottom: 10px;
        color: #111827;
    }

    .detalle{
        margin-bottom: 8px;
        color: #444;
    }

    .precio{
        margin-top: 15px;
        font-size: 20px;
        font-weight: bold;
        color: #16a34a;
    }

    .estado{
        margin-top: 10px;
        font-weight: bold;
    }

    .disponible{
        color: green;
    }

    .no-disponible{
        color: red;
    }

</style>

<?php echo view('layout/header'); ?>

<div class="container">

    <h1 class="titulo">
        Vehículos Disponibles
    </h1>

    <div class="cards">

        <?php foreach($vehiculos as $vehiculo): ?>

            <div class="card">

                <div class="tipo">
                    <?php echo ucfirst($vehiculo['tipo_vehiculo']); ?>
                </div>

                <div class="modelo">
                    <?php echo $vehiculo['marca'] . " " . $vehiculo['modelo']; ?>
                </div>

                <div class="detalle">
                    <strong>Año:</strong>
                    <?php echo $vehiculo['anio']; ?>
                </div>

                <div class="detalle">
                    <strong>Plazas:</strong>
                    <?php echo $vehiculo['numero_plazas']; ?>
                </div>

                <div class="detalle">
                    <strong>Motor:</strong>
                    <?php echo $vehiculo['motor']; ?>
                </div>

                <div class="detalle">
                    <strong>Kilometraje:</strong>
                    <?php echo number_format($vehiculo['kilometraje'], 0, ',', '.'); ?> km
                </div>

                <div class="precio">
                    $<?php echo number_format($vehiculo['precio_alquiler_dia'], 0, ',', '.'); ?> / día
                </div>

                <div class="estado 
                    <?php echo ($vehiculo['disponibilidad'] == 'disponible') 
                        ? 'disponible' 
                        : 'no-disponible'; ?>">

                    <?php echo ucfirst($vehiculo['disponibilidad']); ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php echo view('layout/footer'); ?>