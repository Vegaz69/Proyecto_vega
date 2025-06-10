<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <a class="navbar-brand fs-3 fw-bold" href="<?= base_url('principal'); ?>">TRY-HARDWARE</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse justify-content-center mt-2" id="navbarSupportedContent">
            <ul class="navbar-nav gap-3 flex-wrap">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('quienesSomos'); ?>">Quienes Somos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('comercializacion'); ?>">Comercialización</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('contacto'); ?>">Contacto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('terminosyUsos'); ?>">Términos y Usos</a>
                </li>

                <?php if (session()->get('isLoggedIn')): ?>
                    <li class="nav-item">
                        <span class="nav-link active">Hola, <?= session()->get('nombre') ?></span>
                    </li>
                    
                    <?php if (session()->get('rol') === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link active fw-bold text-warning" href="<?= base_url('admin/dashboard'); ?>">
                                Panel de Administración
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link active text-danger fw-bold" href="<?= base_url('logout'); ?>">
                            Cerrar sesión
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold px-3 py-1 border border-light rounded" href="#" 
                           data-bs-toggle="modal" data-bs-target="#loginModal">
                           Iniciar sesión
                        </a>
                    </li>
                <?php endif; ?>
            </ul>

            <form class="d-flex">
               <input class="form-control ms-2 me-2 w-50" type="search" placeholder="Buscar..." aria-label="Search" id="search_input" name="search_query">
                <button class="btn btn-light text-dark" type="submit">Buscar</button>
            </form>
        </div>
    </div>
</nav>
 <!--    <li class="nav-item">
    <a class="nav-link" href="<?= base_url('carrito/ver') ?>">
        <i class="fas fa-shopping-cart"></i> Carrito
        <?php // if (session()->get('carrito') && count(session()->get('carrito')) > 0): ?>
        <?php //     echo '<span class="badge bg-danger rounded-pill">' . count(session()->get('carrito')) . '</span>'; ?>
        <?php // endif; ?>
    </a>
</li> -->




<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('login'); ?>" method="post">
                    <div class="mb-3">
                        <label for="login_email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" name="email" id="login_email" required="" autocomplete="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Continuar</button>
                </form>
            </div>
            <div class="modal-footer">
                <p>¿No tienes cuenta?</p>
                <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#registerModal">Crear cuenta</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Registro de Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('usuarios/guardar'); ?>" method="post">
                    <div class="mb-3">
                        <label for="register_nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" name="nombre" id="register_nombre" autocomplete="name" required> </div>
                    <div class="mb-3">
                        <label for="register_dni" class="form-label">DNI</label>
                        <input type="text" class="form-control" name="dni" id="register_dni" autocomplete="off" required> </div>
                    <div class="mb-3">
                        <label for="register_email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" name="email" id="register_email" autocomplete="email" required> </div>
                    <div class="mb-3">
                        <label for="register_password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="register_password" autocomplete="new-password" required> </div>
                    <div class="mb-3">
                        <label for="register_confirm_password" class="form-label">Repetir contraseña</label>
                        <input type="password" class="form-control" name="confirm_password" id="register_confirm_password" autocomplete="new-password" required> </div>
                    <button type="submit" class="btn btn-success w-100" id="registerButton" disabled>Confirmar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Apunta a los nuevos IDs específicos del modal de registro
    const passwordField = document.querySelector("#registerModal #register_password"); // CAMBIO ID
    const confirmPasswordField = document.querySelector("#registerModal #register_confirm_password"); // CAMBIO ID
    const registerButton = document.querySelector("#registerModal #registerButton");

    function validarContraseñas() {
        if (passwordField.value.trim() !== "" &&
            passwordField.value === confirmPasswordField.value &&
            passwordField.value.length >= 3) {
            registerButton.removeAttribute("disabled");
        } else {
            registerButton.setAttribute("disabled", "true");
        }
    }

    passwordField.addEventListener("input", validarContraseñas);
    confirmPasswordField.addEventListener("input", validarContraseñas);
});
</script>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>