<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div class="container my-3">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0 rounded-3 text-center p-5">
                <div class="card-body">
                    <i class="fas fa-check-circle text-success mb-4" style="font-size: 5rem;"></i>
                    <h1 class="card-title fw-bold text-success mb-3">¡Pedido Confirmado!</h1>
                    <p class="lead mb-4">Tu pedido ha sido registrado con éxito. Gracias por tu compra.</p>

                    <?php if (isset($id_venta)): ?>
                        <p class="fs-5">Número de Pedido: <strong class="text-primary">#<?= esc($id_venta) ?></strong></p>
                    <?php endif; ?>

                    <p class="mb-4">Te enviaremos una confirmación a tu correo electrónico con los detalles completos.</p>

                    <div class="d-grid gap-2 col-md-8 mx-auto">
                        <a href="<?= base_url('catalogo') ?>" class="btn btn-primary btn-lg">
                            <i class="fas fa-store me-2"></i> Seguir Comprando
                        </a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>