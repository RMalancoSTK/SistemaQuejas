<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>sistema de quejas</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= BASE_URL; ?>public/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL; ?>public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL; ?>public/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="<?= BASE_URL; ?>public/index2.html"><b>Sistema</b> de quejas</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Inicio de sesión</p>
                <form action="<?= BASE_URL; ?>login/login" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Usuario" id="usuario" name="usuario">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Contraseña" id="password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Inicio de sesión</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="<?= BASE_URL; ?>public/plugins/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL; ?>public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL; ?>public/js/adminlte.min.js"></script>
</body>

</html>