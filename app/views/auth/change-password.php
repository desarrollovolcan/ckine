<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Cambiar contraseña</h4>
<form method="post" action="/auth/password">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <div class="mb-3">
        <label class="form-label">Nueva contraseña</label>
        <input type="password" name="password" class="form-control" required>
        <?php if (!empty($errors['password'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['password']); ?></small>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="form-control" required>
        <?php if (!empty($errors['password_confirmation'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['password_confirmation']); ?></small>
        <?php endif; ?>
    </div>
    <button class="btn btn-primary" type="submit">Actualizar</button>
</form>
