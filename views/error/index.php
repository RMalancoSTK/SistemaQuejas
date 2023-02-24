<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Error 404</h1>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
            <h3><i class="fas fa-exclamation-triangle text-warning"></i> <?= $this->getError404(); ?></h3>
            <p>
                Favor de verificar la URL o contactar al administrador.
                <a href="<?= BASE_URL; ?>">Regresar al inicio</a>
            </p>
        </div>
    </div>
</section>