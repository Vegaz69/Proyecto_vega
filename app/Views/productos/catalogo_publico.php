<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div class="container my-5">
    <h1 class="mb-4">Nuestro Catálogo de Productos</h1>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('success')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="GET" action="<?= base_url('catalogo') ?>" class="mb-4">
        <div class="row gx-2 justify-content-start align-items-center">
            <div class="col-auto">
                <select name="categoria" class="form-select form-select-sm" style="width: 180px;">
                    <option value="">Todas las Categorías</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= esc($categoria['id_categoria']) ?>" <?= (isset($selected_categoria) && $selected_categoria == $categoria['id_categoria']) ? 'selected' : '' ?>>
                            <?= esc($categoria['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <select name="orden" class="form-select form-select-sm" style="width: 180px;">
                    <option value="">Ordenar por...</option>
                    <option value="nombre_asc" <?= (isset($orderBy) && $orderBy === 'nombre_asc') ? 'selected' : '' ?>>Nombre (A-Z)</option>
                    <option value="nombre_desc" <?= (isset($orderBy) && $orderBy === 'nombre_desc') ? 'selected' : '' ?>>Nombre (Z-A)</option>
                    <option value="precio_asc" <?= (isset($orderBy) && $orderBy === 'precio_asc') ? 'selected' : '' ?>>Precio (Menor a Mayor)</option>
                    <option value="precio_desc" <?= (isset($orderBy) && $orderBy === 'precio_desc') ? 'selected' : '' ?>>Precio (Mayor a Menor)</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-primary">Aplicar Filtros</button>
            </div>
            <?php if (!empty($search_query_navbar) || !empty($selected_categoria) || !empty($orderBy)): ?>
            <div class="col-auto">
                <a href="<?= base_url('catalogo') ?>" class="btn btn-sm btn-outline-secondary">Limpiar Filtros</a>
            </div>
            <?php endif; ?>

            <?php if (!empty($search_query_navbar)): ?>
                <input type="hidden" name="search_query" value="<?= esc($search_query_navbar) ?>">
            <?php endif; ?>
        </div>
    </form>


    <?php if (!empty($productos)): ?>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-2">
            <?php foreach ($productos as $producto): ?>
                <div class="col">
                    <div class="card shadow-sm" style="max-width: 180px; min-height: 280px; padding: 8px;">
                        <a href="<?= base_url('productos/' . esc($producto['id_producto'])) ?>">
                            <img src="<?= base_url('uploads/productos/' . esc($producto['imagen'])) ?>" class="card-img-top" alt="<?= esc($producto['nombre']) ?>" style="height: 100px; object-fit: cover;">
                        </a>
                        <div class="card-body" style="padding: 6px;">
                            <h5 class="card-title" style="font-size: 0.85rem;">
                                <a href="<?= base_url('productos/' . esc($producto['id_producto'])) ?>" class="text-decoration-none text-dark text-truncate d-block">
                                    <?= esc($producto['nombre']) ?>
                                </a>
                            </h5>
                            <p class="card-text text-muted mb-1" style="font-size: 0.75rem;">Marca: <?= esc($producto['marca']) ?></p>
                            <p class="card-text text-muted mb-2" style="font-size: 0.75rem;">Categoría: <?= esc($producto['categoria_nombre'] ?? 'N/A') ?></p>
                            <h6 class="text-primary mb-2" style="font-size: 0.85rem;">$<?= number_format(esc($producto['precio']), 2, ',', '.') ?></h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <?php if ($producto['stock'] > 0): ?>
                                    <span class="badge bg-success">En Stock</span>
                                    <a href="<?= base_url('productos/' . esc($producto['id_producto'])) ?>" class="btn btn-sm btn-primary" style="font-size: 0.7rem;">Ver Detalles</a>
                                <?php else: ?>
                                    <span class="badge bg-danger">Sin Stock</span>
                                    <button class="btn btn-sm btn-secondary" style="font-size: 0.7rem;" disabled>Ver Detalles</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="d-flex justify-content-center mt-4">
            <?= $pager->links() ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            No hay productos disponibles que coincidan con los filtros.
        </div>
    <?php endif; ?>

    <script>
        setTimeout(function() {
            var mensaje = document.querySelector('.alert-success');
            if (mensaje) {
                mensaje.classList.remove('fade'); // Asegura que 'fade' esté si fue removido en la carga
                mensaje.classList.add('show');    // Fuerza a que se muestre antes de desaparecer si no lo hace
                setTimeout(function() {
                    mensaje.remove();
                }, 150);
            }
        }, 3000); // 3 segundos antes de empezar a desaparecer
    </script>

</div>

<?= $this->endSection() ?>