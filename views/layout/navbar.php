<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <h1 class="dropdown dropdown-header">Bienvenido, <?= Utils::decryptData($_SESSION['nombre']) ?></h1>
                <a href="<?= BASE_URL; ?>usuarios/perfil" class="dropdown-item">
                    <i class="fas fa-pencil-alt mr-2"></i> Editar mi perfil
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?= BASE_URL; ?>login/cerrar" class="dropdown-item">
                    <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                </a>
            </div>
        </li>
    </ul>
</nav>