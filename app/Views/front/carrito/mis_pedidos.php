<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div class="container my-3">
    <h1 class="text-center fw-bold bg-dark mb-4">🛍️ Mis Compras</h1>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
        <?= esc(session()->getFlashdata('error')); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (empty($pedidos)): ?>
    <div class="alert alert-info text-center p-4">
        <h4 class="fw-bold text-secondary">Aún no has realizado ninguna compra.</h4>
        <p>¡Explora nuestro catálogo y encuentra lo que buscas!</p>
        <a href="<?= base_url('catalogo') ?>" class="btn btn-primary btn-lg mt-3">
            <i class="fas fa-store me-2"></i> Ir al Catálogo
        </a>
    </div>
    <?php else: ?>
    <?php foreach ($pedidos as $pedido): ?>
    <div class="card shadow-lg mb-4 border-0 rounded-3">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center rounded-top-3">
            <h5 class="mb-0 fw-bold">Pedido #
                <?= esc($pedido['id_venta']) ?>
            </h5>
            <span>Fecha:
                <?= date('d/m/Y H:i', strtotime(esc($pedido['fecha_venta']))) ?>
            </span>
        </div>
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">Estado: <span class="badge bg-info">
                    <?= esc(ucfirst($pedido['estado_venta'])) ?>
                </span></h6>
            <h6 class="card-subtitle mb-3 text-muted">Total: <span class="fw-bold text-success">$
                    <?= number_format(esc($pedido['total_venta']), 2, ',', '.') ?>
                </span></h6>

            <div class="table-responsive">
                <table class="table table-sm table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Precio Unitario</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedido['detalles'] as $detalle): ?>
                        <tr>
                            <td>
                                <?= esc($detalle['nombre_producto']) ?>
                            </td>
                            <td class="text-center">
                                <?= esc($detalle['cantidad']) ?>
                            </td>
                            <td class="text-end">$
                                <?= number_format(esc($detalle['precio_unitario']), 2, ',', '.') ?>
                            </td>
                            <td class="text-end">$
                                <?= number_format(esc($detalle['subtotal']), 2, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>