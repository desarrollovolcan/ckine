<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo $role ? '/roles/actualizar' : '/roles'; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <?php if ($role): ?>
                <input type="hidden" name="id" value="<?php echo (int)$role['id']; ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="name" value="<?php echo e($role['name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Descripción</label>
                    <input type="text" class="form-control" name="description" value="<?php echo e($role['description'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <label class="form-label">Permisos</label>
                    <div class="row g-2">
                        <?php foreach ($permissions as $permission): ?>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="<?php echo (int)$permission['id']; ?>" <?php echo in_array((int)$permission['id'], $selected, true) ? 'checked' : ''; ?>>
                                    <label class="form-check-label"><?php echo e($permission['label']); ?></label>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <a href="/roles" class="btn btn-light">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
