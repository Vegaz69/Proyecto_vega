<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <h2 class="mb-4">Gestión de Usuarios</h2>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <h3 class="mt-4">Usuarios Activos</h3>
    <?php if (empty($usuarios)) : ?>
        <div class="alert alert-info" role="alert">
            No hay usuarios activos registrados.
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <tr>
                            <td><?= $usuario['id_usuario'] ?></td>
                            <td><?= esc($usuario['nombre']) ?></td>
                            <td><?= esc($usuario['email']) ?></td>
                            <td>
                                <?php 
                                    if ($usuario['rol'] === 'admin') {
                                        echo 'Administrador';
                                    } elseif ($usuario['rol'] === 'cliente') {
                                        echo 'Cliente';
                                    } else {
                                        echo 'Desconocido';
                                    }
                                ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/usuarios/editar/' . $usuario['id_usuario']) ?>" class="btn btn-warning btn-sm me-2">Editar</a>
                                <a href="<?= base_url('admin/usuarios/desactivar/' . $usuario['id_usuario']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres desactivar a este usuario?');">Desactivar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <h3 class="mt-5">Usuarios Inactivos</h3>
    <?php if (empty($usuariosInactivos)) : ?>
        <div class="alert alert-info" role="alert">
            No hay usuarios inactivos.
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuariosInactivos as $usuario) : ?>
                        <tr>
                            <td><?= $usuario['id_usuario'] ?></td>
                            <td><?= esc($usuario['nombre']) ?></td>
                            <td><?= esc($usuario['email']) ?></td>
                            <td>
                                <?php 
                                    if ($usuario['rol'] === 'admin') {
                                        echo 'Administrador';
                                    } elseif ($usuario['rol'] === 'cliente') {
                                        echo 'Cliente';
                                    } else {
                                        echo 'Desconocido';
                                    }
                                ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/usuarios/editar/' . $usuario['id_usuario']) ?>" class="btn btn-warning btn-sm me-2">Editar</a>
                                <a href="<?= base_url('admin/usuarios/activar/' . $usuario['id_usuario']) ?>" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de que quieres activar a este usuario?');">Activar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>