<div class="card">
    <div class="card-body">
        <h4 class="card-title">Cambiar contraseña</h4>
        <form method="post" action="<?php echo app_path('/password'); ?>" class="mt-3">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="mb-3">
                <label class="form-label">Nueva contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" class="form-control" name="password_confirm" required>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</div>
