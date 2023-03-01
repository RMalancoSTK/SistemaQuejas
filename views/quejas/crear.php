<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Nueva Queja, Reclamo o Sugerencia</h1>
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
            <div class="card card-warning col-md-12">
                <div class="card-header">
                    <h3 class="card-title">Datos de la Queja, Reclamo o Sugerencia</h3>
                </div>
                <div class="card-body">
                    <form method="post" id="frmCrearQueja" action="<?= BASE_URL; ?>quejas/save" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span class="text-danger">* </span>
                                    <label for="nombre">Quien registra</label>
                                    <input type="text" name="nombre" class="form-control" id="nombre" value="<?= $_SESSION['nombre']; ?>" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span class="text-danger">* </span>
                                    <label>Departamento</label>
                                    <input type="text" name="departamento" class="form-control" id="departamento" value="<?= $_SESSION['departamento']; ?>" readonly required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <span class="text-danger">* </span>
                                    <label>Fecha de Creación</label>
                                    <input type="text" name="fechacreacion" class="form-control" id="fechacreacion" value="<?= date('Y-m-d H:i:s'); ?>" readonly required>
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
                                            <option value="<?= $categoria->idcategoria; ?>"><?= $categoria->nombre; ?></option>
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
                                            <option value="<?= $turno->idturno; ?>"><?= $turno->nombre; ?></option>
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
                                    <input type="text" name="asunto" class="form-control" id="asunto" placeholder="Ingrese el asunto de la queja, reclamo o sugerencia" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <span class="text-danger">* </span>
                                    <label>Descripción</label>
                                    <textarea name="descripcion" class="form-control" id="descripcion" rows="3" placeholder="Ingrese la descripción de la queja, reclamo o sugerencia" required></textarea>
                                </div>
                            </div>
                        </div>
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
</section>