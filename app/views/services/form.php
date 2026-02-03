<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo $service ? '/servicios/actualizar' : '/servicios'; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <?php if ($service): ?>
                <input type="hidden" name="id" value="<?php echo (int)$service['id']; ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="name" value="<?php echo e($service['name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Duración (min)</label>
                    <input type="number" class="form-control" name="duration_minutes" value="<?php echo e($service['duration_minutes'] ?? 60); ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" name="price" value="<?php echo e($service['price'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" name="description" rows="3"><?php echo e($service['description'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="active" <?php echo ($service['active'] ?? 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label">Activo</label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <a href="<?php echo app_path('/servicios'); ?>" class="btn btn-light">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
