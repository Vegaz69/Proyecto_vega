<?= view('front/head_view') ?>
<?= view('front/nav_view') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    <h2 class="mb-4 text-center text-dark">Iniciar sesión</h2>
                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                    <?php endif; ?>

                    <form action="<?= base_url('login') ?>" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i> Correo
                                electrónico</label>
                            <input type="email" class="form-control form-control-lg" name="email" required
                                autocomplete="email" placeholder="Tu correo electrónico">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="fas fa-lock me-2"></i> Contraseña</label>
                            <input type="password" class="form-control form-control-lg" name="password" required
                                autocomplete="current-password" placeholder="Tu contraseña">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn bg-warning btn-lg rounded-pill">
                                <i class="fas fa-sign-in-alt me-2"></i> Continuar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('front/footer_view') ?>