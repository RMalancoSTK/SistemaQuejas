<?php

class DashboardController
{
    public function index()
    {
        if (isset($_SESSION['active'])) {
            include_once 'views/layout/header.php';
            include_once 'views/layout/navbar.php';
            include_once 'views/layout/sidebar.php';
            require_once 'views/dashboard/index.php';
            include_once 'views/layout/footer.php';
        } else {
            header(LOCATION_LOGIN);
        }
    }
}
