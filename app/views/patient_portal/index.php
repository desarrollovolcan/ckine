<div class="row g-3">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Portal de agendamiento</h4>
                <small class="text-muted">Configura el acceso público y la disponibilidad.</small>
            </div>
            <div class="card-body">
                <form method="post" action="index.php?route=patient-portal/update">
                    <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                    <div class="alert alert-info">
                        El portal está <strong><?php echo !empty($portalSettings['enabled']) ? 'activo' : 'inactivo'; ?></strong>
                        para recibir solicitudes de pacientes.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Estado del portal</label>
                        <select name="enabled" class="form-select">
                            <option value="1" <?php echo !empty($portalSettings['enabled']) ? 'selected' : ''; ?>>Activo</option>
                            <option value="0" <?php echo empty($portalSettings['enabled']) ? 'selected' : ''; ?>>Inactivo</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">URL pública</label>
                        <input type="text" name="public_url" class="form-control" value="<?php echo e($portalSettings['public_url'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensaje de bienvenida</label>
                        <textarea name="welcome_message" class="form-control" rows="3"><?php echo e($portalSettings['welcome_message'] ?? ''); ?></textarea>
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
