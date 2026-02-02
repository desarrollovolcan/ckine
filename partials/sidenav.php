<!-- Sidenav Menu Start -->
<div class="sidenav-menu">

    <!-- Brand Logo -->
    <a href="<?php echo $baseUrl; ?>dashboard" class="logo">
        <span class="logo-light">
            <span class="logo-lg"><img src="assets/images/logo-light.png" alt="logo"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
        </span>

        <span class="logo-dark">
            <span class="logo-lg"><img src="assets/images/logo-dark.png" alt="dark logo"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-sm-hover">
        <i class="ti ti-circle align-middle"></i>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-fullsidebar">
        <i class="ti ti-x align-middle"></i>
    </button>

    <div data-simplebar>

        <!--- Sidenav Menu -->
        <ul class="side-nav">
            <li class="side-nav-title">Centro Kinésico</li>

            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>dashboard" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="layout-dashboard"></i></span>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>

            <li class="side-nav-title">Atención</li>

            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>appointments" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="calendar-days"></i></span>
                    <span class="menu-text">Agenda / Citas</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>patients" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="user"></i></span>
                    <span class="menu-text">Pacientes</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>records" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="clipboard-list"></i></span>
                    <span class="menu-text">Ficha clínica</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>professionals" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="stethoscope"></i></span>
                    <span class="menu-text">Profesionales</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>boxes" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="grid"></i></span>
                    <span class="menu-text">Box / Salas</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>services" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="briefcase"></i></span>
                    <span class="menu-text">Servicios</span>
                </a>
            </li>

            <li class="side-nav-title">Gestión</li>

            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>reports" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="bar-chart-3"></i></span>
                    <span class="menu-text">Reportes</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>audit" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="shield-check"></i></span>
                    <span class="menu-text">Auditoría</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>users" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="users"></i></span>
                    <span class="menu-text">Usuarios</span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>roles" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="key"></i></span>
                    <span class="menu-text">Roles y permisos</span>
                </a>
            </li>

            <li class="side-nav-title">Portal</li>

            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>portal" class="side-nav-link" target="_blank">
                    <span class="menu-icon"><i data-lucide="globe"></i></span>
                    <span class="menu-text">Agendamiento público</span>
                </a>
            </li>

            <li class="side-nav-title">Cuenta</li>
            <li class="side-nav-item">
                <a href="<?php echo $baseUrl; ?>auth/logout" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="log-out"></i></span>
                    <span class="menu-text">Cerrar sesión</span>
                </a>
            </li>
        </ul>
        <!--- End Sidenav Menu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- Sidenav Menu End -->
