<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard Principal Usuario</h1>
                <p class="text-muted">Bienvenido <?= $_SESSION['nombre'] ?>, al sistema de quejas y sugerencias.</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php echo Utils::getBreadCrumbs(); ?>
                </ol>
            </div>
        </div><!-- /.row -->
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-thumbs-down"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mis Registros</span>
                        <span class="info-box-number">
                            <?= $this->getMiTotalRegistros($_SESSION['idusuario']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-spinner"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mis Pendientes</span>
                        <span class="info-box-number">
                            <?= $this->getMiTotalRegistrosPendientes($_SESSION['idusuario']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mis Atendidas</span>
                        <span class="info-box-number">
                            <?= $this->getMiTotalRegistrosAtendidos($_SESSION['idusuario']) ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-times"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Mis Rechazadas</span>
                        <span class="info-box-number">
                            <?= $this->getMiTotalRegistrosRechazados($_SESSION['idusuario']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Mis Últimas Quejas</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>ID Queja</th>
                                        <th>Usuario</th>
                                        <th>Departamento</th>
                                        <th>Asunto</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($this->getUltimasQuejasUsuario($_SESSION['idusuario']) as $queja) : ?>
                                        <tr>
                                            <td><a href="<?= BASE_URL ?>quejas/editar/<?= $queja->idqueja ?>"><?= $queja->idqueja ?></a></td>
                                            <td><?= $queja->usuario ?></td>
                                            <td><?= $queja->departamento ?></td>
                                            <td><?= $queja->asunto ?></td>
                                            <td>
                                                <?php if ($queja->estado == 'Pendiente') : ?>
                                                    <span class="badge badge-warning"><?= $queja->estado ?></span>
                                                <?php elseif ($queja->estado == 'Atendido') : ?>
                                                    <span class="badge badge-success"><?= $queja->estado ?></span>
                                                <?php elseif ($queja->estado == 'Rechazado') : ?>
                                                    <span class="badge badge-danger"><?= $queja->estado ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20"><?= $queja->fechacreacion ?></div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer clearfix">
                        <a href="<?= BASE_URL ?>quejas/crear" class="btn btn-sm btn-info float-left">Crear Nueva Queja</a>
                        <a href="<?= BASE_URL ?>quejas/misquejas" class="btn btn-sm btn-secondary float-right">Ver Mis Quejas</a>
                    </div>
                </div>
            </div>
        </div>



    </div>
</section>