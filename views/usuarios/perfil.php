<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Mi Perfil</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?= Utils::getBreadCrumbs(); ?>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-lg-6 col-sm-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Datos de mi perfil</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" id="frmeditarperfil" action="<?= BASE_URL; ?>usuarios/editarperfil" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="usuario" class="col-sm-3 col-form-label">Usuario</label>
                                <div class="col-sm-9">
                                    <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario" required readonly value="<?= isset($this->usuario->usuario) ? $this->usuario->usuario : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
                                <div class="col-sm-9">
                                    <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" required value="<?= isset($this->usuario->nombre) ? $this->usuario->nombre : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="apellido" class="col-sm-3 col-form-label">Apellido</label>
                                <div class="col-sm-9">
                                    <input id="apellido" class="form-control" type="text" name="apellido" placeholder="Apellido" required value="<?= isset($this->usuario->apellido) ? $this->usuario->apellido : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email" class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input id="email" class="form-control" type="email" name="email" placeholder="Email" required value="<?= isset($this->usuario->email) ? $this->usuario->email : ''; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <!-- botones de guardar y cancelar -->
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success float-left">Guardar</button>
                                    <a href="<?= BASE_URL; ?>" class="btn btn-danger float-left ml-2">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-6">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Cambio de contraseña</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" id="frmchangepassword" action="<?= BASE_URL; ?>usuarios/changepassword" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="password" class="col-sm-4 col-form-label">Contraseña</label>
                                <div class="col-sm-8">
                                    <input id="password" class="form-control" type="password" name="password" placeholder="Contraseña" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="newpassword" class="col-sm-4 col-form-label">Nueva Contraseña</label>
                                <div class="col-sm-8">
                                    <input id="newpassword" class="form-control" type="password" name="newpassword" placeholder="Nueva Contraseña" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="confirmnewpassword" class="col-sm-4 col-form-label">Confirmar Contraseña</label>
                                <div class="col-sm-8">
                                    <input id="confirmnewpassword" class="form-control" type="password" name="confirmnewpassword" placeholder="Confirmar Contraseña" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-success float-left">Guardar</button>
                                    <a href="<?= BASE_URL; ?>" class="btn btn-danger float-left ml-2">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>