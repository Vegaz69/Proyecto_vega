<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <h2 class="mb-4">Gestión de Productos</h2>

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

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Productos Activos</h3>
        <a href="<?= base_url('admin/productos/crear') ?>" class="btn btn-dark">
            <i class="fas fa-plus"></i> Nuevo Producto
        </a>
    </div>

    <form action="<?= base_url('admin/productos') ?>" method="get" class="mb-4 p-3 border rounded bg-light">
        <div class="row g-3">
            <div class="col-md-5">
                <label for="search" class="form-label visually-hidden">Buscar</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Buscar por nombre o marca" value="<?= esc($search ?? '') ?>">
            </div>
            <div class="col-md-4">
                <label for="categoria" class="form-label visually-hidden">Categoría</label>
                <select class="form-select" id="categoria" name="categoria">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categorias as $cat) : ?>
                        <option value="<?= esc($cat['id_categoria']) ?>" <?= ((isset($selected_categoria) && $selected_categoria == $cat['id_categoria'])) ? 'selected' : '' ?>>
                            <?= esc($cat['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Aplicar Filtro</button>
            </div>
        </div>
        <?php if (isset($search) && !empty($search) || isset($selected_categoria) && !empty($selected_categoria)) : ?>
            <div class="mt-3 text-end">
                <a href="<?= base_url('admin/productos') ?>" class="btn btn-outline-secondary btn-sm">Limpiar Filtros</a>
            </div>
        <?php endif; ?>
    </form>
    <?php if (empty($productos)) : ?>
        <div class="alert alert-info" role="alert">
            No hay productos activos registrados que coincidan con los filtros.
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) : ?>
                        <tr>
                            <td><?= $producto['id_producto'] ?></td>
                            <td><?= esc($producto['nombre']) ?></td>
                            <td><?= esc($producto['marca']) ?></td>
                            <td><?= esc($producto['categoria_nombre'] ?? 'Sin Categoría') ?></td>
                            <td>$<?= number_format(esc($producto['precio']), 2, ',', '.') ?></td>
                            <td><?= esc($producto['stock']) ?></td>
                            <td>
                                <?php if (!empty($producto['imagen'])) : ?>
                                    <img src="<?= base_url('uploads/productos/' . $producto['imagen']) ?>" alt="<?= esc($producto['nombre']) ?>" style="width: 50px; height: 50px; object-fit: cover;">
                                <?php else : ?>
                                    <small>Sin imagen</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/productos/editar/' . $producto['id_producto']) ?>" class="btn btn-warning btn-sm me-2">Editar</a>
                                <a href="<?= base_url('admin/productos/eliminar/' . $producto['id_producto']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres desactivar este producto?');">Desactivar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            <?php 
            // Verifica que $pager esté definido, no sea null y que tenga más de una página de resultados
            if (isset($pager) && $pager && $pager->getPageCount() > 1) : ?>
                <?= $pager->links() ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <h3 class="mt-5">Productos Desactivados</h3>
    <?php if (empty($productosEliminados)) : ?>
        <div class="alert alert-info" role="alert">
            No hay productos desactivados.
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Categoría</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productosEliminados as $producto) : ?>
                        <tr>
                            <td><?= $producto['id_producto'] ?></td>
                            <td><?= esc($producto['nombre']) ?></td>
                            <td><?= esc($producto['marca']) ?></td>
                            <td><?= esc($producto['categoria_nombre'] ?? 'Sin Categoría') ?></td>
                            <td>
                                <a href="<?= base_url('admin/productos/restaurar/' . $producto['id_producto']) ?>" class="btn btn-success btn-sm" onclick="return confirm('¿Estás seguro de que quieres restaurar este producto?');">Restaurar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>