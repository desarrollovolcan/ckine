<?php
$currentUser = Auth::user();
?>

<header class="app-topbar">
    <div class="container-fluid topbar-menu">
        <div class="d-flex align-items-center gap-2">
            <div class="logo-topbar">
                <a href="<?php echo app_path('/'); ?>" class="logo-light">
                    <span class="logo-lg"><img src="/assets/images/logo.png" alt="logo"></span>
                    <span class="logo-sm"><img src="/assets/images/logo-sm.png" alt="logo"></span>
                </a>
                <a href="<?php echo app_path('/'); ?>" class="logo-dark">
                    <span class="logo-lg"><img src="/assets/images/logo-black.png" alt="logo"></span>
                    <span class="logo-sm"><img src="/assets/images/logo-sm.png" alt="logo"></span>
                </a>
            </div>
            <button class="sidenav-toggle-button btn btn-default btn-icon">
                <i class="ti ti-menu-4 fs-22"></i>
            </button>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="topbar-item">
                <form method="get" action="<?php echo app_path('/agenda'); ?>" class="app-search d-none d-xl-flex">
                    <input type="search" class="form-control topbar-search rounded-pill" name="patient" placeholder="Buscar paciente...">
                    <i data-lucide="search" class="app-search-icon text-muted"></i>
                </form>
            </div>
            <div class="topbar-item">
                <div class="dropdown">
                    <button class="topbar-link d-flex align-items-center gap-2" data-bs-toggle="dropdown" data-bs-offset="0,24" type="button" aria-haspopup="false" aria-expanded="false">
                        <span class="avatar-sm rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center fw-semibold">
                            <?php echo e(mb_substr_safe($currentUser['name'] ?? 'U', 0, 1)); ?>
                        </span>
                        <span class="d-none d-sm-flex flex-column text-start">
                            <span class="fw-semibold"><?php echo e($currentUser['name'] ?? ''); ?></span>
                            <span class="text-muted fs-12"><?php echo e($currentUser['role'] ?? ''); ?></span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="<?php echo app_path('/password'); ?>" class="dropdown-item">Cambiar contraseña</a>
                        <form method="post" action="<?php echo app_path('/logout'); ?>">
                            <input type="hidden" name="csrf_token" value="<?php echo csrf_token(); ?>">
                            <button class="dropdown-item text-danger" type="submit">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
