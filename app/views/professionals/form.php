<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo $professional ? '/profesionales/actualizar' : '/profesionales'; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <?php if ($professional): ?>
                <input type="hidden" name="id" value="<?php echo (int)$professional['id']; ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="first_name" value="<?php echo e($professional['first_name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Apellido</label>
                    <input type="text" class="form-control" name="last_name" value="<?php echo e($professional['last_name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Usuario asociado</label>
                    <select class="form-select" name="user_id">
                        <option value="">Sin usuario</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo (int)$user['id']; ?>" <?php echo ($professional['user_id'] ?? '') == $user['id'] ? 'selected' : ''; ?>>
                                <?php echo e($user['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Especialidad</label>
                    <input type="text" class="form-control" name="specialty" value="<?php echo e($professional['specialty'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="phone" value="<?php echo e($professional['phone'] ?? ''); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo e($professional['email'] ?? ''); ?>">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="active" <?php echo ($professional['active'] ?? 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label">Activo</label>
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <a href="/profesionales" class="btn btn-light">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
