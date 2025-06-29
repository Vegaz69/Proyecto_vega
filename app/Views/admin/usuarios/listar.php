<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="mb-4 text-center fw-bold"><i class="fas fa-users-cog me-2"></i> Gestión de Usuarios</h2>


    <div class="row mb-4 justify-content-center gap-2">
        <div class="col-auto">
            <a href="<?= base_url('admin/usuarios/crear') ?>" class="btn btn-dark">
                <i class="fas fa-user-plus"></i> Crear Nuevo Admin
            </a>
        </div>
        <div class="col-auto">
            <form method="get" class="d-flex flex-nowrap" role="search"> <input type="text" name="busqueda"
                    value="<?= esc($busqueda ?? '') ?>" class="form-control form-control-sm me-1"
                    placeholder="Buscar..." style="min-width: 150px;"> <button class="btn btn-outline-dark btn-sm"
                    type="submit">
                    <i class="fas fa-search"></i>
                </button>
                <?php if (!empty($busqueda)) : ?>
                <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-outline-secondary btn-sm ms-1 text-nowrap">
                    <i class="fas fa-times"></i> Limpiar Filtro
                </a>
                <?php endif; ?>
            </form>
        </div>
    </div>


    <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Errores de validación:</h4>
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
            <li>
                <?= esc($error) ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="d-none d-md-block">
                <?php if (empty($usuarios)) : ?>
                <div class="alert alert-info">No hay usuarios activos registrados.</div>
                <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th colspan="5" class="h5 py-2 text-center fw-bold">Usuarios Activos</th>
                            </tr>
                            <tr>
                                <th class="d-none d-sm-table-cell text-center">Nombre</th>
                                <th class="d-none d-sm-table-cell text-center">
                                    <a href="<?= base_url('admin/usuarios?orden_apellido=' . ($orden_apellido === 'asc' ? 'desc' : 'asc')) ?>"
                                        class="text-white text-decoration-none d-inline-flex align-items-center gap-2">
                                        Apellido
                                        <span style="font-size: 0.8rem;">
                                            <?= ($orden_apellido === 'asc') ? '↑' : '↓' ?>
                                        </span>
                                    </a>
                                </th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Rol</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario) : ?>
                            <tr>
                                <td class="d-none d-sm-table-cell text-center">
                                    <?= esc($usuario['nombre'] ?? '') ?>
                                </td>
                                <td class="d-none d-sm-table-cell text-center">
                                    <?= esc($usuario['apellido'] ?? '') ?>
                                </td>
                                <td class="text-center">
                                    <?= esc($usuario['email'] ?? '') ?>
                                </td>
                                <td class="text-center">
                                    <?= ($usuario['rol'] ?? '') === 'admin' ? 'Administrador' : (($usuario['rol'] ?? '') === 'cliente' ? 'Cliente' : 'Desconocido') ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-grid gap-1 d-md-flex justify-content-center"> <a
                                            href="<?= base_url('admin/usuarios/editar/' . esc($usuario['id_usuario'] ?? '')) ?>"
                                            class="btn btn-warning btn-sm px-2 py-1">
                                            <i class="fas fa-edit d-sm-none"></i> <span
                                                class="d-none d-sm-inline">Editar</span>
                                        </a>
                                        <a href="<?= base_url('admin/usuarios/desactivar/' . esc($usuario['id_usuario'] ?? '')) ?>"
                                            class="btn btn-danger btn-sm px-2 py-1"
                                            onclick="return confirm('¿Estás seguro de que quieres desactivar a este usuario?');">
                                            <i class="fas fa-user-slash d-sm-none"></i> <span
                                                class="d-none d-sm-inline">Desactivar</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            <div class="d-md-none">
                <h3 class="mt-4 mb-3">Usuarios Activos</h3>
                <div class="row gy-3">
                    <?php foreach ($usuarios as $usuario) : ?>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-3">
                            <p class="fw-bold mb-1">
                                <?= esc($usuario['email'] ?? '') ?>
                            </p>
                            <p class="text-muted mb-2">
                                <?= ($usuario['rol'] ?? '') === 'admin' ? 'Administrador' : (($usuario['rol'] ?? '') === 'cliente' ? 'Cliente' : 'Desconocido') ?>
                            </p>
                            <div class="d-grid gap-1">
                                <a href="<?= base_url('admin/usuarios/editar/' . esc($usuario['id_usuario'] ?? '')) ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="<?= base_url('admin/usuarios/desactivar/' . esc($usuario['id_usuario'] ?? '')) ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Estás seguro de que quieres desactivar a este usuario?');">
                                    <i class="fas fa-user-slash"></i> Desactivar
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="d-none d-md-block mt-5">
                <?php if (empty($usuariosInactivos)) : ?>
                <div class="alert alert-info">No hay usuarios inactivos.</div>
                <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th colspan="5" class="h5 py-2 text-center fw-bold">Usuarios Inactivos</th>
                            </tr>
                            <tr>
                                <th class="d-none d-sm-table-cell text-center">Nombre</th>
                                <th class="d-none d-sm-table-cell text-center">
                                    <a href="<?= base_url('admin/usuarios?orden_apellido=' . ($orden_apellido === 'asc' ? 'desc' : 'asc')) ?>"
                                        class="text-white text-decoration-none d-inline-flex align-items-center gap-2">
                                        Apellido
                                        <span style="font-size: 0.8rem;">
                                            <?= ($orden_apellido === 'asc') ? '↑' : '↓' ?>
                                        </span>
                                    </a>
                                </th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Rol</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuariosInactivos as $usuario) : ?>
                            <tr>
                                <td class="d-none d-sm-table-cell text-center">
                                    <?= esc($usuario['nombre'] ?? '') ?>
                                </td>
                                <td class="d-none d-sm-table-cell text-center">
                                    <?= esc($usuario['apellido'] ?? '') ?>
                                </td>
                                <td class="text-center">
                                    <?= esc($usuario['email'] ?? '') ?>
                                </td>
                                <td class="text-center">
                                    <?= ($usuario['rol'] ?? '') === 'admin' ? 'Administrador' : (($usuario['rol'] ?? '') === 'cliente' ? 'Cliente' : 'Desconocido') ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-grid gap-1 d-md-flex justify-content-center"> <a
                                            href="<?= base_url('admin/usuarios/editar/' . esc($usuario['id_usuario'] ?? '')) ?>"
                                            class="btn btn-warning btn-sm px-2 py-1">
                                            <i class="fas fa-edit d-sm-none"></i> <span
                                                class="d-none d-sm-inline">Editar</span>
                                        </a>
                                        <a href="<?= base_url('admin/usuarios/activar/' . esc($usuario['id_usuario'] ?? '')) ?>"
                                            class="btn btn-success btn-sm px-2 py-1"
                                            onclick="return confirm('¿Estás seguro de que quieres activar a este usuario?');">
                                            <i class="fas fa-user-check d-sm-none"></i> <span
                                                class="d-none d-sm-inline">Activar</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            <div class="d-md-none mt-5">
                <?php if (empty($usuariosInactivos)) : ?>
                <div class="alert alert-info">No hay usuarios inactivos.</div>
                <?php else : ?>
                <div class="row gy-3">
                    <?php foreach ($usuariosInactivos as $usuario) : ?>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-3">
                            <p class="fw-bold mb-1">
                                <?= esc($usuario['email'] ?? '') ?>
                            </p>
                            <p class="text-muted mb-2">
                                <?= ($usuario['rol'] ?? '') === 'admin' ? 'Administrador' : (($usuario['rol'] ?? '') === 'cliente' ? 'Cliente' : 'Desconocido') ?>
                            </p>
                            <div class="d-grid gap-1">
                                <a href="<?= base_url('admin/usuarios/editar/' . esc($usuario['id_usuario'] ?? '')) ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="<?= base_url('admin/usuarios/activar/' . esc($usuario['id_usuario'] ?? '')) ?>"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('¿Estás seguro de que quieres activar a este usuario?');">
                                    <i class="fas fa-user-check"></i> Activar
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>