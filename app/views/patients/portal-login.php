<?php
$loginLogoSrc = login_logo_src($companySettings ?? []);
?>

<div class="auth-box p-0 w-100">
    <div class="row w-100 g-0">
        <div class="col-xxl-4 col-xl-6">
            <div class="card border-0 mb-0">
                <div class="card-body min-vh-100 d-flex flex-column justify-content-center">
                    <div class="auth-brand mb-0 text-center">
                        <a href="index.php" class="logo-login">
                            <img src="<?php echo e($loginLogoSrc); ?>" alt="logo" height="28">
                        </a>
                    </div>

                    <div class="mt-auto">
                        <div class="p-2 text-center">
                            <h3 class="fw-bold my-2">Acceso Portal de Pacientes</h3>
                            <p class="text-muted mb-0">Ingresa con tu correo (o RUT) y fecha de nacimiento.</p>

                            <?php if (!empty($error)): ?>
                                <div class="alert alert-danger text-start mt-3"><?php echo e($error); ?></div>
                            <?php endif; ?>

                            <form class="mt-4" method="post" action="index.php?route=patients/portal/login">
                                <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                                <div class="app-search w-100 input-group rounded-pill mb-3">
                                    <select name="company_id" class="form-select py-2" required>
                                        <option value="">Selecciona tu clínica</option>
                                        <?php foreach (($companies ?? []) as $company): ?>
                                            <option value="<?php echo e((string)$company['id']); ?>" <?php echo ((int)($companyId ?? 0) === (int)$company['id']) ? 'selected' : ''; ?>>
                                                <?php echo e($company['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="app-search w-100 input-group rounded-pill mb-3">
                                    <input type="text" name="identifier" class="form-control py-2" value="<?php echo e($identifier ?? ''); ?>" placeholder="Correo o RUT" required>
                                    <i data-lucide="circle-user" class="app-search-icon text-muted"></i>
                                </div>
                                <div class="app-search w-100 input-group rounded-pill mb-2">
                                    <input type="date" name="birthdate" class="form-control py-2" value="<?php echo e($birthdate ?? ''); ?>" required>
                                    <i data-lucide="calendar" class="app-search-icon text-muted"></i>
                                </div>
                                <p class="text-muted fs-xs mb-3">Usa la misma fecha registrada en la clínica para validar tu acceso.</p>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary fw-semibold">Ingresar al portal</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <h5 class="fw-semibold mb-2">¿Eres administrador?</h5>
                        <p class="text-muted mb-3">Ingresa al panel de control si trabajas en la clínica.</p>
                        <a class="btn btn-outline-primary" href="login.php">Ir al panel de control</a>
                    </div>

                    <p class="text-center text-muted mt-4 mb-0">
                        ¿Problemas de acceso? Contacta a tu clínica para actualizar tus datos.
                    </p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="h-100 position-relative card-side-img rounded-0 overflow-hidden">
                <div class="p-4 card-img-overlay auth-overlay d-flex align-items-end justify-content-center">
                    <div class="text-center text-white">
                        <h3 class="mb-2">Tu salud, a un clic</h3>
                        <p class="mb-0">Revisa tus próximos controles, datos de contacto y recomendaciones.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
