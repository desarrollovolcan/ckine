<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Nuevo usuario</h4>
<form method="post" action="<?php echo $baseUrl; ?>users">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control" required>
        <?php if (!empty($errors['name'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['name']); ?></small>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
        <?php if (!empty($errors['email'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['email']); ?></small>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Rol</label>
        <select name="role_id" class="form-select" required>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['id']; ?>"><?php echo htmlspecialchars($role['name'], ENT_QUOTES, 'UTF-8'); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control" required>
        <?php if (!empty($errors['password'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['password']); ?></small>
        <?php endif; ?>
    </div>
    <button class="btn btn-primary" type="submit">Guardar</button>
    <a class="btn btn-light" href="<?php echo $baseUrl; ?>users">Cancelar</a>
</form>
