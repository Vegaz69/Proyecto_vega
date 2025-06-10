<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?> // <-- CAMBIO: De 'contenido' a 'content' (si tu layout lo espera así)

<div class="container mt-5">
    <h2 class="mb-4">Editar Usuario: <?= esc($usuario['nombre']) ?></h2>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/usuarios/guardar') ?>" method="post">
        <?= csrf_field() ?>
        <input type="hidden" name="id_usuario" value="<?= esc($usuario['id_usuario']) ?>">

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre', $usuario['nombre']) ?>" required>
            <?php if (session('errors.nombre')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.nombre') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $usuario['email']) ?>" required>
            <?php if (session('errors.email')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.email') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña (dejar en blanco para no cambiar):</label>
            <input type="password" class="form-control" id="password" name="password">
            <?php if (session('errors.password')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.password') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="rol" class="form-label">Rol:</label>
            <select class="form-select" id="rol" name="rol" required>
                <?php 
                // Asegúrate de que $roles_posibles esté definido y sea un array en tu controlador
                // (Ya lo hemos ajustado en el UsuarioController para que sea ['admin', 'cliente'])
                if (isset($roles_posibles) && is_array($roles_posibles)) : 
                ?>
                    <?php foreach ($roles_posibles as $rol_cadena) : ?>
                        <option value="<?= esc($rol_cadena) ?>" 
                                <?= (old('rol', $usuario['rol']) == $rol_cadena) ? 'selected' : '' ?>>
                            <?php 
                                // Muestra el texto "Administrador" o "Cliente" basado en el valor 'admin' o 'cliente'
                                if ($rol_cadena === 'admin') {
                                    echo 'Administrador';
                                } elseif ($rol_cadena === 'cliente') {
                                    echo 'Cliente';
                                } else {
                                    echo esc($rol_cadena); // Fallback si hay un valor inesperado
                                }
                            ?>
                        </option>
                    <?php endforeach; ?>
                <?php else : ?>
                    <option value="">No hay opciones de rol disponibles</option>
                <?php endif; ?>
            </select>
            <?php if (session('errors.rol')) : // <-- AÑADIDO: Mostrar error de validación para 'rol' ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.rol') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" <?= (old('activo', $usuario['activo']) == 1) ? 'checked' : '' ?>>
            <label class="form-check-label" for="activo">Activo</label>
            <?php if (session('errors.activo')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.activo') ?>
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>