<div class="card mt-5">
    <div class="card-body">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Ingreso Centro Kinésico</h3>
            <p class="text-muted">Accede con tu usuario y contraseña.</p>
        </div>
        <form method="post" action="/login">
            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="d-grid">
                <button class="btn btn-primary" type="submit">Ingresar</button>
            </div>
        </form>
    </div>
</div>
