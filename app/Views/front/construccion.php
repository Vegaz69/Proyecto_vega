<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

   <div class="alert alert-warning text-center p-4">
        <h1>🚧 Página en Construcción 🚧</h1>
        <p>Estamos trabajando para habilitar esta funcionalidad pronto. ¡Gracias por tu paciencia!</p>
        <a href="<?= base_url('/') ?>" class="btn btn-primary mt-3">Volver a la Página Principal</a>
    </div>


<?= $this->endSection() ?>