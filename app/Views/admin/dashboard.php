<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid text-center">
    <h2 class="mb-4 fw-bold">Bienvenido al Panel de Administración</h2>
    <p class="fs-5 text-muted">Desde aquí puedes gestionar diferentes aspectos de tu sitio.</p>
</div>

    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-dark shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-4 fw-bold">150</div>
                        <div class="text-white">Usuarios Registrados</div> </div>
                    <i class="fas fa-users fa-3x text-white ms-3"></i> </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-4 fw-bold">250</div>
                        <div class="text-white">Ventas Realizadas</div> </div>
                    <i class="fas fa-dollar-sign fa-3x text-white ms-3"></i> </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-warning shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fs-4 fw-bold">500</div>
                        <div class="text-white">Productos en Stock</div> </div>
                    <i class="fas fa-boxes fa-3x text-white ms-3"></i> </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0 text-white">Gestión de Productos</h5> </div>
                <div class="card-body">
                    <p class="card-text">Administra tus productos, precios y stock.</p>
                    <a href="<?= base_url('admin/productos') ?>" class="btn btn btn-dark">Ir a Productos</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0 text-white">Gestión de Categorías</h5> </div>
                <div class="card-body">
                    <p class="card-text">Gestiona las categorías de tus productos.</p>
                    <a href="<?= base_url('admin/categorias') ?>" class="btn btn-dark">Ir a Categorías</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center shadow-sm h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0 text-white">Gestión de Usuarios</h5> </div>
                <div class="card-body">
                    <p class="card-text">Controla los usuarios de tu plataforma.</p>
                    <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-dark">Ir a Usuarios</a>
                </div>
            </div>
        </div>
    </div>


<div class="row mt-4">
    <div class="col-12 mb-3">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 text-white">Actividad Reciente</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush"> <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-user-plus text-success me-2"></i> Nuevo usuario registrado: <strong class="text-dark">Usuario A</strong>
                        </div>
                        <span class="badge bg-secondary">Ver</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-pencil-alt text-primary me-2"></i> Producto actualizado: <strong class="text-dark">Producto X</strong>
                        </div>
                        <span class="badge bg-success">Editar</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-folder-open text-warning me-2"></i> Categoría creada: <strong class="text-dark">Categoría Y</strong>
                        </div>
                        <span class="badge bg-warning">Detalle</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-receipt text-info me-2"></i> Nuevo pedido: <strong class="text-dark">#123</strong>
                        </div>
                        <span class="badge bg-info">Info</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-user-shield text-danger me-2"></i> Nuevo administrador: <strong class="text-dark">Admin Nuevo</strong>
                        </div>
                        <span class="badge bg-primary">Admin</span>
                    </li>
                    </ul>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>