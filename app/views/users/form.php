<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo $user ? '/usuarios/actualizar' : '/usuarios'; ?>">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <?php if ($user): ?>
                <input type="hidden" name="id" value="<?php echo (int)$user['id']; ?>">
            <?php endif; ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="name" value="<?php echo e($user['name'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo e($user['email'] ?? ''); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Rol</label>
                    <select class="form-select" name="role_id">
                        <option value="">Sin rol</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?php echo (int)$role['id']; ?>" <?php echo ($user['role_id'] ?? '') == $role['id'] ? 'selected' : ''; ?>>
                                <?php echo e($role['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" <?php echo $user ? '' : 'required'; ?>>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Guardar</button>
                    <a href="/usuarios" class="btn btn-light">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
