<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Vista de Queja, Reclamo o Sugerencia</h1>
                <input type="hidden" name="idqueja" id="idqueja" value="<?= $this->queja->idqueja; ?>">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    Queja N°: <strong><?= $this->queja->idqueja; ?></strong>
                </ol>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Asunto: <?= $this->queja->asunto; ?></h3>
                        <?php if ($this->queja->estado == 'Pendiente') : ?>
                            <span class="badge badge-warning float-right"><?= $this->queja->estado; ?></span>
                        <?php elseif ($this->queja->estado == 'Atendido') : ?>
                            <span class="badge badge-success float-right"><?= $this->queja->estado; ?></span>
                        <?php elseif ($this->queja->estado == 'Rechazado') : ?>
                            <span class="badge badge-danger float-right"><?= $this->queja->estado; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="nombre">Quien registra</label>
                                        <input type="text" name="nombre" class="form-control" id="nombre" value="<?= isset($this->queja) && is_object($this->queja) ? $this->queja->nombrecompleto : $_SESSION['nombre']; ?>" readonly required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Departamento</label>
                                        <input type="text" name="departamento" class="form-control" id="departamento" value="<?= isset($this->queja) && is_object($this->queja) ? $this->queja->departamento : $_SESSION['departamento']; ?>" readonly required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Fecha de Creación</label>
                                        <input type="text" name="fechacreacion" class="form-control" id="fechacreacion" value="<?= isset($this->queja) && is_object($this->queja) ? $this->queja->fechacreacion : date('Y-m-d H:i:s'); ?>" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Tipo de Queja, Reclamo o Sugerencia</label>
                                        <input type="text" name="categoria" class="form-control" id="categoria" value="<?= isset($this->queja) && is_object($this->queja) ? $this->queja->categoria : ''; ?>" readonly required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Turno</label>
                                        <input type="text" name="turno" class="form-control" id="turno" value="<?= isset($this->queja) && is_object($this->queja) ? $this->queja->turno : ''; ?>" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <textarea name="descripcion" class="form-control" id="descripcion" rows="3" placeholder="Ingrese la descripción de la queja, reclamo o sugerencia" required readonly><?= isset($this->queja) && is_object($this->queja) ? $this->queja->descripcion : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Comentarios</h3>
                        <span class="float-right" id="contadorComentarios"></span>
                    </div>
                    <div class="card-body card-comments" id="comentarios">
                    </div>
                    <div class="card-footer">
                        <form action="#" method="post" id="formComentario">
                            <div class="form-group">
                                <textarea name="comentario" class="form-control form-control-sm" placeholder="Escriba un comentario..." id="comentario" rows="2" required></textarea>
                            </div>
                            <div class="float-right">
                                <button class="btn btn-primary btn-sm" onclick="comentar(event)">Comentar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Archivos Adjuntos</h3>
                    </div>
                    <div class="card-body" id="archivos">
                    </div>
                    <div class="card-footer">
                        <form action="#" method="post" id="formArchivo">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="archivo" name="archivo" required>
                                    <label class="custom-file-label" for="archivo">Seleccionar Archivo</label>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" onclick="subirArchivo(event)">Subir</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if (isset($_SESSION['idrol']) && $_SESSION['idrol'] == 1 && $this->queja->estado == 'Pendiente') : ?>
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Panel de Control Administrativo</h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <a href="<?= BASE_URL ?>quejas/atender&idqueja=<?= $this->queja->idqueja; ?>" class="btn btn-success btn-block">Atender</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <a href="<?= BASE_URL ?>quejas/rechazar&idqueja=<?= $this->queja->idqueja; ?>" class="btn btn-danger btn-block">Rechazar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>