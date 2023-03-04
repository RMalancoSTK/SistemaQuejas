<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lista de Quejas</h1>
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
                        <h3 class="card-title">Tabla de Quejas, Reclamos o Sugerencias de los Usuarios</h3>
                    </div>
                    <div class="card-body">
                        <table id="tablaquejas" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Fecha</th>
                                    <th>Quien Registra</th>
                                    <th>Asunto</th>
                                    <th>Departamento</th>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->getQuejas() as $queja) : ?>
                                    <tr>
                                        <td><?= $queja->Id; ?></td>
                                        <td><?= $queja->Fecha; ?></td>
                                        <td><?= $queja->Quien_Registra; ?></td>
                                        <td><?= $queja->Asunto; ?></td>
                                        <td><?= $queja->Departamento; ?></td>
                                        <td><?= $queja->Tipo; ?></td>
                                        <td>
                                            <?php if ($queja->Estado == 'Pendiente') : ?>
                                                <span class="badge badge-warning"><?= $queja->Estado; ?></span>
                                            <?php elseif ($queja->Estado == 'Atendido') : ?>
                                                <span class="badge badge-success"><?= $queja->Estado; ?></span>
                                            <?php elseif ($queja->Estado == 'Rechazado') : ?>
                                                <span class="badge badge-danger"><?= $queja->Estado; ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= BASE_URL ?>quejas/ver&idqueja=<?= $queja->Id; ?>" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>