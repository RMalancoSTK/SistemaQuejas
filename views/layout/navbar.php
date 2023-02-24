<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Bienvendio, Alexander</span>
                <div class="dropdown-divider"></div>
                <a href="<?= BASE_URL; ?>usuarios/perfil" class="dropdown-item">
                    <i class="fas fa-pencil-alt mr-2"></i> Editar perfil
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= BASE_URL; ?>login/cerrar" class="dropdown-item">
                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->