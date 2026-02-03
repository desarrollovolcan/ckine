<?php
$currentUser = Auth::user();
$isAdmin = ($currentUser['role'] ?? '') === 'Admin';
?>

<div class="sidenav-menu">
    <a href="/" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="/assets/images/logo.png" alt="logo"></span>
            <span class="logo-sm"><img src="/assets/images/logo-sm.png" alt="logo-sm"></span>
        </span>
        <span class="logo logo-dark">
            <span class="logo-lg"><img src="/assets/images/logo-black.png" alt="logo"></span>
            <span class="logo-sm"><img src="/assets/images/logo-sm.png" alt="logo-sm"></span>
        </span>
    </a>
    <button class="button-on-hover">
        <i class="ti ti-menu-4 fs-22 align-middle"></i>
    </button>
    <button class="button-close-offcanvas">
        <i class="ti ti-x align-middle"></i>
    </button>
    <div class="scrollbar" data-simplebar>
        <div class="sidenav-user">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="sidenav-user-name fw-bold"><?php echo e($currentUser['name'] ?? 'Usuario'); ?></span>
                    <span class="fs-12 fw-semibold"><?php echo e($currentUser['role'] ?? ''); ?></span>
                </div>
            </div>
        </div>
        <ul class="side-nav">
            <li class="side-nav-title mt-2">Centro Kinésico</li>
            <li class="side-nav-item">
                <a href="/" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="home"></i></span>
                    <span class="menu-label">
                        <span class="menu-text">Dashboard</span>
                        <span class="menu-caption">Resumen diario</span>
                    </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="/agenda" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="calendar"></i></span>
                    <span class="menu-label">
                        <span class="menu-text">Agenda</span>
                        <span class="menu-caption">Citas y disponibilidad</span>
                    </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="/pacientes" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="users"></i></span>
                    <span class="menu-label">
                        <span class="menu-text">Pacientes</span>
                        <span class="menu-caption">Ficha y evolución</span>
                    </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="/profesionales" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="stethoscope"></i></span>
                    <span class="menu-label">
                        <span class="menu-text">Profesionales</span>
                        <span class="menu-caption">Equipo clínico</span>
                    </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="/box" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="door-open"></i></span>
                    <span class="menu-label">
                        <span class="menu-text">Box</span>
                        <span class="menu-caption">Salas y recursos</span>
                    </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="/servicios" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="clipboard-list"></i></span>
                    <span class="menu-label">
                        <span class="menu-text">Servicios</span>
                        <span class="menu-caption">Prestaciones</span>
                    </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="/fichas" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="file-text"></i></span>
                    <span class="menu-label">
                        <span class="menu-text">Fichas clínicas</span>
                        <span class="menu-caption">Historial paciente</span>
                    </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="/reportes" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="bar-chart"></i></span>
                    <span class="menu-label">
                        <span class="menu-text">Reportes</span>
                        <span class="menu-caption">Agenda y KPI</span>
                    </span>
                </a>
            </li>
            <?php if ($isAdmin): ?>
                <li class="side-nav-title">Administración</li>
                <li class="side-nav-item">
                    <a href="/usuarios" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="user-cog"></i></span>
                        <span class="menu-label">
                            <span class="menu-text">Usuarios</span>
                            <span class="menu-caption">Roles y accesos</span>
                        </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/roles" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="shield"></i></span>
                        <span class="menu-label">
                            <span class="menu-text">Roles</span>
                            <span class="menu-caption">Permisos</span>
                        </span>
                    </a>
                </li>
                <li class="side-nav-item">
                    <a href="/auditoria" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="activity"></i></span>
                        <span class="menu-label">
                            <span class="menu-text">Auditoría</span>
                            <span class="menu-caption">Cambios críticos</span>
                        </span>
                    </a>
                </li>
            <?php endif; ?>
            <li class="side-nav-title">Portal</li>
            <li class="side-nav-item">
                <a href="/portal" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="globe"></i></span>
                    <span class="menu-label">
                        <span class="menu-text">Agendamiento público</span>
                        <span class="menu-caption">Self-service</span>
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>
