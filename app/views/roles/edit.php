<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Editar rol</h4>
<form method="post" action="/roles/<?php echo $role['id']; ?>/update">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <div class="mb-3">
        <label class="form-label">Nombre</label>
        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($role['name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
        <?php if (!empty($errors['name'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['name']); ?></small>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Descripción</label>
        <input type="text" name="description" class="form-control" value="<?php echo htmlspecialchars($role['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Permisos</label>
        <div class="row">
            <?php foreach ($permissions as $permission): ?>
                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="permissions[]" value="<?php echo $permission['id']; ?>" id="perm_<?php echo $permission['id']; ?>" <?php echo in_array($permission['id'], $selected ?? [], true) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="perm_<?php echo $permission['id']; ?>">
                            <?php echo htmlspecialchars($permission['description'] ?? $permission['key'], ENT_QUOTES, 'UTF-8'); ?>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <button class="btn btn-primary" type="submit">Actualizar</button>
    <a class="btn btn-light" href="/roles">Cancelar</a>
</form>
