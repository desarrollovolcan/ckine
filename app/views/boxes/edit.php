<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">Editar box</h4>
        <small class="text-muted">ID box: <?php echo e($box['id'] ?? 'Sin ID'); ?></small>
    </div>
    <div class="card-body">
        <form method="post" action="index.php?route=boxes/update">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <input type="hidden" name="id" value="<?php echo e($box['id']); ?>">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Nombre del box</label>
                    <input type="text" name="name" class="form-control" value="<?php echo e($box['name'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Capacidad</label>
                    <input type="text" name="capacity" class="form-control" value="<?php echo e($box['capacity'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Estado</label>
                    <select name="status" class="form-select">
                        <?php foreach (['Disponible', 'En uso', 'En mantenimiento'] as $status): ?>
                            <option value="<?php echo e($status); ?>" <?php echo ($box['status'] ?? '') === $status ? 'selected' : ''; ?>>
                                <?php echo e($status); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Equipamiento</label>
                    <textarea name="equipment" class="form-control" rows="3"><?php echo e($box['equipment'] ?? ''); ?></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2 justify-content-end">
                <a href="index.php?route=boxes" class="btn btn-light">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </div>
        </form>
    </div>
</div>
