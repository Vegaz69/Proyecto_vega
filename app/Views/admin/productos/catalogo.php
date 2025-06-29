<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container">
    <h2 class="mb-4 text-center fw-bold"><i class="fas fa-box-open me-2"></i> Gestión de Productos</h2>

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

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <div class="row mb-4 align-items-center">
                <div class="col-12 col-md-8 col-lg-9">
                    <form action="<?= base_url('admin/productos') ?>" method="get" class="border rounded shadow-sm p-2">
                        <div class="row g-2 align-items-center">
                            <div class="col-12 col-sm-6 col-md-5">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control form-control-sm" name="search"
                                        placeholder="Buscar producto por nombre o marca"
                                        value="<?= esc($search ?? '') ?>">
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <select class="form-select form-select-sm" name="categoria">
                                    <option value="">Todas las categorías</option>
                                    <?php foreach ($categorias as $cat) : ?>
                                    <option value="<?= esc($cat['id_categoria']) ?>" <?=(isset($selected_categoria) &&
                                        $selected_categoria==$cat['id_categoria']) ? 'selected' : '' ?>>
                                        <?= esc($cat['nombre']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-6 col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm w-100">Filtrar</button>
                                <?php if (!empty($search) || !empty($selected_categoria)) : ?>
                                <a href="<?= base_url('admin/productos') ?>"
                                    class="btn btn-outline-secondary btn-sm w-100">Limpiar</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-md-4 col-lg-3 text-md-end mt-3 mt-md-0">
                    <a href="<?= base_url('admin/productos/crear') ?>" class="btn btn-dark">
                        <i class="fas fa-plus"></i> Nuevo Producto
                    </a>
                </div>
            </div>

            <?php if (empty($productos)) : ?>
            <div class="alert alert-info" role="alert">
                No hay productos activos registrados que coincidan con los filtros.
            </div>
            <?php else : ?>

            <div class="d-none d-md-block">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th colspan="7" class="h5 py-2 text-center fw-bold">Productos Activos</th>
                            </tr>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="d-none d-sm-table-cell">Marca</th>
                                <th class="d-none d-sm-table-cell">Categoría</th>
                                <th class="d-none d-sm-table-cell">Precio</th>
                                <th>
                                    <a href="<?= base_url('admin/productos?orden_stock=' . ($orden_stock == 'asc' ? 'desc' : 'asc')) ?>"
                                        class="text-white text-decoration-none fw-bold d-inline-flex align-items-center gap-2">
                                        Stock
                                        <span style="font-size: 0.8rem;">
                                            <?= ($orden_stock == 'asc') ? '↑' : '↓' ?>
                                        </span>
                                    </a>
                                </th>
                                <th class="d-none d-sm-table-cell">Imagen</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productos as $producto) : ?>
                            <tr>
                                <td class="text-center">
                                    <?= esc($producto['nombre']) ?>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <?= esc($producto['marca']) ?>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <?= esc($producto['categoria_nombre']) ?>
                                </td>
                                <td class="d-none d-sm-table-cell">$
                                    <?= number_format($producto['precio'], 2, ',', '.') ?>
                                </td>
                                <td>
                                    <?php
                                                $stock = esc($producto['stock']);
                                                $claseStock = ($stock > 10) ? 'text-success' : (($stock > 3) ? 'text-warning' : 'text-danger');
                                            ?>
                                    <span class="<?= $claseStock ?> fw-bold">
                                        <?= $stock ?>
                                    </span>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <img src="<?= base_url('uploads/productos/' . esc($producto['imagen'])) ?>"
                                        alt="<?= esc($producto['nombre']) ?>"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>
                                    <div class="d-grid gap-1 d-md-flex">
                                        <a href="<?= base_url('admin/productos/editar/' . esc($producto['id_producto'])) ?>"
                                            class="btn btn-warning btn-sm px-2 py-1">
                                            <i class="fas fa-edit d-sm-none"></i> <span
                                                class="d-none d-sm-inline">Editar</span>
                                        </a>
                                        <a href="<?= base_url('admin/productos/eliminar/' . esc($producto['id_producto'])) ?>"
                                            class="btn btn-danger btn-sm px-2 py-1"
                                            onclick="return confirm('¿Seguro que quieres eliminar este producto?');">
                                            <i class="fas fa-trash-alt d-sm-none"></i> <span
                                                class="d-none d-sm-inline">Eliminar</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-md-none">
                <div class="row gy-3">
                    <?php foreach ($productos as $producto) : ?>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm p-3">
                            <div class="d-flex align-items-center">
                                <img src="<?= base_url('uploads/productos/' . esc($producto['imagen'])) ?>"
                                    alt="<?= esc($producto['nombre']) ?>" class="img-fluid rounded me-3"
                                    style="max-width: 60px;">
                                <div>
                                    <p class="fw-bold mb-1">
                                        <?= esc($producto['nombre']) ?>
                                    </p>
                                    <p class="text-muted mb-1">Marca:
                                        <?= esc($producto['marca']) ?>
                                    </p>
                                    <p class="text-muted mb-1">Categoría:
                                        <?= esc($producto['categoria_nombre']) ?>
                                    </p>
                                    <p class="text-muted mb-1">Precio: $
                                        <?= number_format($producto['precio'], 2, ',', '.') ?>
                                    </p>
                                    <p class="text-muted mb-1">Stock: <span class="<?= $claseStock ?> fw-bold">
                                            <?= esc($producto['stock']) ?>
                                        </span></p>
                                </div>
                            </div>
                            <div class="d-grid gap-1 d-md-flex">
                                <a href="<?= base_url('admin/productos/editar/' . esc($producto['id_producto'])) ?>"
                                    class="btn btn-warning btn-sm px-2 py-1">
                                    <i class="fas fa-edit d-sm-none"></i> <span class="d-none d-sm-inline">Editar</span>
                                </a>
                                <a href="<?= base_url('admin/productos/eliminar/' . esc($producto['id_producto'])) ?>"
                                    class="btn btn-danger btn-sm px-2 py-1"
                                    onclick="return confirm('¿Seguro que quieres eliminar este producto?');">
                                    <i class="fas fa-trash-alt d-sm-none"></i> <span
                                        class="d-none d-sm-inline">Eliminar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <?php if (isset($pager) && $pager && $pager->getPageCount() > 1) : ?>
                <?= $pager->links() ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <?php if (empty($productosEliminados)) : ?>
            <div class="alert alert-info mt-5" role="alert"> No hay productos desactivados.
            </div>
            <?php else : ?>
            <div class="table-responsive mt-5">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th colspan="4" class="h5 py-2 text-center fw-bold">Productos Desactivados</th>
                        </tr>
                        <tr>
                            <th class="text-center">Nombre</th>
                            <th class="d-none d-sm-table-cell">Marca</th>
                            <th class="d-none d-sm-table-cell">Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productosEliminados as $producto) : ?>
                        <tr>
                            <td class="text-center">
                                <?= esc($producto['nombre']) ?>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <?= esc($producto['marca']) ?>
                            </td>
                            <td class="d-none d-sm-table-cell">
                                <?= esc($producto['categoria_nombre'] ?? 'Sin Categoría') ?>
                            </td>
                            <td>
                                <a href="<?= base_url('admin/productos/restaurar/' . $producto['id_producto']) ?>"
                                    class="btn btn-success btn-sm"
                                    onclick="return confirm('¿Estás seguro de que quieres restaurar este producto?');">
                                    <span class="d-inline d-sm-none">
                                        <i class="fas fa-undo-alt"></i>
                                    </span>
                                    <span class="d-none d-sm-inline">
                                        <i class="fas fa-undo-alt"></i> Restaurar
                                    </span>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?= $this->endSection() ?>