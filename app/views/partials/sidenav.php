<?php
$logoColor = $companySettings['logo_color'] ?? 'assets/images/logo.png';
$logoBlack = $companySettings['logo_black'] ?? 'assets/images/logo-black.png';
$logoSmallColor = $companySettings['logo_color'] ?? 'assets/images/logo-sm.png';
$logoSmallBlack = $companySettings['logo_black'] ?? 'assets/images/logo-sm.png';
?>

<div class="sidenav-menu">
    <a href="index.php" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="<?php echo e($logoColor); ?>" alt="logo"></span>
            <span class="logo-sm"><img src="<?php echo e($logoSmallColor); ?>" alt="small logo"></span>
        </span>
        <span class="logo logo-dark">
            <span class="logo-lg"><img src="<?php echo e($logoBlack); ?>" alt="dark logo"></span>
            <span class="logo-sm"><img src="<?php echo e($logoSmallBlack); ?>" alt="small logo"></span>
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
        <?php
        $isAdmin = ($currentUser['role'] ?? '') === 'admin';
        $hasCompany = !empty($currentCompany['id']);
        $hasPermission = static function (string $key) use ($permissions, $isAdmin): bool {
            if ($isAdmin) {
                return true;
            }
            if (in_array($key, $permissions ?? [], true)) {
                return true;
            }
            $legacyKey = permission_legacy_key_for($key);
            return $legacyKey ? in_array($legacyKey, $permissions ?? [], true) : false;
        };
        $canAccessAny = static function (array $keys) use ($hasPermission): bool {
            foreach ($keys as $key) {
                if ($hasPermission($key)) {
                    return true;
                }
            }
            return false;
        };
        ?>
        <ul class="side-nav">
            <li class="side-nav-title mt-2">Menú</li>
            <?php if ($hasCompany && $canAccessAny(['patients_view', 'professionals_view', 'boxes_view', 'services_view', 'appointments_view', 'patient_portal_view', 'clinical_records_view', 'reports_view'])): ?>
                <li class="side-nav-title">Clínica</li>
                <?php if ($hasPermission('patients_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=patients" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="users"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Pacientes</span>
                                <span class="menu-caption">Fichas y seguimiento</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('professionals_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=professionals" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="stethoscope"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Profesionales</span>
                                <span class="menu-caption">Equipo clínico</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('boxes_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=boxes" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="door-open"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Box / Salas</span>
                                <span class="menu-caption">Espacios disponibles</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('services_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=services" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="briefcase"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Servicios</span>
                                <span class="menu-caption">Prestaciones clínicas</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('appointments_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=appointments/calendar" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="calendar-days"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Agenda / Citas</span>
                                <span class="menu-caption">Calendario clínico</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('patient_portal_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=patient-portal" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="globe"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Portal pacientes</span>
                                <span class="menu-caption">Agendamiento online</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('clinical_records_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=clinical" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="file-text"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Historial clínico</span>
                                <span class="menu-caption">Evolución y notas</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('reports_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=reports" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="bar-chart-3"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Reportes</span>
                                <span class="menu-caption">Indicadores y métricas</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($hasCompany && $canAccessAny(['users_view', 'roles_view', 'users_permissions_view', 'audit_view', 'settings_view'])): ?>
                <li class="side-nav-title">Administración</li>
                <?php if ($hasPermission('users_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=users" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="user-cog"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Usuarios</span>
                                <span class="menu-caption">Cuentas y accesos</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('roles_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=roles" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="shield"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Roles</span>
                                <span class="menu-caption">Perfiles de acceso</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('users_permissions_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=users/permissions" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="key-round"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Permisos</span>
                                <span class="menu-caption">Matriz de permisos</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('audit_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=audit" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="clipboard-check"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Auditoría / Logs</span>
                                <span class="menu-caption">Acciones del sistema</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('settings_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=settings" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="settings"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Configuración</span>
                                <span class="menu-caption">Parámetros generales</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($hasCompany && $canAccessAny(['email_templates_view', 'email_queue_view'])): ?>
                <li class="side-nav-title">Comunicaciones</li>
                <?php if ($hasPermission('email_templates_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=email-templates" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="mail"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Plantillas Email</span>
                                <span class="menu-caption">Mensajes y diseños</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($hasPermission('email_queue_view')): ?>
                    <li class="side-nav-item">
                        <a href="index.php?route=email-queue" class="side-nav-link">
                            <span class="menu-icon"><i data-lucide="send"></i></span>
                            <span class="menu-label">
                                <span class="menu-text">Cola de Correos</span>
                                <span class="menu-caption">Envíos programados</span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <?php if ($canAccessAny(['users_view', 'roles_view', 'users_companies_view', 'users_permissions_view', 'settings_view'])): ?>
                <li class="side-nav-title">Mantenedores</li>
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarMaintainers" aria-expanded="false" aria-controls="sidebarMaintainers" class="side-nav-link">
                        <span class="menu-icon"><i data-lucide="database"></i></span>
                        <span class="menu-label">
                            <span class="menu-text">Mantenedores</span>
                            <span class="menu-caption">Configuración y catálogos</span>
                        </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarMaintainers">
                        <ul class="sub-menu">
                            <?php if ($canAccessAny(['users_view', 'users_edit', 'roles_view', 'users_companies_view', 'users_permissions_view'])): ?>
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarMaintainersUsers" aria-expanded="false" aria-controls="sidebarMaintainersUsers" class="side-nav-link">
                                        <span class="menu-text">Usuarios</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarMaintainersUsers">
                                        <ul class="sub-menu">
                                            <?php if ($hasPermission('users_view')): ?>
                                                <li class="side-nav-item">
                                                    <a href="index.php?route=users" class="side-nav-link">
                                                        <span class="menu-text">Listado usuarios</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($hasPermission('users_permissions_view')): ?>
                                                <li class="side-nav-item">
                                                    <a href="index.php?route=users/permissions" class="side-nav-link">
                                                        <span class="menu-text">Roles y permisos</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($hasPermission('roles_view')): ?>
                                                <li class="side-nav-item">
                                                    <a href="index.php?route=roles" class="side-nav-link">
                                                        <span class="menu-text">Roles</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($hasPermission('users_companies_view')): ?>
                                                <li class="side-nav-item">
                                                    <a href="index.php?route=users/assign-company" class="side-nav-link">
                                                        <span class="menu-text">Asignar empresa</span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <?php if ($hasCompany && $hasPermission('settings_view')): ?>
                                <li class="side-nav-item">
                                    <a href="index.php?route=settings" class="side-nav-link">
                                        <span class="menu-text">Configuraciones</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>

<script>
    (function () {
        const currentRoute = new URLSearchParams(window.location.search).get('route') || 'dashboard';
        const links = document.querySelectorAll('.side-nav-link[href*="route="]');
        links.forEach((link) => {
            let linkRoute = '';
            try {
                linkRoute = new URL(link.href, window.location.origin).searchParams.get('route') || '';
            } catch (error) {
                linkRoute = '';
            }
            if (!linkRoute) {
                return;
            }
            const isActive = currentRoute === linkRoute || currentRoute.startsWith(`${linkRoute}/`);
            if (!isActive) {
                return;
            }
            link.classList.add('active');
            link.closest('.side-nav-item')?.classList.add('active');
            const collapse = link.closest('.collapse');
            if (collapse) {
                collapse.classList.add('show');
                const toggle = collapse.previousElementSibling;
                if (toggle && toggle.classList.contains('side-nav-link')) {
                    toggle.classList.add('active');
                    toggle.setAttribute('aria-expanded', 'true');
                }
            }
        });
    })();
</script>
