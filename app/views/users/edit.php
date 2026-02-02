<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Editar usuario</h4>
<form method="post" action="/users/<?php echo $user['id']; ?>/update">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (!empty($errors['name'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['name']); ?></small>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (!empty($errors['email'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['email']); ?></small>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Rol</label>
        <select name="role_id" class="form-select" required>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['id']; ?>" <?php echo ($role['id'] == ($user['role_id'] ?? 0)) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($role['name'], ENT_QUOTES, 'UTF-8'); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="must_change_password" class="form-check-input" id="mustChange" <?php echo !empty($user['must_change_password']) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="mustChange">Solicitar cambio de contraseña</label>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" name="is_active" class="form-check-input" id="isActive" <?php echo !empty($user['is_active']) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="isActive">Activo</label>
    </div>
    <button class="btn btn-primary" type="submit">Actualizar</button>
    <a class="btn btn-light" href="/users">Cancelar</a>
</form>
