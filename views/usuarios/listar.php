<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lista de Usuarios</h1>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tabla de Usuarios</h3>
                        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalUsuario" onclick="limpiarFormularioUsuario()">
                            <i class="fas fa-plus"></i> Agregar Usuario
                        </button>
                    </div>
                    <div class="card-body">
                        <table id="tablausuarios" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Departamento</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalUsuario">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Usuario</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUsuario" method="POST">
                    <input type="hidden" id="idusuario" name="idusuario" value="0">
                    <div class="form-group row">
                        <label for="usuario" class="col-sm-3 col-form-label">Usuario</label>
                        <div class="col-sm-9">
                            <input id="usuario" class="form-control" type="text" name="usuario" placeholder="Usuario" required>
                        </div>
                    </div>
                    <div class="form-group row" id="divpassword" style="height: 0; overflow: hidden;">
                        <label for="password" class="col-sm-3 col-form-label">Contraseña</label>
                        <div class="col-sm-9">
                            <input id="password" class="form-control" type="password" name="password" placeholder="Contraseña" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
                        <div class="col-sm-9">
                            <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="apellido" class="col-sm-3 col-form-label">Apellido</label>
                        <div class="col-sm-9">
                            <input id="apellido" class="form-control" type="text" name="apellido" placeholder="Apellido" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input id="email" class="form-control" type="email" name="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="departamento" class="col-sm-3 col-form-label">Departamento</label>
                        <div class="col-sm-9">
                            <select id="departamento" class="form-control" name="departamento" required>
                                <option value="">Seleccione un Departamento</option>
                                <?php foreach ($this->getDepartamentos() as $departamento) : ?>
                                    <option value="<?= $departamento->iddepartamento ?>"><?= $departamento->nombre ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rol" class="col-sm-3 col-form-label">Rol</label>
                        <div class="col-sm-9">
                            <select id="rol" class="form-control" name="rol" required>
                                <option value="">Seleccione un Rol</option>
                                <?php foreach ($this->getRoles() as $rol) : ?>
                                    <option value="<?= $rol->idrol ?>"><?= $rol->rol ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" onclick="guardarUsuario(event)">
                                    <i class="fas fa-save"></i>
                                    Guardar
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">
                                    <i class="fas fa-times"></i>
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalcambiarpassword">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cambiar Contraseña</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formcambiarpassword" method="POST">
                    <input type="hidden" id="cambiarpasswordidusuario" name="idusuario" value="0">
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="nuevacontraseña">Nueva Contraseña</label>
                            <input id="nuevapassword" class="form-control" type="password" name="nuevapassword" placeholder="Nueva Contraseña" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" onclick="guardarPassword(event)">
                                    <i class="fas fa-save"></i>
                                    Guardar
                                </button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">
                                    <i class="fas fa-times"></i>
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>