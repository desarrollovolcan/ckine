<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Editar paciente</h4>
        <small class="text-muted">ID paciente: <?php echo e($patient['id'] ?? 'Sin ID'); ?></small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=patients/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" value="<?php echo e($patient['id']); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($patient['name'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">RUT</label>
                    <input type="text" name="rut" class="form-control" value="<?php echo e($patient['rut'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <?php foreach (['Activo', 'En seguimiento', 'Alta', 'Inactivo'] as $status): ?>
                            <option value="<?php echo e($status); ?>" <?php echo ($patient['status'] ?? '') === $status ? 'selected' : ''; ?>>
                                <?php echo e($status); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha nacimiento</label>
                    <input type="date" name="birthdate" class="form-control" value="<?php echo e($patient['birthdate'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e($patient['email'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo e($patient['phone'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Observaciones clínicas</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo e($patient['notes'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=patients" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
