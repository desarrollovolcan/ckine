<div class="row g-3">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Portal de agendamiento</h4>
                <small class="text-muted">Configura el acceso público y la disponibilidad.</small>
            </div>
            <div class="card-body">
                <div class="alert alert-<?php echo !empty($portalConfig['active']) ? 'info' : 'warning'; ?>">
                    El portal está <strong><?php echo !empty($portalConfig['active']) ? 'activo' : 'inactivo'; ?></strong> para recibir solicitudes de pacientes.
                </div>
                <form method="post" action="index.php?route=patient-portal/update">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="active" id="portalActive" <?php echo !empty($portalConfig['active']) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="portalActive">Portal activo</label>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL pública</label>
                        <input type="text" name="public_url" class="form-control" value="<?php echo e($portalConfig['public_url'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensaje de bienvenida</label>
                        <textarea name="welcome_message" class="form-control" rows="3"><?php echo e($portalConfig['welcome_message'] ?? ''); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar configuración</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Indicadores</h4>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Solicitudes pendientes</span>
                        <span class="fw-semibold">5</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Solicitudes aprobadas</span>
                        <span class="fw-semibold">18</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Última solicitud</span>
                        <span class="fw-semibold">Hace 2 horas</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
