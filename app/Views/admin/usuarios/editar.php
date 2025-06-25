<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h2 class="mb-4 text-center fw-bold"><i class="fas fa-user-edit me-2"></i> Editar Usuario: <?= esc($usuario['nombre']) ?></h2>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h5 class="card-title text-white mb-0">Información del Usuario</h5>
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
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/usuarios/guardar') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_usuario" value="<?= esc($usuario['id_usuario']) ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre', $usuario['nombre']) ?>" required <?= isset($disableFieldsForAdmin) && $disableFieldsForAdmin ? 'disabled' : '' ?>>
                        <?php if (session('errors.nombre')) : ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.nombre') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?= old('apellido', $usuario['apellido']) ?>" required <?= isset($disableFieldsForAdmin) && $disableFieldsForAdmin ? 'disabled' : '' ?>>
                        <?php if (session('errors.apellido')) : ?>
                            <div class="invalid-feedback d-block">
                                <?= session('errors.apellido') ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $usuario['email']) ?>" required <?= isset($disableFieldsForAdmin) && $disableFieldsForAdmin ? 'disabled' : '' ?>>
                <?php if (session('errors.email')) : ?>
                    <div class="invalid-feedback d-block">
                        <?= session('errors.email') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña (dejar en blanco para no cambiar):</label>
                <input type="password" class="form-control" id="password" name="password" <?= isset($disableFieldsForAdmin) && $disableFieldsForAdmin ? 'disabled' : '' ?>>
                <?php if (session('errors.password')) : ?>
                    <div class="invalid-feedback d-block">
                        <?= session('errors.password') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol:</label>
                <select class="form-select" id="rol" name="rol" required <?= isset($disableFieldsForAdmin) && $disableFieldsForAdmin ? 'disabled' : '' ?>>
                    <?php
                    if (isset($roles_posibles) && is_array($roles_posibles)) :
                    ?>
                        <?php foreach ($roles_posibles as $rol_cadena) : ?>
                            <option value="<?= esc($rol_cadena) ?>"
                                <?= (old('rol', $usuario['rol']) == $rol_cadena) ? 'selected' : '' ?>>
                                <?php
                                    if ($rol_cadena === 'admin') {
                                        echo 'Administrador';
                                    } elseif ($rol_cadena === 'cliente') {
                                        echo 'Cliente';
                                    } else {
                                        echo esc($rol_cadena);
                                    }
                                ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <option value="">No hay opciones de rol disponibles</option>
                    <?php endif; ?>
                </select>
                <?php if (session('errors.rol')) : ?>
                    <div class="invalid-feedback d-block">
                        <?= session('errors.rol') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" <?= (old('activo', $usuario['activo']) == 1) ? 'checked' : '' ?> <?= isset($disableFieldsForAdmin) && $disableFieldsForAdmin ? 'disabled' : '' ?>>
                <label class="form-check-label" for="activo">Activo</label>
                <?php if (session('errors.activo')) : ?>
                    <div class="invalid-feedback d-block">
                        <?= session('errors.activo') ?>
                    </div>
                <?php endif; ?>
            </div>

            <hr class="my-4">

            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary" <?= isset($disableFieldsForAdmin) && $disableFieldsForAdmin ? 'disabled' : '' ?>>
                    <i class="fas fa-save me-1"></i> Guardar Cambios
                </button>
                <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-secondary">
                    <i class="fas fa-times-circle me-1"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>