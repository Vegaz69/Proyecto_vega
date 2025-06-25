<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div class="container my-3">
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
                <h2 class="text-primary mb-3">$<?= number_format(esc($producto['precio']), 2, ',', '.') ?></h2>

                <div class="d-flex align-items-center mb-4">
                    <p class="me-3 mb-0 fw-bold">Stock:</p>
                    <?php if ($producto['stock'] > 0): ?>
                        <span id="product-stock-badge" class="badge bg-success fs-5"><?= esc($producto['stock']) ?> en stock</span>
                        <?php if ($producto['stock'] <= 5): ?>
                            <span id="low-stock-message" class="ms-2 text-warning fw-bold">
                                <i class="fas fa-exclamation-triangle"></i> ¡Pocas unidades!
                            </span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span id="product-stock-badge" class="badge bg-danger fs-5">Sin stock</span>
                    <?php endif; ?>
                </div>

                <?php if ($producto['stock'] > 0): ?>
                    <form id="addToCartForm" action="<?= base_url('carrito/agregar') ?>" method="post" class="mb-4">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_producto" value="<?= esc($producto['id_producto']) ?>">
                        <input type="hidden" name="precio_unitario" value="<?= esc($producto['precio']) ?>">
                        <input type="hidden" name="nombre_producto" value="<?= esc($producto['nombre']) ?>">

                        <div class="d-flex align-items-center mb-3">
                            <label for="cantidad" class="form-label me-3 mb-0 fw-bold">Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" value="1" min="1" max="<?= esc($producto['stock']) ?>" style="width: 80px;">
                        </div>

                        <button type="submit" id="addToCartButton" class="btn btn-primary btn-lg">
                            <i class="fas fa-shopping-cart me-2"></i>Añadir al Carrito
                        </button>
                    </form>
                <?php else: ?>
                    <button id="addToCartButton" class="btn btn-secondary btn-lg" disabled>
                        <i class="fas fa-box-open me-2"></i>Fuera de Stock
                    </button>
                <?php endif; ?>

                <hr class="my-4">
                <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver al Catálogo
                </a>
            </div>
        </div>
        <div class="container my-3">
            <h2 class="mb-3">Detalles y Especificaciones</h2>
            <hr>
            <?php
            $rawDescription = $producto['descripcion'] ?? '';
            $rawDescription = str_replace(["\r\n", "\r"], "\n", $rawDescription);

            if (!empty($rawDescription)) {
                $sections = array_filter(array_map('trim', explode("\n\n", $rawDescription)));
                $section_count = count($sections);
                $col_counter = 0;
            ?>
                <?php foreach ($sections as $sectionContent): ?>
                    <?php
                    $lines = array_filter(array_map('trim', explode("\n", $sectionContent)));
                    if (empty($lines)) {
                        continue;
                    }
                    $sectionTitle = array_shift($lines);

                    if ($col_counter % 2 === 0):
                    ?>
                        <div class="row">
                    <?php endif; ?>

                    <div class="col-md-6 mb-3"> <h4 class="mb-2 text-danger border-bottom border-danger pb-1"><?= esc($sectionTitle) ?></h4>
                        <div class="ms-2"> <?php
                            for ($i = 0; $i < count($lines); $i += 2) {
                                $key = $lines[$i];
                                $value = $lines[$i + 1] ?? '';
                                ?>
                                <div class="d-flex justify-content-between align-items-baseline py-1">
                                    <span class="fw-bold text-dark me-2"><?= esc($key) ?>:</span>
                                    <span class="text-dark text-end flex-grow-1"><?= esc($value) ?></span>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

                    <?php
                    $col_counter++;
                    if ($col_counter % 2 === 0 || $col_counter === $section_count):
                    ?>
                        </div>
                    <?php endif; ?>

                <?php endforeach; ?>
            <?php
            } else {
                echo '<div class="col-12"><p class="text-muted">No hay especificaciones detalladas para este producto.</p></div>';
            }
            ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center" role="alert">
            <h4 class="alert-heading">Producto no encontrado</h4>
            <p>Lo sentimos, el producto que buscas no existe o no está disponible.</p>
            <a href="<?= base_url('catalogo') ?>" class="btn btn-warning mt-3">Volver al Catálogo</a>
        </div>
    <?php endif; ?>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const dismissAlerts = () => {
            const successAlert = document.querySelector('.alert-success');
            const errorAlert = document.querySelector('.alert-danger');
            if (successAlert) setTimeout(() => { new bootstrap.Alert(successAlert).close(); }, 3000);
            if (errorAlert) setTimeout(() => { new bootstrap.Alert(errorAlert).close(); }, 3000);
        };
        dismissAlerts();

        const addToCartForm = document.getElementById('addToCartForm');
        // Las siguientes variables ya no son necesarias si no actualizamos el stock visualmente aquí
        // const addToCartButton = document.getElementById('addToCartButton');
        // const stockBadge = document.getElementById('product-stock-badge');
        // const cantidadInput = document.getElementById('cantidad');
        // const lowStockMessageContainer = stockBadge ? stockBadge.nextElementSibling : null;

        if (addToCartForm) {
            addToCartForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.json())
                .then(data => {
                    document.querySelectorAll('.alert').forEach(alert => alert.remove());
                    const container = document.querySelector('.container.my-3');
                    let alertDiv;

                    if (data.success) {
                        alertDiv = `<div class="alert alert-success alert-dismissible fade show" role="alert">${data.message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
                        const cartCountDesktop = document.getElementById('cart-count-desktop');
                        const cartCountMobile = document.getElementById('cart-count-mobile');
                        if (cartCountDesktop) cartCountDesktop.innerText = data.cart_item_count;
                        if (cartCountMobile) cartCountMobile.innerText = data.cart_item_count;

                        // Se eliminó la lógica de actualización visual del stock aquí
                        // ya que no debe descontarse visualmente al añadir al carrito.

                    } else {
                        if (data.redirect_to_login) {
                            const loginRegisterModal = new bootstrap.Modal(document.getElementById('loginRegisterModal'));
                            loginRegisterModal.show();
                        } else {
                            alertDiv = `<div class="alert alert-danger alert-dismissible fade show" role="alert">${data.message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
                            // Se eliminó la lógica de actualización visual del stock aquí
                            // ya que no debe descontarse visualmente si hay un error.
                        }
                    }
                    if (alertDiv) {
                        container.insertAdjacentHTML('afterbegin', alertDiv);
                        dismissAlerts();
                    }
                })
                .catch(error => {
                    console.error('Error en la petición AJAX:', error);
                    const container = document.querySelector('.container.my-3');
                    container.insertAdjacentHTML('afterbegin', `<div class="alert alert-danger alert-dismissible fade show" role="alert">Hubo un problema al añadir el producto al carrito. Por favor, inténtalo de nuevo.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`);
                    dismissAlerts();
                });
            });
        }
    });
</script>

<?= $this->endSection() ?>