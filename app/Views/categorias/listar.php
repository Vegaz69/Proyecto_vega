<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container pt-4"> 
    <h2>Gestión de Categorías</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Categorías Activas</h3>
        <a href="<?= base_url('admin/categorias/crear') ?>" class="btn btn-dark">
            <i class="fas fa-plus"></i> Nueva Categoría
        </a>
    </div>

    <?php if (!empty($categorias)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark"> <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias as $categoria): ?>
                        <tr>
                            <td><?= esc($categoria['id_categoria']) ?></td>
                            <td><?= esc($categoria['nombre']) ?></td>
                            <td>
                                <a href="<?= base_url('admin/categorias/editar/' . esc($categoria['id_categoria'])) ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="<?= base_url('admin/categorias/eliminar/' . esc($categoria['id_categoria'])) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de desactivar esta categoría?');">Desactivar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No hay categorías activas registradas.</div>
    <?php endif; ?>

    <h3 class="mt-5">Categorías Desactivadas</h3>
    <?php if (!empty($categoriasEliminadas)): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark"> <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categoriasEliminadas as $categoria): ?>
                        <tr>
                            <td><?= esc($categoria['id_categoria']) ?></td>
                            <td><?= esc($categoria['nombre']) ?></td>
                            <td>
                                <a href="<?= base_url('admin/categorias/restaurar/' . esc($categoria['id_categoria'])) ?>" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de restaurar esta categoría?');">Restaurar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No hay categorías desactivadas.</div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>