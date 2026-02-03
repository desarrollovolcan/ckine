<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo $box ? '/box/actualizar' : '/box'; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <?php if ($box): ?>
                <input type="hidden" name="id" value="<?php echo (int)$box['id']; ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="name" value="<?php echo e($box['name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select class="form-select" name="status">
                        <?php $status = $box['status'] ?? 'activo'; ?>
                        <option value="activo" <?php echo $status === 'activo' ? 'selected' : ''; ?>>Activo</option>
                        <option value="inactivo" <?php echo $status === 'inactivo' ? 'selected' : ''; ?>>Inactivo</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" name="description" rows="3"><?php echo e($box['description'] ?? ''); ?></textarea>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <a href="<?php echo app_path('/box'); ?>" class="btn btn-light">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
