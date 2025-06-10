<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div class="container my-5">
    <?php if (session()->getFlashdata('success_add_to_cart')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('success_add_to_cart')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error_add_to_cart')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('error_add_to_cart')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($producto)): ?>
        <div class="row">
            <div class="col-md-6 mb-4">
                <?php if (!empty($producto['imagen'])): ?>
                    <img src="<?= base_url('uploads/productos/' . esc($producto['imagen'])) ?>" class="img-fluid rounded shadow-sm" alt="<?= esc($producto['nombre']) ?>">
                <?php else: ?>
                    <img src="<?= base_url('assets/img/placeholder.png') ?>" class="img-fluid rounded shadow-sm" alt="Imagen no disponible">
                <?php endif; ?>
                </div>

            <div class="col-md-6 mb-4">
                <h1 class="display-5 fw-bold text-dark mb-3"><?= esc($producto['nombre']) ?></h1>
                <p class="lead text-muted mb-2">Marca: <span class="fw-semibold"><?= esc($producto['marca']) ?></span></p>
                <p class="lead text-muted mb-4">Categoría: <span class="fw-semibold"><?= esc($producto['categoria_nombre']) ?></span></p>

                <h2 class="text-primary mb-3">$<?= number_format(esc($producto['precio']), 2, ',', '.') ?></h2>

                <div class="mb-4">
                    <p class="fw-bold mb-2">Descripción:</p>
                    <p class="text-muted"><?= nl2br(esc($producto['descripcion'] ?? 'No hay descripción disponible para este producto.')) ?></p>
                </div>

                <?php if (!empty($producto['especificaciones'])): ?>
                <div class="mb-4">
                    <p class="fw-bold mb-2">Especificaciones Técnicas:</p>
                    <div class="text-muted">
                        <?= nl2br(esc($producto['especificaciones'])) ?>
                    </div>
                </div>
                <?php endif; ?>
                <div class="d-flex align-items-center mb-4">
                    <p class="me-3 mb-0 fw-bold">Stock:</p>
                    <?php if ($producto['stock'] > 0): ?>
                        <span class="badge bg-success fs-5"><?= esc($producto['stock']) ?> en stock</span>
                        <?php if ($producto['stock'] <= 5): // Mensaje de stock bajo, puedes ajustar el número ?>
                            <span class="ms-2 text-warning fw-bold"><i class="fas fa-exclamation-triangle"></i> ¡Pocas unidades!</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="badge bg-danger fs-5">Sin stock</span>
                    <?php endif; ?>
                </div>

                <?php if ($producto['stock'] > 0): ?>
                    <form action="<?= base_url('carrito/agregar') ?>" method="post" class="mb-4">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_producto" value="<?= esc($producto['id_producto']) ?>">
                        <input type="hidden" name="precio_unitario" value="<?= esc($producto['precio']) ?>">
                        <input type="hidden" name="nombre_producto" value="<?= esc($producto['nombre']) ?>">
                        <?php // Si tuvieras una imagen principal a pasar al carrito
                              // <input type="hidden" name="imagen_producto" value="<?= esc($producto['imagen']) ? >"> ?>

                        <div class="d-flex align-items-center mb-3">
                            <label for="cantidad" class="form-label me-3 mb-0 fw-bold">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" value="1" min="1" max="<?= esc($producto['stock']) ?>" style="width: 80px;">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-shopping-cart me-2"></i>Añadir al Carrito</button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-secondary btn-lg" disabled><i class="fas fa-box-open me-2"></i>Fuera de Stock</button>
                <?php endif; ?>

                <hr class="my-4">
                <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Catálogo
                </a>
            </div>
        </div>

        <?php // No se incluye la sección de "Productos Relacionados" ?>

    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            <h4 class="alert-heading">Producto no encontrado</h4>
            <p>Lo sentimos, el producto que buscas no existe o no está disponible.</p>
            <a href="<?= base_url('catalogo') ?>" class="btn btn-warning mt-3">Volver al Catálogo</a>
        </div>
    <?php endif; ?>
</div>

<script>
    // Script para desaparecer las alertas de flashdata
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            var successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                successAlert.classList.remove('show');
                successAlert.classList.add('fade');
                setTimeout(function() {
                    successAlert.remove();
                }, 150);
            }

            var errorAlert = document.querySelector('.alert-danger');
            if (errorAlert) {
                errorAlert.classList.remove('show');
                errorAlert.classList.add('fade');
                setTimeout(function() {
                    errorAlert.remove();
                }, 150);
            }
        }, 3000); // 3 segundos antes de empezar a desaparecer
    });
</script>

<?= $this->endSection() ?>