
<?php
// app/Views/front/nav_view.php

// --- LÓGICA PARA OBTENER EL CONTADOR DEL CARRITO ---
// Llamamos directamente al helper que creamos.
// Asegúrate de que el helper 'cart' esté cargado en app/Config/Autoload.php
$cartItemCount = getCartItemCount();
// --- FIN DE LÓGICA PARA OBTENER EL CONTADOR DEL CARRITO ---
?>

<nav class="navbar navbar-dark bg-dark shadow-sm py-1 w-100">
    <div class="container-fluid d-flex align-items-center justify-content-center justify-content-lg-between">

        <a class="navbar-brand fw-bold fs-2 m-0 text-center" href="<?= base_url('principal'); ?>">
            <span style="font-family: 'Racing Sans One', cursive; color: white;">TRY</span>
            <span style="font-family: 'Racing Sans One', cursive;" class="text-warning"> HARDWARE</span>
        </a>

        <div class="d-none d-lg-flex align-items-center flex-grow-1 justify-content-end">
           <form class="d-flex me-3" role="search" style="max-width: 600px; width: 100%;" action="<?= base_url('buscar'); ?>" method="get">
    <input class="form-control me-2" type="search" placeholder="Buscar..." aria-label="Buscar" name="q">
    <button class="btn btn-outline-warning" type="submit"><i class="fas fa-search"></i></button>
</form>

            <a class="nav-link text-white position-relative me-3" href="<?= base_url('carrito/ver'); ?>">
                <i class="fas fa-shopping-cart fa-lg"></i>
                <span id="cart-count-desktop" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?= $cartItemCount ?> <span class="visually-hidden">items</span>
                </span>
            </a>

            <?php if (session()->get('isLoggedIn')): ?>
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle text-white d-flex align-items-center" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle fa-lg me-2"></i>
                        <span><?= esc(session()->get('nombre') ?? session()->get('email')) ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                        <?php if (session()->get('rol') === 'admin'): ?>
                            <li><a class="dropdown-item" href="<?= base_url('admin/dashboard'); ?>">Panel de Admin</a></li>
                        <?php else: ?>
                            <li><a class="dropdown-item" href="<?= base_url('mi-cuenta'); ?>">Mi cuenta</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('mis-pedidos'); ?>">Mis Pedidos</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="<?= base_url('logout'); ?>">Cerrar Sesión</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a class="btn btn-outline-light rounded-pill px-3 me-2" href="<?= base_url('login'); ?>">
                    <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
                </a>
                <a class="btn btn-warning rounded-pill px-3" href="<?= base_url('registro'); ?>">
                    <i class="fas fa-user-plus me-2"></i> Registrarse
                </a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm py-0">
    <div class="container-fluid">
        <ul class="navbar-nav mx-auto flex-row justify-content-center w-100 text-center nav-icons-responsive">
            <li class="nav-item mx-2">
                <a class="nav-link text-dark d-flex flex-column align-items-center" href="<?= base_url('catalogo'); ?>">
                    <i class="fa-solid fa-store"></i> <span class="d-none d-sm-inline">Catálogo</span>
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-dark d-flex flex-column align-items-center" href="<?= base_url('quienesSomos'); ?>">
                    <i class="fas fa-users"></i>
                    <span class="d-none d-sm-inline">Quiénes somos</span>
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-dark d-flex flex-column align-items-center" href="<?= base_url('comercializacion'); ?>">
                    <i class="fas fa-handshake"></i>
                    <span class="d-none d-sm-inline">Comercialización</span>
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-dark d-flex flex-column align-items-center" href="<?= base_url('contacto'); ?>">
                    <i class="fas fa-envelope"></i>
                    <span class="d-none d-sm-inline">Contacto</span>
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link text-dark d-flex flex-column align-items-center" href="<?= base_url('terminosyUsos'); ?>">
                    <i class="fas fa-file-alt"></i>
                    <span class="d-none d-sm-inline">Términos y Usos</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<nav class="navbar navbar-dark bg-dark shadow-sm fixed-bottom d-flex d-lg-none py-2">
    <div class="container-fluid justify-content-around">
        <a class="nav-link text-white text-center" href="<?= base_url('principal'); ?>">
            <i class="fas fa-home fa-lg"></i>
        </a>
        <a class="nav-link text-white text-center position-relative" href="<?= base_url('carrito/ver'); ?>">
            <i class="fas fa-shopping-cart fa-lg"></i>
            <span id="cart-count-mobile" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $cartItemCount ?> <span class="visually-hidden">items</span>
            </span>
        </a>
        <a class="nav-link text-white text-center" href="<?= base_url('login'); ?>">
            <i class="fas fa-sign-in-alt fa-lg"></i>
        </a>
        <a class="nav-link text-white text-center" href="<?= base_url('registro'); ?>">
            <i class="fas fa-user-plus fa-lg"></i>
        </a>
        <a class="nav-link text-white text-center" href="<?= base_url('contacto'); ?>">
            <i class="fas fa-envelope fa-lg"></i>
        </a>
    </div>
</nav>

