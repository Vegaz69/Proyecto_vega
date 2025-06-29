<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0"><i class="fas fa-tachometer-alt me-2"></i> Dashboard Administrativo</h2>
        <p class="text-muted mb-0">Un vistazo rápido a la actividad de tu plataforma.</p>
    </div>

    <div class="row mb-5 g-4">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div
                class="p-4 bg-primary text-white rounded shadow-sm d-flex justify-content-between align-items-center h-100">
                <div>
                    <h3 class="display-4 fw-bold mb-0">150</h3>
                    <p class="lead mb-0">Usuarios Registrados</p>
                </div>
                <i class="fas fa-users fa-5x opacity-50"></i>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div
                class="p-4 bg-success text-white rounded shadow-sm d-flex justify-content-between align-items-center h-100">
                <div>
                    <h3 class="display-4 fw-bold mb-0">250</h3>
                    <p class="lead mb-0">Ventas Realizadas</p>
                </div>
                <i class="fas fa-shopping-cart fa-5x opacity-50"></i>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12">
            <div
                class="p-4 bg-warning text-dark rounded shadow-sm d-flex justify-content-between align-items-center h-100">
                <div>
                    <h3 class="display-4 fw-bold mb-0">500</h3>
                    <p class="lead mb-0">Productos en Stock</p>
                </div>
                <i class="fas fa-boxes fa-5x opacity-50"></i>
            </div>
        </div>
    </div>

    <h3 class="mb-3 fw-bold text-center">Acciones y Gestión</h3>
    <div class="row mb-5 g-4 justify-content-center">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?= base_url('admin/productos/crear') ?>"
                class="card text-center p-3 shadow-sm h-100 d-block text-decoration-none text-dark hover-effect">
                <div class="card-body">
                    <i class="fas fa-plus-circle fa-3x mb-3 text-primary"></i>
                    <h5 class="card-title fw-bold">Nuevo Producto</h5>
                    <p class="card-text text-muted">Añade un producto al catálogo.</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?= base_url('admin/categorias/crear') ?>"
                class="card text-center p-3 shadow-sm h-100 d-block text-decoration-none text-dark hover-effect">
                <div class="card-body">
                    <i class="fas fa-folder-plus fa-3x mb-3 text-info"></i>
                    <h5 class="card-title fw-bold">Nueva Categoría</h5>
                    <p class="card-text text-muted">Organiza tus productos en categorías.</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?= base_url('admin/usuarios/crear') ?>"
                class="card text-center p-3 shadow-sm h-100 d-block text-decoration-none text-dark hover-effect">
                <div class="card-body">
                    <i class="fas fa-user-plus fa-3x mb-3 text-dark"></i>
                    <h5 class="card-title fw-bold">Nuevo Admin</h5>
                    <p class="card-text text-muted">Registra nuevos administradores.</p>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <a href="<?= base_url('admin/mensajes') ?>"
                class="card text-center p-3 shadow-sm h-100 d-block text-decoration-none text-dark hover-effect">
                <div class="card-body">
                    <i class="fas fa-envelope fa-3x mb-3 text-danger"></i>
                    <h5 class="card-title fw-bold">Mensajes (0)</h5>
                    <p class="card-text text-muted">Revisa consultas de clientes.</p>
                </div>
            </a>
        </div>
    </div>

    <h3 class="mb-3 fw-bold text-center">Novedades y Metas</h3>
    <div class="row g-4 justify-content-center">
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 text-white"><i class="fas fa-history me-2"></i> Últimos Eventos del Sistema</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-user-plus text-success me-2"></i> Nuevo usuario registrado: <strong
                                    class="text-dark">Usuario A</strong>
                                <small class="text-muted d-block">Hace 5 minutos</small>
                            </div>
                            <a href="<?= base_url('admin/usuarios') ?>"
                                class="badge bg-secondary text-decoration-none">Ver</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-pencil-alt text-primary me-2"></i> Producto actualizado: <strong
                                    class="text-dark">Producto X</strong>
                                <small class="text-muted d-block">Hace 30 minutos</small>
                            </div>
                            <a href="<?= base_url('admin/productos') ?>"
                                class="badge bg-success text-decoration-none">Editar</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-receipt text-info me-2"></i> Nuevo pedido: <strong
                                    class="text-dark">#123</strong>
                                <small class="text-muted d-block">Hace 1 hora</small>
                            </div>
                            <a href="<?= base_url('admin/ventas') ?>" class="badge bg-info text-decoration-none">Ver</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-folder-open text-warning me-2"></i> Categoría creada: <strong
                                    class="text-dark">Categoría Y</strong>
                                <small class="text-muted d-block">Ayer</small>
                            </div>
                            <a href="<?= base_url('admin/categorias') ?>"
                                class="badge bg-warning text-decoration-none">Detalle</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-box-open text-secondary me-2"></i> Stock bajo: <strong
                                    class="text-dark">Producto Z (5 unidades)</strong>
                                <small class="text-muted d-block">Ayer</small>
                            </div>
                            <a href="<?= base_url('admin/productos') ?>"
                                class="badge bg-danger text-decoration-none">Atender</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0 text-white"><i class="fas fa-bullseye me-2"></i> Progreso de Meta (Ejemplo)</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                    <p class="text-center mb-3 lead">¡Hemos alcanzado el 75% de nuestra meta de ventas mensuales!</p>
                    <div class="progress mb-3" style="height: 30px;">
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                            role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0"
                            aria-valuemax="100">
                            75% Completado
                        </div>
                    </div>
                    <p class="text-center text-muted small">Meta: $10,000 | Actual: $7,500</p>
                    <!-- <a href="#" class="btn btn-outline-primary btn-sm mt-3 align-self-center">Configurar Metas <i class="fas fa-cog ms-1"></i></a> -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-effect:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        transition: all 0.3s ease-in-out;
    }

    .hover-effect {
        transition: all 0.3s ease-in-out;
    }
</style>

<?= $this->endSection() ?>