<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <?php echo Utils::getBreadCrumbs(); ?>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<section class="content">
    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><i class="fas fa-thumbs-down"></i></span>
                    <div class="info-box-content">
                        <!-- Total de quejas registradas -->
                        <span class="info-box-text">Registradas</span>
                        <span class="info-box-number">
                            <?= $this->getTotalQuejas(); ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-spinner"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pendientes</span>
                        <span class="info-box-number">
                            <?= $this->getTotalQuejasPendientes(); ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Atendidas</span>
                        <span class="info-box-number">
                            <?= $this->getTotalQuejasAtendidas(); ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-times"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Rechazadas</span>
                        <span class="info-box-number">
                            <?= $this->getTotalQuejasRechazadas(); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Reporte Mensual</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="text-center">
                                    <strong>Quejas: <?= $this->primerdiadelmesactual; ?> - <?= $this->ultimodiadelmesactual; ?></strong>
                                    <input type="hidden" id="primerdiadelmesactual" value="<?= $this->primerdiadelmesactual; ?>">
                                    <input type="hidden" id="ultimodiadelmesactual" value="<?= $this->ultimodiadelmesactual; ?>">
                                </p>

                                <div class="chart">
                                    <!-- Sales Chart Canvas -->
                                    <canvas id="salesChart" height="180" style="height: 180px;"></canvas>
                                </div>
                                <!-- /.chart-responsive -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-4">
                                <p class="text-center">
                                    <strong>Reporte Mensual</strong>
                                </p>
                                <div class="progress-group">
                                    Quejas Pendientes
                                    <span class="float-right"><b><?= $this->getTotalQuejasPendientes(); ?></b>/<?= $this->getTotalQuejas(); ?></span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-warning" style="width: <?= $this->getPorcentajeQuejasPendientes(); ?>%"></div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    <span class="progress-text">Quejas Atendidas</span>
                                    <span class="float-right"><b><?= $this->getTotalQuejasAtendidas(); ?></b>/<?= $this->getTotalQuejas(); ?></span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-success" style="width: <?= $this->getPorcentajeQuejasAtendidas(); ?>%"></div>
                                    </div>
                                </div>
                                <div class="progress-group">
                                    Quejas Rechazadas
                                    <span class="float-right"><b><?= $this->getTotalQuejasRechazadas(); ?></b>/<?= $this->getTotalQuejas(); ?></span>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-danger" style="width: <?= $this->getPorcentajeQuejasRechazadas(); ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 col-4">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-success"><?= $this->getPorcentajeQuejasPendientes(); ?>%</span>
                                    <h5 class="description-header"><?= $this->getTotalQuejasPendientes(); ?></h5>
                                    <span class="description-text">TOTAL DE QUEJAS PENDIENTES</span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-4">
                                <div class="description-block border-right">
                                    <span class="description-percentage text-warning"><?= $this->getPorcentajeQuejasAtendidas(); ?>%</span>
                                    <h5 class="description-header"><?= $this->getTotalQuejasAtendidas(); ?></h5>
                                    <span class="description-text">TOTAL DE QUEJAS ATENDIDAS</span>
                                </div>
                            </div>
                            <div class="col-sm-4 col-4">
                                <div class="description-block">
                                    <span class="description-percentage text-danger"><?= $this->getPorcentajeQuejasRechazadas(); ?>%</span>
                                    <h5 class="description-header"><?= $this->getTotalQuejasRechazadas(); ?></h5>
                                    <span class="description-text">TOTAL DE QUEJAS RECHAZADAS</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- TABLE: LATEST ORDERS -->
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Últimas Quejas</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
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
                                    <?php foreach ($this->getUltimasQuejas() as $queja) : ?>
                                        <tr>
                                            <td><a href="<?= BASE_URL ?>quejas/ver&idqueja=<?= $queja->idqueja ?>"><?= $queja->idqueja ?></a></td>
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
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <a href="<?= BASE_URL ?>quejas/index" class="btn btn-sm btn-secondary float-right">Ver Todas las Quejas</a>
                    </div>
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
    </div>
    </div>
</section>