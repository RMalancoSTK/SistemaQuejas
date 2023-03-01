<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= BASE_URL; ?>" class="brand-link">
        <img src="<?= BASE_URL; ?>public/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Sistema de quejas</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class-->
                <li class="nav-item">
                    <a href="<?= BASE_URL; ?>" class="nav-link <?= Utils::setActive('dashboard/index'); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview <?= Utils::setMenuOpen('quejas'); ?>">
                    <a href="" class="nav-link <?= Utils::setActive('quejas'); ?>">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>
                            Quejas
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= BASE_URL; ?>quejas/crear" class="nav-link <?= Utils::setActive('quejas/crear'); ?>">
                                <i class=" fas fa-plus nav-icon"></i>
                                <p>Crear queja</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= BASE_URL; ?>quejas/misquejas" class="nav-link <?= Utils::setActive('quejas/misquejas'); ?>">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Mis quejas</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= BASE_URL; ?>quejas/index" class="nav-link <?= Utils::setActive('quejas/index'); ?>">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Lista de quejas</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview <?= Utils::setMenuOpen('usuarios'); ?>">
                    <a href="" class="nav-link <?= Utils::setActive('usuarios'); ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Usuarios
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= BASE_URL; ?>usuarios/crear" class="nav-link <?= Utils::setActive('usuarios/crear'); ?>">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Crear usuario</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= BASE_URL; ?>usuarios/listar" class="nav-link <?= Utils::setActive('usuarios/listar'); ?>">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Lista de usuarios</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview <?= Utils::setMenuOpen('ajustes'); ?>">
                    <a href="" class="nav-link <?= Utils::setActive('ajustes'); ?>">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            Ajustes
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= BASE_URL; ?>ajustes/general" class="nav-link <?= Utils::setActive('ajustes/general'); ?>">
                                <i class="fas fa-list nav-icon"></i>
                                <p>Generales</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">