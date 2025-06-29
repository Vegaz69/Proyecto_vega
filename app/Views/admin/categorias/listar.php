<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">
            <h2 class="mb-4 text-center fw-bold"><i class="fas fa-tags me-2"></i> Gestión de Categorías</h2>

            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
            <?php endif; ?>

            <div class="row mb-4 align-items-center">
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="p-3 bg-light rounded shadow-sm">
                        <form id="filterCategoriasForm" action="<?= base_url('admin/categorias') ?>" method="get"
                            class="d-flex flex-wrap align-items-end w-100">
                            <div class="me-3 mb-2 mb-md-0 flex-grow-1">
                                <label for="filtro_nombre_categoria" class="form-label visually-hidden">Nombre de
                                    Categoría</label>
                                <input type="text" class="form-control form-control-sm" id="filtro_nombre_categoria"
                                    name="nombre" placeholder="Buscar por Nombre de Categoría"
                                    value="<?= esc($filtro_nombre ?? '') ?>" title="Filtrar por Nombre de Categoría">
                            </div>

                            <div class="me-2 mb-2 mb-md-0">
                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search me-1"></i>
                                    Buscar </button>
                            </div>
                            <div class="mb-2 mb-md-0">
                                <a href="<?= base_url('admin/categorias') ?>" class="btn btn-secondary btn-sm"><i
                                        class="fas fa-redo me-1"></i> Limpiar Filtros</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-3 text-md-end mt-3 mt-md-0"> <a
                        href="<?= base_url('admin/categorias/crear') ?>" class="btn btn-dark">
                        <i class="fas fa-plus"></i> Nueva Categoría
                    </a>
                </div>
            </div>

            <?php if (!empty($categorias)): ?>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th colspan="2" class="h5 text-center py-2">Categorías Activas</th>
                        </tr>
                        <tr>
                            <th class="text-center">
                                <a href="<?= base_url('admin/categorias?orden=' . ($orden === 'asc' ? 'desc' : 'asc') . '&nombre=' . esc($filtro_nombre ?? '')) ?>"
                                    class="text-white text-decoration-none d-inline-flex align-items-center gap-2">
                                    Nombre
                                    <span style="font-size: 0.8rem;">
                                        <?= ($orden === 'asc') ? '↑' : '↓' ?>
                                    </span>
                                </a>
                            </th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td class="text-center">
                                <?= esc($categoria['nombre']) ?>
                            </td>
                            <td>
                                <div class="d-grid gap-1 d-md-flex">
                                    <a href="<?= base_url('admin/categorias/editar/' . esc($categoria['id_categoria'])) ?>"
                                        class="btn btn-warning btn-sm px-2 py-1">
                                        <i class="fas fa-edit d-sm-none"></i> <span
                                            class="d-none d-sm-inline">Editar</span>
                                    </a>
                                    <form
                                        action="<?= base_url('admin/categorias/eliminar/' . esc($categoria['id_categoria'])) ?>"
                                        method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-danger btn-sm px-2 py-1"
                                            onclick="return confirm('¿Estás seguro de desactivar esta categoría?');">
                                            <i class="fas fa-ban d-sm-none"></i> <span
                                                class="d-none d-sm-inline">Desactivar</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="alert alert-info">No hay categorías activas registradas que coincidan con el filtro.</div>
            <?php endif; ?>

            <?php if (!empty($categoriasEliminadas)): ?>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th colspan="2" class="h5 text-center py-2 fw-bold">Categorías Desactivadas</th>
                        </tr>
                        <tr>
                            <th class="text-center">
                                <a href="<?= base_url('admin/categorias?orden=' . ($orden === 'asc' ? 'desc' : 'asc') . '&nombre=' . esc($filtro_nombre ?? '')) ?>"
                                    class="text-white text-decoration-none d-inline-flex align-items-center gap-2">
                                    Nombre
                                    <span style="font-size: 0.8rem;">
                                        <?= ($orden === 'asc') ? '↑' : '↓' ?>
                                    </span>
                                </a>
                            </th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categoriasEliminadas as $categoria): ?>
                        <tr>
                            <td class="text-center">
                                <?= esc($categoria['nombre']) ?>
                            </td>
                            <td>
                                <div class="d-grid gap-1 d-md-flex">
                                    <a href="<?= base_url('admin/categorias/restaurar/' . esc($categoria['id_categoria'])) ?>"
                                        class="btn btn-success btn-sm px-2 py-1"
                                        onclick="return confirm('¿Estás seguro de restaurar esta categoría?');">
                                        <i class="fas fa-redo d-sm-none"></i> <span
                                            class="d-none d-sm-inline">Restaurar</span>
                                    </a>
                                </div>
                            </td>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="alert alert-info">No hay categorías desactivadas que coincidan con el filtro.</div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?= $this->endSection() ?>