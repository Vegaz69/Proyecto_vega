<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div class="container my-5">
    <h1 class="mb-4 text-center">Tu Carrito de Compras</h1>

    <?php if (session()->getFlashdata('success_cart')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('success_cart')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error_cart')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('error_cart')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($carrito)): ?>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Producto</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Precio Unitario</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $id_producto => $item): ?>
                        <tr>
                            <td><?= esc($item['nombre']) ?></td>
                            <td>
                                <?php if (!empty($item['imagen'])): ?>
                                    <img src="<?= base_url('uploads/productos/' . esc($item['imagen'])) ?>" alt="<?= esc($item['nombre']) ?>" style="width: 60px; height: 60px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="<?= base_url('assets/img/placeholder.png') ?>" alt="Sin imagen" style="width: 60px; height: 60px; object-fit: cover;">
                                <?php endif; ?>
                            </td>
                            <td>$<?= number_format(esc($item['precio']), 2, ',', '.') ?></td>
                            <td>
                                <form action="<?= base_url('carrito/actualizar') ?>" method="post" class="d-flex align-items-center">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_producto" value="<?= esc($id_producto) ?>">
                                    <input type="number" name="cantidad" value="<?= esc($item['cantidad']) ?>" min="1" max="<?= esc($item['stock_actual'] ?? 999) ?>" class="form-control form-control-sm me-2" style="width: 80px;">
                                    <button type="submit" class="btn btn-sm btn-outline-primary" title="Actualizar Cantidad"><i class="fas fa-sync-alt"></i></button>
                                </form>
                            </td>
                            <td>$<?= number_format(esc($item['precio'] * $item['cantidad']), 2, ',', '.') ?></td>
                            <td>
                                <form action="<?= base_url('carrito/eliminar') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id_producto" value="<?= esc($id_producto) ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar Producto" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto del carrito?');"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end mt-4">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Resumen del Carrito</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Subtotal:
                                <span class="fw-bold">$<?= number_format(esc($subtotal), 2, ',', '.') ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center text-primary fs-5">
                                Total:
                                <span class="fw-bold">$<?= number_format(esc($total), 2, ',', '.') ?></span>
                            </li>
                        </ul>
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-2"></i>Seguir Comprando</a>
                            <form action="<?= base_url('carrito/procesarCompra') ?>" method="post" class="mt-2">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-success btn-lg w-100"><i class="fas fa-money-check-alt me-2"></i>Comprar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center" role="alert">
            <h4 class="alert-heading">Tu carrito está vacío</h4>
            <p>Parece que aún no has añadido ningún producto a tu carrito de compras.</p>
            <hr>
            <a href="<?= base_url('catalogo') ?>" class="btn btn-primary"><i class="fas fa-store me-2"></i>Ir al Catálogo</a>
        </div>
    <?php endif; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Script para desaparecer las alertas de flashdata
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

</div>

<?= $this->endSection() ?>