<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <?php if (isset($this->queja) && is_object($this->queja)) : ?>
                    <h1 class="m-0">Editar Queja, Reclamo o Sugerencia</h1>
                    <?php $urlaction = BASE_URL . 'quejas/save&idqueja=' . $this->queja->idqueja; ?>
                <?php else : ?>
                    <h1 class="m-0">Nueva Queja, Reclamo o Sugerencia</h1>
                    <?php $urlaction = BASE_URL . 'quejas/save'; ?>
                <?php endif; ?>
            </div>
            <div class="col-sm-6">
                <?php if (isset($this->queja) && is_object($this->queja)) : ?>
                    <ol class="breadcrumb float-sm-right">
                        Edición de la queja, reclamo o sugerencia: <strong><?= $this->queja->idqueja; ?></strong>
                    </ol>
                <?php else : ?>
                    <ol class="breadcrumb float-sm-right">
                        <?= Utils::getBreadCrumbs(); ?>
                    </ol>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Datos de la Queja, Reclamo o Sugerencia</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" id="frmCrearQueja" action="<?= $urlaction; ?>" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <span class="text-danger">* </span>
                                        <label for="nombre">Quien registra</label>
                                        <input type="text" name="nombre" class="form-control" id="nombre" value="<?= isset($this->queja) && is_object($this->queja) ? $this->queja->nombrecompleto : $_SESSION['nombre']; ?>" readonly required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <span class="text-danger">* </span>
                                        <label>Departamento</label>
                                        <input type="text" name="departamento" class="form-control" id="departamento" value="<?= isset($this->queja) && is_object($this->queja) ? $this->queja->departamento : $_SESSION['departamento']; ?>" readonly required>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <span class="text-danger">* </span>
                                        <label>Fecha de Creación</label>
                                        <input type="text" name="fechacreacion" class="form-control" id="fechacreacion" value="<?= isset($this->queja) && is_object($this->queja) ? $this->queja->fechacreacion : date('Y-m-d H:i:s'); ?>" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <span class="text-danger">* </span>
                                        <label>Tipo de Queja, Reclamo o Sugerencia</label>
                                        <select name="idcategoria" class="form-control" id="idcategoria" required>
                                            <option value="">Seleccione un tipo de queja, reclamo o sugerencia</option>
                                            <?php foreach ($this->getCategorias() as $categoria) : ?>
                                                <?php if (isset($this->queja) && is_object($this->queja) && $this->queja->idcategoria == $categoria->idcategoria) : ?>
                                                    <option value="<?= $categoria->idcategoria; ?>" selected><?= $categoria->nombre; ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $categoria->idcategoria; ?>"><?= $categoria->nombre; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <span class="text-danger">* </span>
                                        <label>Turno</label>
                                        <select name="idturno" class="form-control" id="idturno" required>
                                            <option value="">Seleccione un turno</option>
                                            <?php foreach ($this->getTurnos() as $turno) : ?>
                                                <?php if (isset($this->queja) && is_object($this->queja) && $this->queja->idturno == $turno->idturno) : ?>
                                                    <option value="<?= $turno->idturno; ?>" selected><?= $turno->nombre; ?></option>
                                                <?php else : ?>
                                                    <option value="<?= $turno->idturno; ?>"><?= $turno->nombre; ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <span class="text-danger">* </span>
                                        <label>Asunto</label>
                                        <input type="text" name="asunto" class="form-control" id="asunto" placeholder="Ingrese el asunto de la queja, reclamo o sugerencia" required value="<?= isset($this->queja) && is_object($this->queja) ? $this->queja->asunto : ''; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <span class="text-danger">* </span>
                                        <label>Descripción</label>
                                        <textarea name="descripcion" class="form-control" id="descripcion" rows="3" placeholder="Ingrese la descripción de la queja, reclamo o sugerencia" required><?= isset($this->queja) && is_object($this->queja) ? $this->queja->descripcion : ''; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php if (!isset($this->queja) && !is_object($this->queja)) : ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="archivo">
                                                <i class="fas fa-paperclip"></i>
                                                Adjuntar archivo
                                                <span class="text-muted"> Opcional (Tamaño máximo 2MB)</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="archivo" class="custom-file-input" id="archivo">
                                                    <label class="custom-file-label" for="archivo">Seleccione un archivo</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>