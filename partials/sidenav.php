<!-- Sidenav Menu Start -->
<div class="sidenav-menu">

    <!-- Brand Logo -->
    <a href="index.php" class="logo">
        <span class="logo logo-light">
            <span class="logo-lg"><img src="assets/images/logo.png" alt="logo"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
        </span>

        <span class="logo logo-dark">
            <span class="logo-lg"><img src="assets/images/logo-black.png" alt="dark logo"></span>
            <span class="logo-sm"><img src="assets/images/logo-sm.png" alt="small logo"></span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-on-hover">
        <i class="ti ti-menu-4 fs-22 align-middle"></i>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-offcanvas">
        <i class="ti ti-x align-middle"></i>
    </button>

    <div class="scrollbar" data-simplebar>

        <!-- User -->
        <div class="sidenav-user">

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="users-profile.php" class="link-reset">
                        <img src="assets/images/users/user-3.jpg" alt="user-image" class="rounded-circle mb-2 avatar-md">
                        <span class="sidenav-user-name fw-bold">Geneva K.</span>
                        <span class="fs-12 fw-semibold" data-lang="user-role">Art Director</span>
                    </a>
                </div>
                <div>
                    <a class="dropdown-toggle drop-arrow-none link-reset sidenav-user-set-icon" data-bs-toggle="dropdown" data-bs-offset="0,12" href="#!" aria-haspopup="false" aria-expanded="false">
                        <i class="ti ti-settings fs-24 align-middle ms-1"></i>
                    </a>

                    <div class="dropdown-menu">
                        <!-- Header -->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome back!</h6>
                        </div>

                        <!-- My Profile -->
                        <a href="profile.php" class="dropdown-item">
                            <i class="ti ti-user-circle me-2 fs-17 align-middle"></i>
                            <span class="align-middle">Profile</span>
                        </a>

                        <!-- Notifications -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-bell-ringing me-2 fs-17 align-middle"></i>
                            <span class="align-middle">Notifications</span>
                        </a>

                        <!-- Settings -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-settings-2 me-2 fs-17 align-middle"></i>
                            <span class="align-middle">Account Settings</span>
                        </a>

                        <!-- Support -->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-headset me-2 fs-17 align-middle"></i>
                            <span class="align-middle">Support Center</span>
                        </a>

                        <!-- Divider -->
                        <div class="dropdown-divider"></div>

                        <!-- Lock -->
                        <a href="auth-lock-screen.php" class="dropdown-item">
                            <i class="ti ti-lock me-2 fs-17 align-middle"></i>
                            <span class="align-middle">Lock Screen</span>
                        </a>

                        <!-- Logout -->
                        <a href="javascript:void(0);" class="dropdown-item fw-semibold">
                            <i class="ti ti-logout-2 me-2 fs-17 align-middle"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!--- Sidenav Menu -->
        <ul class="side-nav">
            <li class="side-nav-title mt-2" data-lang="menu-title">Gestión</li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarUsers" aria-expanded="false" aria-controls="sidebarUsers" class="side-nav-link">
                    <span class="menu-icon"><i data-lucide="users"></i></span>
                    <span>
                        <span class="menu-text" data-lang="users">Usuarios y permisos</span>
                        <span class="menu-caption">Gestión de roles</span>
                    </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarUsers">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="users-contacts.php" class="side-nav-link">
                                <span class="menu-text" data-lang="contacts">Usuarios</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="users-roles.php" class="side-nav-link">
                                <span class="menu-text" data-lang="roles">Roles</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="users-role-details.php" class="side-nav-link">
                                <span class="menu-text" data-lang="role-details">Detalle de rol</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="users-permissions.php" class="side-nav-link">
                                <span class="menu-text" data-lang="permissions">Permisos</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
<!-- Sidenav Menu End -->
