<?php echo view('layout/header'); ?>

<section class="section section-vehiculos" style="min-height: 100vh;">
    <div class="container">
        
        <div class="box admin-box p-5">
            
            <div class="columns is-vcentered mb-5">
                <div class="column">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <a href="<?= site_url('administrador') ?>" class="btn-chakra-light" style="padding: 8px 12px; height: auto;" title="Volver al Panel">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="title is-3 has-text-dark mb-1 admin-box-title" style="margin: 0;">
                                <i class="fa-solid fa-car has-text-emerald-700 mr-2"></i>Administración de Vehículos
                            </h1>
                            <h2 class="subtitle is-6 has-text-grey" style="margin: 5px 0 0 0;">
                                Gestión de flota, disponibilidad, kilometraje y tarifas diarias de MyCar.
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="column is-narrow">
                    <a href="<?= site_url('vehiculos/new') ?>" class="btn-chakra-primary">
                        <span class="icon">
                            <i class="fa-solid fa-car-side"></i>
                        </span>
                        <span>Registrar Vehículo</span>
                    </a>
                </div>
            </div>

            <div class="table-container">
                <table class="table is-hoverable is-striped is-fullwidth">
                    <thead>
                        <tr class="has-background-white-ter">
                            <th class="has-text-grey">ID</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Año</th>
                            <th>Tipo</th>
                            <th class="has-text-centered">Plazas</th>
                            <th>Motor</th>
                            <th>Kilometraje</th>
                            <th>Precio/Día</th>
                            <th class="has-text-centered">Disponibilidad</th>
                            <th class="has-text-centered">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($vehiculos)): ?>
                            <?php foreach($vehiculos as $v): ?>
                                <tr>
                                    <td class="vertical-center">
                                        <span class="tag is-light is-normal has-text-weight-bold">
                                            #<?= $v['id_vehiculo'] ?>
                                        </span>
                                    </td>
                                    <td class="has-text-weight-semibold vertical-center">
                                        <?= esc($v['marca']) ?>
                                    </td>
                                    <td class="vertical-center">
                                        <?= esc($v['modelo']) ?>
                                    </td>
                                    <td class="vertical-center">
                                        <?= esc($v['anio']) ?>
                                    </td>
                                    <td class="vertical-center">
                                        <span class="tag is-white has-text-weight-semibold has-text-grey-dark">
                                            <?= ucfirst(esc($v['tipo_vehiculo'])) ?>
                                        </span>
                                    </td>
                                    <td class="has-text-centered vertical-center">
                                        <?= esc($v['numero_plazas']) ?>
                                    </td>
                                    <td class="vertical-center">
                                        <span class="is-size-7 code-text"><?= esc($v['motor']) ?></span>
                                    </td>
                                    <td class="vertical-center">
                                        <?= number_format($v['kilometraje'], 0, ',', '.') ?> KM
                                    </td>
                                    <td class="vertical-center has-text-weight-bold has-text-dark">
                                        $<?= number_format($v['precio_alquiler_dia'], 0, ',', '.') ?>
                                    </td>
                                    <td class="has-text-centered vertical-center">
                                        <?php if($v['disponibilidad'] == 'disponible'): ?>
                                            <span class="tag is-success is-light has-text-weight-bold is-uppercase">
                                                <i class="fa-solid fa-circle-check mr-1"></i> Disponible
                                            </span>
                                        <?php else: ?>
                                            <span class="tag is-danger is-light has-text-weight-bold is-uppercase">
                                                <i class="fa-solid fa-circle-xmark mr-1"></i> No Disponible
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="has-text-centered vertical-center">
                                        <div class="buttons is-centered are-small">
                                            <a href="<?= site_url('administrador/vehiculos/clientes/'.$v['id_vehiculo']) ?>" class="button is-success is-light has-text-weight-bold" title="Historial de clientes que lo alquilaron">
                                                <span class="icon is-small">
                                                    <i class="fa-solid fa-users"></i>
                                                </span>
                                                <span>Clientes</span>
                                            </a>
                                            <a href="<?= site_url('vehiculos/'.$v['id_vehiculo']) ?>" class="button is-info is-light has-text-weight-bold">
                                                <span class="icon is-small">
                                                    <i class="fa-solid fa-eye"></i>
                                                </span>
                                                <span>Ver</span>
                                            </a>
                                            <a href="<?= site_url('vehiculos/edit/'.$v['id_vehiculo']) ?>" class="button is-warning is-light has-text-weight-bold">
                                                <span class="icon is-small">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </span>
                                                <span>Editar</span>
                                            </a>
                                             <a href="<?= site_url('vehiculos/delete/'.$v['id_vehiculo']) ?>" class="button is-danger is-light has-text-weight-bold" onclick="showDeleteModal(event, this, '¿Seguro que desea dar de baja lógica a este vehículo? El coche ya no estará visible en el catálogo de alquiler.')">
                                                 <span class="icon is-small">
                                                     <i class="fa-solid fa-trash-can"></i>
                                                 </span>
                                                 <span>Baja</span>
                                             </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="11" class="has-text-centered has-text-grey-light py-6">
                                    <span class="icon is-large block mb-2">
                                        <i class="fa-solid fa-car-burst fa-2x"></i>
                                    </span>
                                    <p>No hay vehículos registrados en la plataforma.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</section>

<style>
    .table td.vertical-center {
        vertical-align: middle;
    }
    .code-text {
        font-family: monospace;
        background-color: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
    }
</style>

<!-- Modal de Confirmación de Baja Bulma -->
<div class="modal" id="delete-confirm-modal">
    <div class="modal-background" onclick="closeDeleteModal()"></div>
    <div class="modal-card" style="max-width: 450px; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-xl);">
        <header class="modal-card-head has-background-danger-light" style="border-bottom: 1px solid var(--red-100);">
            <p class="modal-card-title has-text-danger-dark has-text-weight-bold" style="font-family: var(--font-sans); font-size: 1.15rem;">
                <i class="fa-solid fa-triangle-exclamation mr-2"></i>Confirmar Baja
            </p>
            <button class="delete" aria-label="close" onclick="closeDeleteModal()"></button>
        </header>
        <section class="modal-card-body" style="padding: 24px;">
            <p id="delete-modal-text" class="has-text-grey-darker" style="font-family: var(--font-sans); font-size: 0.95rem; line-height: 1.5;"></p>
        </section>
        <footer class="modal-card-foot" style="justify-content: flex-end; gap: 10px; background-color: var(--slate-50); border-top: 1px solid var(--slate-200); padding: 15px 24px;">
            <button class="button" onclick="closeDeleteModal()" style="font-family: var(--font-sans); border-radius: var(--radius-md); font-weight: 600;">Cancelar</button>
            <a class="button is-danger has-text-weight-bold" id="delete-modal-confirm-btn" href="#" style="font-family: var(--font-sans); border-radius: var(--radius-md);">Confirmar Baja</a>
        </footer>
    </div>
</div>

<script>
function showDeleteModal(event, element, message) {
    event.preventDefault();
    const confirmBtn = document.getElementById('delete-modal-confirm-btn');
    const modalText = document.getElementById('delete-modal-text');
    const modal = document.getElementById('delete-confirm-modal');
    
    confirmBtn.href = element.href;
    if (message) {
        modalText.textContent = message;
    }
    modal.classList.add('is-active');
}

function closeDeleteModal() {
    const modal = document.getElementById('delete-confirm-modal');
    modal.classList.remove('is-active');
}
</script>

<?php echo view('layout/footer'); ?>