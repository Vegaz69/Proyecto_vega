<?= view('front/head_view') ?>
<?= view('front/nav_view') ?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body p-4">
                    <h2 class="mb-4 text-center text-dark">Registro de Usuario</h2>

                    <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li>
                                <?= esc($error) ?>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <form action="<?= base_url('registro') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="nombre" class="form-label"><i class="fas fa-user me-2"></i> Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control form-control-lg" required
                                value="<?= old('nombre') ?>" placeholder="Tu nombre">
                            <?php if (session('errors.nombre')) : ?>
                            <p class="text-danger">
                                <?= session('errors.nombre') ?>
                            </p>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label"><i class="fas fa-user-tag me-2"></i>
                                Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control form-control-lg"
                                required value="<?= old('apellido') ?>" placeholder="Tu apellido">
                            <?php if (session('errors.apellido')) : ?>
                            <p class="text-danger">
                                <?= session('errors.apellido') ?>
                            </p>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i> Correo
                                electrónico</label>
                            <input type="email" name="email" class="form-control form-control-lg" required
                                value="<?= old('email') ?>" placeholder="Tu correo electrónico">
                            <?php if (session('errors.email')) : ?>
                            <p class="text-danger">
                                <?= session('errors.email') ?>
                            </p>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"><i class="fas fa-lock me-2"></i> Contraseña</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg"
                                required minlength="6" placeholder="Tu contraseña">
                            <div class="form-text text-muted">Mínimo 6 caracteres</div>
                            <?php if (session('errors.password')) : ?>
                            <p class="text-danger">
                                <?= session('errors.password') ?>
                            </p>
                            <?php endif ?>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label"><i class="fas fa-redo me-2"></i> Repetir
                                contraseña</label>
                            <input type="password" name="confirm_password" id="confirm_password"
                                class="form-control form-control-lg" required minlength="6"
                                placeholder="Repite tu contraseña">
                            <div id="passwordFeedback" class="form-text d-none">Las contraseñas no coinciden</div>
                            <?php if (session('errors.confirm_password')) : ?>
                            <p class="text-danger">
                                <?= session('errors.confirm_password') ?>
                            </p>
                            <?php endif ?>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg rounded-pill">
                                <i class="fas fa-user-plus me-2"></i> Registrarse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const pass = document.getElementById("password");
        const confirm = document.getElementById("confirm_password");
        const feedback = document.getElementById("passwordFeedback");
        const form = document.querySelector("form");

        function checkPasswords() {
            if (pass.value.length >= 6 && confirm.value.length >= 6 && pass.value === confirm.value) {
                confirm.classList.add("is-valid");
                confirm.classList.remove("is-invalid");
                feedback.classList.add("d-none");
            } else {
                confirm.classList.remove("is-valid");
                confirm.classList.add("is-invalid");
                feedback.classList.remove("d-none");
            }
        }

        pass.addEventListener("input", checkPasswords);
        confirm.addEventListener("input", checkPasswords);

        form.addEventListener("submit", function (e) {
            if (pass.value.length < 6 || pass.value !== confirm.value) {
                e.preventDefault();
                confirm.focus();
            }
        });
    });
</script>

<?= view('front/footer_view') ?>