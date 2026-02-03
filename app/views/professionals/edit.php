<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Editar profesional</h4>
        <small class="text-muted">ID profesional: <?php echo e($professional['id'] ?? 'Sin ID'); ?></small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=professionals/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" value="<?php echo e($professional['id']); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre completo</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($professional['name'] ?? ''); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Especialidad</label>
                    <input type="text" name="specialty" class="form-control" value="<?php echo e($professional['specialty'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" class="form-control" value="<?php echo e($professional['email'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo e($professional['phone'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <?php foreach (['Activo', 'En pausa', 'Inactivo'] as $status): ?>
                            <option value="<?php echo e($status); ?>" <?php echo ($professional['status'] ?? '') === $status ? 'selected' : ''; ?>>
                                <?php echo e($status); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Notas</label>
                    <textarea name="notes" class="form-control" rows="3"><?php echo e($professional['notes'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=professionals" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
