<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<h2 class="mb-4 text-center fw-bold"><i class="fas fa-user-plus me-2"></i> Crear Nuevo Admin</h2>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6"> <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title text-white mb-0">Formulario de Nuevo Admin</h5>
                <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Volver al Listado
                </a>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('errors')) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= esc(session()->getFlashdata('success')) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('usuarios/guardar') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>"
                               id="nombre" name="nombre" value="<?= old('nombre') ?>" required>
                        <?php if (session('errors.nombre')) : ?>
                            <div class="invalid-feedback">
                                <?= session('errors.nombre') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido:</label>
                        <input type="text" class="form-control <?= session('errors.apellido') ? 'is-invalid' : '' ?>"
                               id="apellido" name="apellido" value="<?= old('apellido') ?>" required>
                        <?php if (session('errors.apellido')) : ?>
                            <div class="invalid-feedback">
                                <?= session('errors.apellido') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico:</label>
                        <input type="email" class="form-control <?= session('errors.email') ? 'is-invalid' : '' ?>"
                               id="email" name="email" value="<?= old('email') ?>" required>
                        <?php if (session('errors.email')) : ?>
                            <div class="invalid-feedback">
                                <?= session('errors.email') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>"
                               id="password" name="password" required>
                        <?php if (session('errors.password')) : ?>
                            <div class="invalid-feedback">
                                <?= session('errors.password') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol:</label>
                        <input type="text" class="form-control" value="Admin" readonly>
                        <input type="hidden" name="rol" value="admin">
                        <?php if (session('errors.rol')) : ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.rol') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1"
                               <?= (old('activo') == 1 || old('activo') === null) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="activo">Usuario Activo</label>
                        <?php if (session('errors.activo')) : ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.activo') ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Guardar Usuario
                        </button>
                        <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-secondary">
                            <i class="fas fa-times-circle me-1"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>