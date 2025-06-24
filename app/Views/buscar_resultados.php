<div class="container my-4">
    <h2 class="mb-4">Resultados de búsqueda para: "<?= esc($searchTerm ?? '') ?>"</h2>

    <?php if (!empty($mensaje)): ?>
        <p class="alert alert-info"><?= esc($mensaje) ?></p>
    <?php endif; ?>

    <?php if (empty($productos)): ?>
        <p class="alert alert-warning">No se encontraron productos que coincidan con tu búsqueda.</p>
    <?php else: ?>
        <div class="row">
            <?php foreach ($productos as $producto): ?>
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php
                        // Ruta de la imagen: Verifica si la imagen existe en 'uploads/productos' o usa un placeholder
                        $imagePath = 'uploads/productos/' . esc($producto['imagen']);
                        if (!empty($producto['imagen']) && file_exists(FCPATH . $imagePath)) {
                            $imageUrl = base_url($imagePath);
                        } else {
                            $imageUrl = base_url('assets/img/placeholder.png');
                        }
                        ?>
                        <img src="<?= $imageUrl ?>" class="card-img-top img-fluid" alt="<?= esc($producto['nombre']) ?>">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= esc($producto['nombre']) ?></h5>
                            <p class="card-text text-muted small"><?= esc($producto['marca'] ?? 'Marca Desconocida') ?></p>
                            <p class="card-text text-muted small">Categoría: <?= esc($producto['categoria_nombre'] ?? 'Sin Categoría') ?></p>
                            <p class="card-text fw-bold mt-auto">$<?= number_format($producto['precio'], 2, ',', '.') ?></p>
                            <a href="<?= base_url('producto/' . $producto['id_producto']) ?>" class="btn btn-primary mt-2">Ver Detalle</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-center mt-4">
        <?= $pager->links() ?? '' ?>
    </div>
</div>