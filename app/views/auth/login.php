<?php use App\Core\CSRF; ?>
<h4 class="mb-3">Ingreso</h4>
<?php if (!empty($errors['general'])): ?>
    <div class="alert alert-danger"><?php echo implode(', ', $errors['general']); ?></div>
<?php endif; ?>
<form method="post" action="/auth/login">
    <input type="hidden" name="csrf_token" value="<?php echo CSRF::token(); ?>">
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
        <?php if (!empty($errors['email'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['email']); ?></small>
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Contraseña</label>
        <input type="password" name="password" class="form-control" required>
        <?php if (!empty($errors['password'])): ?>
            <small class="text-danger"><?php echo implode(', ', $errors['password']); ?></small>
        <?php endif; ?>
    </div>
    <button class="btn btn-primary" type="submit">Ingresar</button>
</form>
