<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h2 class="mb-4 text-center fw-bold"><i class="fas fa-plus-square me-2"></i> Crear Nueva Categoría</h2>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title text-white mb-0">Formulario de Nueva Categoría</h5>
                <a href="<?= base_url('admin/categorias') ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Volver al Listado
                </a>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('errors')) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li>
                            <?= esc($error) ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php endif; ?>

                <form action="<?= base_url('admin/categorias/guardar') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Categoría:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre') ?>"
                            required>
                        <?php if (session('errors.nombre')) : ?>
                        <div class="invalid-feedback d-block">
                            <?= session('errors.nombre') ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Guardar Categoría
                        </button>
                        <a href="<?= base_url('admin/categorias') ?>" class="btn btn-secondary">
                            <i class="fas fa-times-circle me-1"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>