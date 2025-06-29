<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div class="container my-3">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('success')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row align-items-center mb-4">
        <div class="col-12 col-md-6 text-center text-md-start">
            <h4 class="mb-0">Explora Nuestro Catálogo</h4> </div>
        <div class="col-12 col-md-6 mt-3 mt-md-0 d-flex justify-content-center justify-content-md-end">
            <form method="GET" action="<?= base_url('catalogo') ?>" class="d-flex align-items-center flex-wrap justify-content-center">
                <div class="me-2 mb-2 mb-md-0">
                    <label for="categoria-select" class="form-label visually-hidden">Categoría</label>
                    <select name="categoria" id="categoria-select" class="form-select form-select-sm">
                        <option value="">Todas las Categorías</option>
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?= esc($categoria['id_categoria']) ?>" <?= (isset($selected_categoria) && $selected_categoria == $categoria['id_categoria']) ? 'selected' : '' ?>>
                                <?= esc($categoria['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="me-2 mb-2 mb-md-0">
                    <label for="orden-select" class="form-label visually-hidden">Ordenar por</label>
                    <select name="orden" id="orden-select" class="form-select form-select-sm">
                        <option value="">Ordenar por...</option>
                        <option value="nombre_asc" <?= (isset($orderBy) && $orderBy === 'nombre_asc') ? 'selected' : '' ?>>Nombre (A-Z)</option>
                        <option value="nombre_desc" <?= (isset($orderBy) && $orderBy === 'nombre_desc') ? 'selected' : '' ?>>Nombre (Z-A)</option>
                        <option value="precio_asc" <?= (isset($orderBy) && $orderBy === 'precio_asc') ? 'selected' : '' ?>>Precio (Menor a Mayor)</option>
                        <option value="precio_desc" <?= (isset($orderBy) && $orderBy === 'precio_desc') ? 'selected' : '' ?>>Precio (Mayor a Menor)</option>
                    </select>
                </div>
                <div class="me-2 mb-2 mb-md-0">
                    <button type="submit" class="btn btn-sm btn-primary">
                        <i class="fas fa-filter me-1"></i> Filtrar
                    </button>
                </div>
                <?php if (!empty($search_query_navbar) || !empty($selected_categoria) || !empty($orderBy)): ?>
                <div>
                    <a href="<?= base_url('catalogo') ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-times-circle me-1"></i> Limpiar
                    </a>
                </div>
                <?php endif; ?>

                <?php if (!empty($search_query_navbar)): ?>
                    <input type="hidden" name="search_query" value="<?= esc($search_query_navbar) ?>">
                <?php endif; ?>
            </form>
        </div>
    </div>
    <?php if (!empty($productos)): ?>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
            <?php foreach ($productos as $producto): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm product-card">
                        <a href="<?= base_url('productos/' . esc($producto['id_producto'])) ?>">
                            <img src="<?= base_url('uploads/productos/' . esc($producto['imagen'])) ?>" class="card-img-top product-img" alt="<?= esc($producto['nombre']) ?>">
                        </a>
                        <div class="card-body d-flex flex-column p-2">
                            <h5 class="card-title product-title mb-1">
                                <a href="<?= base_url('productos/' . esc($producto['id_producto'])) ?>" class="text-decoration-none text-dark text-truncate d-block">
                                    <?= esc($producto['nombre']) ?>
                                </a>
                            </h5>
                            <h6 class="text-primary product-price mb-2">$<?= number_format(esc($producto['precio']), 2, ',', '.') ?></h6>
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <?php if ($producto['stock'] > 0): ?>
                                    <span class="badge bg-success">En Stock</span>
                                    <a href="<?= base_url('productos/' . esc($producto['id_producto'])) ?>" class="btn btn-sm btn-primary product-detail-btn">Ver Detalles</a>
                                <?php else: ?>
                                    <span class="badge bg-danger">Sin Stock</span>
                                    <button class="btn btn-sm btn-secondary product-detail-btn" disabled>Ver Detalles</button>
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
            No se encontraron productos que coincidan con los criterios de búsqueda.
        </div>
    <?php endif; ?>

    <style>
        .product-card {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            border-radius: 0.5rem; /* Bordes ligeramente redondeados */
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .product-img {
            width: 100%;
            height: 120px; /* Altura fija para todas las imágenes */
            object-fit: contain; /* Asegura que la imagen completa sea visible */
            padding: 8px; /* Espacio alrededor de la imagen */
        }
        .product-title {
            font-size: 0.9rem; /* Tamaño de fuente para el título */
            font-weight: 600; /* Un poco más de peso */
            min-height: 2.7em; /* Altura mínima para 2 líneas de texto */
            line-height: 1.35;
        }
        .product-price {
            font-size: 1rem; /* Tamaño de fuente para el precio */
            font-weight: 700;
        }
        .product-detail-btn {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }
        /* Ajuste para el texto truncado si es necesario en otras resoluciones */
        .text-truncate-2-lines {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Estilos minimalistas para el espaciado del paginador */
        .d-flex.justify-content-center.mt-4 nav ul {
            list-style: none; /* Quita los puntos de la lista */
            padding: 0;
            margin: 0;
            display: flex; /* Para que los elementos se muestren en línea */
            flex-wrap: wrap; /* Permite que los elementos se envuelvan */
            justify-content: center; /* Centra los elementos */
        }

        .d-flex.justify-content-center.mt-4 nav ul li {
            margin: 0 8px; /* ¡Más espaciado horizontal para que se separen bien! */
        }

        .d-flex.justify-content-center.mt-4 nav ul li a,
        .d-flex.justify-content->center.mt-4 nav ul li span {
            text-decoration: none; /* Asegura que no tengan subrayado */
            color: #007bff; /* Color azul de enlace por defecto */
            font-weight: normal; /* Asegura peso de fuente normal */
            padding: 4px 0; /* Un poco de padding para que sea clicable */
        }

        .d-flex.justify-content-center.mt-4 nav ul li.active a,
        .d-flex.justify-content-center.mt-4 nav ul li.current span {
            font-weight: bold; /* La página activa en negrita */
            color: #0d6efd; /* Color azul de Bootstrap para el activo */
            text-decoration: underline; /* Subraya solo el número activo como en tu imagen */
        }
    </style>

    <script>
        // Script para ocultar mensajes de éxito automáticamente
        document.addEventListener('DOMContentLoaded', function() {
            var successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(function() {
                    var bsAlert = new bootstrap.Alert(successAlert);
                    bsAlert.close();
                }, 3000); // El mensaje se cerrará después de 3 segundos
            }
        });
    </script>

</div>

<?= $this->endSection() ?>