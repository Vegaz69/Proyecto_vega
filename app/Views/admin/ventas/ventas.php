<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
       <h1 class="h3 mb-0 text-dark fw-bolder text-center w-100"><i class="fas fa-receipt me-2"></i> Gestión de Ventas</h1>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex flex-wrap justify-content-start align-items-end mb-4 p-3 bg-light rounded shadow-sm">
        <form id="filterSalesForm" action="<?= base_url('admin/ventas') ?>" method="get" class="d-flex flex-wrap align-items-end w-100">
            <div class="me-3 mb-2 mb-md-0 flex-grow-1">
                <label for="nombre_cliente" class="form-label visually-hidden">Nombre Cliente</label>
                <input type="text" class="form-control form-control-sm" id="nombre_cliente" name="nombre_cliente" 
                       placeholder="Buscar por Nombre" value="<?= esc($filtro_nombre ?? '') ?>" title="Filtrar por Nombre del Cliente">
            </div>

            <div class="me-3 mb-2 mb-md-0 flex-grow-1">
                <label for="dni_cliente" class="form-label visually-hidden">DNI Cliente</label>
                <input type="text" class="form-control form-control-sm" id="dni_cliente" name="dni_cliente" 
                       placeholder="Buscar por DNI" value="<?= esc($filtro_dni ?? '') ?>" title="Filtrar por DNI del Cliente">
            </div>
            
            <div class="me-3 mb-2 mb-md-0">
                <label for="fecha_venta" class="form-label visually-hidden">Fecha Venta</label>
                <input type="date" class="form-control form-control-sm" id="fecha_venta" name="fecha_venta" 
                       value="<?= esc($filtro_fecha ?? '') ?>" title="Filtrar por Fecha de Venta">
            </div>
            
            <div class="me-2 mb-2 mb-md-0">
                <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-search me-1"></i> Aplicar Filtro</button>
            </div>
            <div class="mb-2 mb-md-0">
                <a href="<?= base_url('admin/ventas') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-redo me-1"></i> Limpiar Filtros</a>
            </div>
        </form>
    </div>
    <?php if (empty($ventas)): ?>
        <div class="alert alert-info text-center p-4 mt-5">
            <h4 class="fw-bold text-secondary">Aún no hay ventas registradas.</h4>
            <p>Cuando los clientes realicen compras, aparecerán aquí.</p>
        </div>
    <?php else: ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-light">Listado de Ventas</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive d-none d-md-block"> <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Correo</th>
                                <th>DNI</th>       <th>Teléfono</th>     <th>Dirección</th>    <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventas as $venta): ?>
                                <tr>
                                    <td><?= esc($venta['nombre_cliente'] . ' ' . $venta['apellido_cliente']) ?></td>
                                    <td><?= esc($venta['email_cliente'] ?? 'N/A') ?></td>
                                    <td><?= esc($venta['datos_cliente_parsed']['dni'] ?? 'N/A') ?></td>        <td><?= esc($venta['datos_cliente_parsed']['telefono'] ?? 'N/A') ?></td>     <td><?= esc($venta['datos_cliente_parsed']['direccion'] ?? 'N/A') ?></td>    <td><?= date('d/m/Y H:i', strtotime(esc($venta['fecha_venta']))) ?></td>
                                    <td>$<?= number_format(esc($venta['total_venta']), 2, ',', '.') ?></td>
                                    <td><span class="badge bg-info"><?= esc(ucfirst($venta['estado_venta'])) ?></span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#collapseDetalle<?= $venta['id_venta'] ?>"
                                                    aria-expanded="false" aria-controls="collapseDetalle<?= $venta['id_venta'] ?>">
                                                Ver Detalles
                                        </button>
                                    </td>
                                </tr>
                                <tr class="collapse" id="collapseDetalle<?= $venta['id_venta'] ?>">
                                    <td colspan="9"> <h6 class="mt-2 mb-2 text-primary">Detalle de la Venta #<?= esc($venta['id_venta']) ?>:</h6>
                                        <table class="table table-sm table-borderless table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th class="text-center">Cantidad</th>
                                                    <th class="text-end">Precio Unitario</th>
                                                    <th class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($venta['detalles'])): ?>
                                                    <?php foreach ($venta['detalles'] as $detalle): ?>
                                                        <tr>
                                                            <td><?= esc($detalle['nombre_producto']) ?></td>
                                                            <td class="text-center"><?= esc($detalle['cantidad']) ?></td>
                                                            <td class="text-end">$<?= number_format(esc($detalle['precio_unitario']), 2, ',', '.') ?></td>
                                                            <td class="text-end">$<?= number_format(esc($detalle['subtotal']), 2, ',', '.') ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted">No hay detalles para esta venta.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="sales-list-mobile-view d-md-none"> <?php foreach ($ventas as $venta): ?>
                        <div class="sale-item-trigger card mb-2 shadow-sm"
                             data-bs-toggle="modal" 
                             data-bs-target="#saleDetailModal"
                             data-id="<?= esc($venta['id_venta']) ?>"
                             data-nombre-cliente="<?= esc($venta['nombre_cliente'] . ' ' . $venta['apellido_cliente']) ?>"
                             data-dni-cliente="<?= esc($venta['datos_cliente_parsed']['dni'] ?? 'N/A') ?>"
                             data-email-cliente="<?= esc($venta['email_cliente'] ?? 'N/A') ?>"
                             data-telefono-cliente="<?= esc($venta['datos_cliente_parsed']['telefono'] ?? 'N/A') ?>"
                             data-direccion-cliente="<?= esc($venta['datos_cliente_parsed']['direccion'] ?? 'N/A') ?>"
                             data-fecha-venta="<?= date('d/m/Y H:i', strtotime(esc($venta['fecha_venta']))) ?>"
                             data-total-venta="<?= number_format(esc($venta['total_venta']), 2, ',', '.') ?>"
                             data-estado-venta="<?= esc(ucfirst($venta['estado_venta'])) ?>"
                             data-detalles='<?= json_encode($venta['detalles']) ?>'> 
                             <div class="card-body py-2">
                            <h6 class="mb-0 text-primary">
                                <i class="fas fa-user me-1"></i> <?= esc($venta['nombre_cliente'] . ' ' . $venta['apellido_cliente']) ?>
                            </h6>
                            <small class="d-block text-muted">
                                <i class="fas fa-id-card me-1"></i> DNI: <?= esc($venta['datos_cliente_parsed']['dni'] ?? 'N/A') ?>
                            </small>
                            <small class="d-block text-muted">
                                <i class="fas fa-calendar-alt me-1"></i> Fecha: <?= date('d/m/Y', strtotime(esc($venta['fecha_venta']))) ?>
                            </small>
                            <div class="sale-summary-info text-end mt-2">
                                <span class="badge bg-info"><?= esc(ucfirst($venta['estado_venta'])) ?></span>
                            </div>
                        </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="saleDetailModal" tabindex="-1" aria-labelledby="saleDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="saleDetailModalLabel">Detalle de Venta #<span id="modalVentaId"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Cliente:</strong> <span id="modalClienteNombre"></span></p>
                        <p class="mb-1"><strong>DNI:</strong> <span id="modalClienteDni"></span></p>
                        <p class="mb-1"><strong>Email:</strong> <span id="modalClienteEmail"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Teléfono:</strong> <span id="modalClienteTelefono"></span></p>
                        <p class="mb-1"><strong>Dirección:</strong> <span id="modalClienteDireccion"></span></p>
                        <p class="mb-1"><strong>Fecha de Venta:</strong> <span id="modalFechaVenta"></span></p>
                    </div>
                </div>
                <hr>
                <h6 class="mb-2 text-primary">Productos Comprados:</h6>
                <div id="modalDetallesProductos">
                    </div>
                <hr>
                <p class="text-end h5"><strong>Total Venta:</strong> $<span id="modalTotalVenta"></span></p>
                <p class="text-end"><strong>Estado:</strong> <span class="badge bg-info" id="modalEstadoVenta"></span></p>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lógica para el filtro (ya existente)
    var filterForm = document.getElementById('filterSalesForm');
    var clearFilterBtn = filterForm.querySelector('.btn-secondary');

    clearFilterBtn.addEventListener('click', function() {
        // Al hacer clic en "Limpiar Filtros", resetea los campos y envía el formulario.
        filterForm.querySelector('#nombre_cliente').value = '';
        filterForm.querySelector('#dni_cliente').value = '';
        filterForm.querySelector('#fecha_venta').value = '';
        filterForm.submit(); 
    });

    // Lógica para el Modal de Detalles de Venta
    var saleDetailModal = document.getElementById('saleDetailModal');
    saleDetailModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // El botón (.sale-item-trigger) que activó el modal

        // Obtener los datos de los atributos data-*
        var idVenta = button.getAttribute('data-id');
        var nombreCliente = button.getAttribute('data-nombre-cliente');
        var dniCliente = button.getAttribute('data-dni-cliente');
        var emailCliente = button.getAttribute('data-email-cliente');
        var telefonoCliente = button.getAttribute('data-telefono-cliente');
        var direccionCliente = button.getAttribute('data-direccion-cliente');
        var fechaVenta = button.getAttribute('data-fecha-venta');
        var totalVenta = button.getAttribute('data-total-venta');
        var estadoVenta = button.getAttribute('data-estado-venta');
        var detallesJSON = button.getAttribute('data-detalles');
        
        // Parsear el JSON de los detalles de los productos
        var detalles = JSON.parse(detallesJSON); 

        // Actualizar el contenido del modal
        saleDetailModal.querySelector('#modalVentaId').textContent = idVenta;
        saleDetailModal.querySelector('#modalClienteNombre').textContent = nombreCliente;
        saleDetailModal.querySelector('#modalClienteDni').textContent = dniCliente;
        saleDetailModal.querySelector('#modalClienteEmail').textContent = emailCliente;
        saleDetailModal.querySelector('#modalClienteTelefono').textContent = telefonoCliente;
        saleDetailModal.querySelector('#modalClienteDireccion').textContent = direccionCliente;
        saleDetailModal.querySelector('#modalFechaVenta').textContent = fechaVenta;
        saleDetailModal.querySelector('#modalTotalVenta').textContent = totalVenta; // Este ya viene formateado
        saleDetailModal.querySelector('#modalEstadoVenta').textContent = estadoVenta;

        // Limpiar y cargar los detalles de los productos
        var detallesProductosContainer = saleDetailModal.querySelector('#modalDetallesProductos');
        detallesProductosContainer.innerHTML = ''; // Limpiar contenido previo

        if (detalles && detalles.length > 0) {
            var ul = document.createElement('ul');
            ul.classList.add('list-group', 'list-group-flush');
            detalles.forEach(function(detalle) {
                var li = document.createElement('li');
                li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                li.innerHTML = `
                    <div>
                        ${detalle.nombre_producto} 
                        <small class="text-muted d-block">${detalle.cantidad} x $${parseFloat(detalle.precio_unitario).toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</small>
                    </div>
                    <strong>$${parseFloat(detalle.subtotal).toLocaleString('es-AR', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</strong>
                `;
                ul.appendChild(li);
            });
            detallesProductosContainer.appendChild(ul);
        } else {
            detallesProductosContainer.innerHTML = '<p class="text-center text-muted">No hay detalles de productos para esta venta.</p>';
        }
    });
});
</script>

<?= $this->endSection() ?>