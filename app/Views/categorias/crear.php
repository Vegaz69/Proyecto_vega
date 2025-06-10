 <?= $this->extend('layouts/admin') ?>
 
<?= $this->section('content') ?>

<div class="container my-5">
    <h2>Crear Nueva Categoría</h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/categorias/guardar') ?>" method="post">
        <?= csrf_field() ?> // Protección CSRF

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Categoría:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre') ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Categoría</button>
        <a href="<?= base_url('admin/categorias') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>