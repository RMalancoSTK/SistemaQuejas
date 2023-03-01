<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Mis Quejas, Reclamos o Sugerencias</h1>
                <input type="hidden" id="idusuario" value="<?= $_SESSION['idusuario']; ?>">
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
                <div class="card-body">
                    <table id="tableMisQuejas" class="table table-bordered table-striped table-sm" aria-describedby="tableMisQuejas_info" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Fecha</th>
                                <th>Quien registra</th>
                                <th>Departamento</th>
                                <th>Tipo de Queja, Reclamo o Sugerencia</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Fecha</th>
                                <th>Quien registra</th>
                                <th>Departamento</th>
                                <th>Tipo de Queja, Reclamo o Sugerencia</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>