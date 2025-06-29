<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= isset($titulo) ? $titulo : 'Panel de Administración' ?> | TRY-HARDWARE Admin
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin_styles.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/custom_admin.css') ?>">
</head>

<body>

    <nav class="navbar navbar-dark bg-dark fixed-top shadow-sm px-2">
        <div class="container-fluid d-flex align-items-center justify-content-between px-1">

            <button class="btn btn-outline-light d-lg-none me-2 p-2" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>

            <a class="navbar-brand fw-bold d-flex align-items-center gap-2">
                <i class="fas fa-cogs"></i>
                Panel Admin
            </a>

            <div class="dropdown ms-auto">
                <a class="nav-link dropdown-toggle text-white p-2 d-flex align-items-center" href="#" id="userDropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">

                    <span class="d-inline d-sm-none">
                        <i class="fas fa-user-circle fa-lg"></i>
                    </span>

                    <span class="d-none d-sm-flex align-items-center">
                        <i class="fas fa-user me-2"></i>
                        <?= session()->get('email') ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="<?= base_url('/'); ?>">Volver al Sitio</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('logout'); ?>">
                            Cerrar Sesión</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>




    <div id="main-wrapper">
        <div class="sidebar bg-dark text-white p-3">
            <h5 class="sidebar-heading">Menú Principal</h5>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="<?= base_url('admin/dashboard'); ?>" class="nav-link">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/productos'); ?>" class="nav-link">
                        <i class="fas fa-boxes"></i> Productos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/categorias'); ?>" class="nav-link">
                        <i class="fas fa-tags"></i> Categorías
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/usuarios'); ?>" class="nav-link">
                        <i class="fas fa-users"></i> Usuarios
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/ventas'); ?>" class="nav-link">
                        <i class="fas fa-receipt"></i> Ventas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/mensajes'); ?>" class="nav-link">
                        <i class="fas fa-envelope-open-text"></i> Mensajes
                    </a>
                </li>
            </ul>
        </div>
        <div class="container-fluid main-content pt-5 pb-5">
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script para togglear la sidebar en pantallas pequeñas
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            document.getElementById('main-wrapper').classList.toggle('toggled');
            document.body.classList.toggle('sidebar-expanded');
        });

        // Añadir clase 'active' a la sidebar item actual
        document.addEventListener('DOMContentLoaded', function () {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(link => {
                // Compara la URL completa para mayor precisión
                if (link.href === window.location.href) {
                    link.classList.add('active');
                }
            });
        });
    </script>


</body>

</html>