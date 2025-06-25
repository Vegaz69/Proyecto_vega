<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <h2 class="mb-4 text-center fw-bold text-dark">📩 Gestión de Mensajes</h2>

    <div id="dynamicAlertContainer" class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 1050;"></div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <?= esc(session()->getFlashdata('success')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <?= esc(session()->getFlashdata('error')); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex flex-wrap justify-content-start align-items-end mb-4 p-3 bg-light rounded shadow-sm">
        <form id="filterForm" action="<?= base_url('admin/mensajes') ?>" method="get" class="d-flex flex-wrap align-items-end w-100">
            <div class="me-3 mb-2 mb-md-0">
                <select class="form-select form-select-sm" id="tipo_mensaje" name="tipo_mensaje">
                    <option value="">Filtrar por Tipo</option>
                    <option value="cliente" <?= (isset($filtro_tipo) && $filtro_tipo == 'cliente') ? 'selected' : '' ?>>Cliente</option>
                    <option value="contacto" <?= (isset($filtro_tipo) && $filtro_tipo == 'contacto') ? 'selected' : '' ?>>Contacto</option>
                </select>
            </div>

            <div class="me-3 mb-2 mb-md-0">
                <select class="form-select form-select-sm" id="estado_mensaje" name="estado_mensaje">
                    <option value="">Filtrar por Estado</option>
                    <option value="no_leido" <?= (isset($filtro_estado) && $filtro_estado == 'no_leido') ? 'selected' : '' ?>>Nuevos</option>
                    <option value="leido" <?= (isset($filtro_estado) && $filtro_estado == 'leido') ? 'selected' : '' ?>>Leídos</option>
                </select>
            </div>

            <div class="me-3 mb-2 mb-md-0">
                <input type="date" class="form-control form-control-sm" id="fecha_mensaje" name="fecha_mensaje" value="<?= esc($filtro_fecha ?? '') ?>" title="Filtrar por Fecha">
            </div>
            
            <div class="me-2 mb-2 mb-md-0">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search me-1"></i> Aplicar</button>
            </div>
            <div class="mb-2 mb-md-0">
                <a href="<?= base_url('admin/mensajes') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-redo me-1"></i> Limpiar</a>
            </div>
        </form>
    </div>
    
    <div class="card shadow-lg mb-4">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Lista de Mensajes</h5>
        </div>
        <div class="card-body" id="messagesTableContainer"> <?php if (empty($mensajes)): ?>
                <div class="alert alert-info text-center" role="alert">
                    No hay mensajes por el momento.
                </div>
            <?php else: ?>
                <div class="messages-list-mobile-view">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Estado</th>
                                    <th>Asunto</th>
                                    <th>Remitente</th>
                                    <th>Email Remitente</th>
                                    <th>Fecha de Envío</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($mensajes as $mensaje): ?>
                                    <tr id="message-row-<?= esc($mensaje['id_mensaje']) ?>" class="<?= $mensaje['leido'] ? 'text-muted' : 'fw-bold'; ?>">
                                        <td>
                                            <?php if (($mensaje['tipo_mensaje'] ?? null) == 'cliente'): ?>
                                                <span class="badge bg-primary"><i class="fas fa-user-circle me-1"></i> Cliente</span>
                                            <?php else: ?>
                                                <span class="badge bg-info text-dark"><i class="fas fa-paper-plane me-1"></i> Contacto</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="message-status">
                                            <?php if ($mensaje['leido']): ?>
                                                <i class="fas fa-check-circle text-success me-1"></i> Leído
                                            <?php else: ?>
                                                <i class="fas fa-exclamation-circle text-warning me-1"></i> Nuevo
                                            <?php endif; ?>
                                        </td>
                                        <td><?= esc($mensaje['asunto'] ?? 'N/A') ?></td>
                                        <td><?= esc($mensaje['nombre_remitente'] ?? 'N/A') ?></td>
                                        <td><?= esc($mensaje['email_remitente'] ?? 'N/A') ?></td>
                                        <td><?= esc($mensaje['fecha_envio_formato'] ?? 'N/A') ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-outline-info view-message-btn"
                                                    data-bs-toggle="modal" data-bs-target="#messageModal"
                                                    data-asunto="<?= esc($mensaje['asunto'] ?? 'Sin Asunto') ?>"
                                                    data-remitente="<?= esc($mensaje['nombre_remitente'] ?? 'Anónimo') ?>"
                                                    data-email="<?= esc($mensaje['email_remitente'] ?? 'N/A') ?>"
                                                    data-tipo="<?= esc($mensaje['tipo_mensaje'] ?? 'desconocido') ?>"
                                                    data-fecha="<?= esc($mensaje['fecha_envio_formato'] ?? 'N/A') ?>"
                                                    data-mensaje="<?= esc($mensaje['mensaje'] ?? 'Mensaje vacío') ?>"
                                                    data-id="<?= esc($mensaje['id_mensaje'] ?? '') ?>"
                                                    data-leido="<?= esc($mensaje['leido'] ?? 0) ?>">
                                                <i class="fas fa-eye"></i> Ver
                                            </button>
                                            <?php if (!($mensaje['leido'] ?? 0)): ?>
                                                <button type="button" class="btn btn-sm btn-outline-success mark-read-btn"
                                                        data-id="<?= esc($mensaje['id_mensaje'] ?? '') ?>">
                                                    <i class="fas fa-check"></i> Leído
                                                </button>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-message-btn"
                                                    data-id="<?= esc($mensaje['id_mensaje'] ?? '') ?>">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="messages-list-mobile-triggers">
                        <?php foreach ($mensajes as $mensaje): ?>
                            <div class="message-item-trigger view-message-btn <?= $mensaje['leido'] ? 'text-muted' : 'fw-bold'; ?>"
                                 id="message-trigger-<?= esc($mensaje['id_mensaje']) ?>"
                                 data-bs-toggle="modal" data-bs-target="#messageModal"
                                 data-asunto="<?= esc($mensaje['asunto'] ?? 'Sin Asunto') ?>"
                                 data-remitente="<?= esc($mensaje['nombre_remitente'] ?? 'Anónimo') ?>"
                                 data-email="<?= esc($mensaje['email_remitente'] ?? 'N/A') ?>"
                                 data-tipo="<?= esc($mensaje['tipo_mensaje'] ?? 'desconocido') ?>"
                                 data-fecha="<?= esc($mensaje['fecha_envio_formato'] ?? 'N/A') ?>"
                                 data-mensaje="<?= esc($mensaje['mensaje'] ?? 'Mensaje vacío') ?>"
                                 data-id="<?= esc($mensaje['id_mensaje'] ?? '') ?>"
                                 data-leido="<?= esc($mensaje['leido'] ?? 0) ?>">
                                
                                <div class="message-content-wrapper">
                                    <div>
                                        <?php if (($mensaje['tipo_mensaje'] ?? null) == 'cliente'): ?>
                                            <span class="badge bg-primary message-type-badge"><i class="fas fa-user-circle me-1"></i> Cliente</span>
                                        <?php else: ?>
                                            <span class="badge bg-info text-dark message-type-badge"><i class="fas fa-paper-plane me-1"></i> Contacto</span>
                                        <?php endif; ?>
                                    </div>
                                    <strong class="d-block mt-1"><?= esc($mensaje['asunto'] ?? 'Sin Asunto') ?></strong>
                                    <small class="d-block text-muted"><?= esc($mensaje['nombre_remitente'] ?? 'N/A') ?> - <?= esc($mensaje['fecha_envio_formato'] ?? 'N/A') ?></small>
                                </div>

                                <div class="message-status-text">
                                    <?php if ($mensaje['leido']): ?>
                                        <i class="fas fa-check-circle text-success message-status-icon"></i> <span class="d-none d-sm-inline">Leído</span>
                                    <?php else: ?>
                                        <i class="fas fa-exclamation-circle text-warning message-status-icon"></i> <span class="d-none d-sm-inline">Nuevo</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="messageModalLabel">Detalle del Mensaje</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="modalHeaderInfo"></p>
                <hr>
                <p><strong>Mensaje:</strong></p>
                <p id="modalMensaje"></p>
            </div>
            <div class="modal-footer">
                <button type="button" id="modalMarkReadBtn" class="btn btn-success">
                    <i class="fas fa-check me-1"></i> Marcar como Leído
                </button>
                <button type="button" id="modalDeleteBtn" class="btn btn-danger">
                    <i class="fas fa-trash-alt me-1"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para mostrar alertas dinámicas
    function showAlert(message, type) {
        var alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        var container = document.getElementById('dynamicAlertContainer');
        container.innerHTML = ''; // Limpiar alertas anteriores
        container.appendChild(document.createRange().createContextualFragment(alertHtml));

        setTimeout(function() {
            var bsAlert = bootstrap.Alert.getInstance(container.querySelector('.alert'));
            if (bsAlert) bsAlert.close();
        }, 5000);
    }

    // Lógica para el modal de visualización de mensajes
    var messageModal = document.getElementById('messageModal');
    messageModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;

        var asunto = button.getAttribute('data-asunto');
        var remitente = button.getAttribute('data-remitente');
        var email = button.getAttribute('data-email');
        var tipo = button.getAttribute('data-tipo');
        var fecha = button.getAttribute('data-fecha');
        var mensaje = button.getAttribute('data-mensaje');
        var idMensaje = button.getAttribute('data-id');
        var leido = button.getAttribute('data-leido');

        var modalHeaderInfo = messageModal.querySelector('#modalHeaderInfo');
        var modalMensaje = messageModal.querySelector('#modalMensaje');
        var modalMarkReadBtn = messageModal.querySelector('#modalMarkReadBtn');
        var modalDeleteBtn = messageModal.querySelector('#modalDeleteBtn'); // Asegurarse de tener este id en el botón de eliminar del modal

        var tipoHtml;
        if (tipo === 'cliente') {
            tipoHtml = '<span class="badge bg-primary me-1"><i class="fas fa-user-circle me-1"></i> Cliente</span>';
        } else {
            tipoHtml = '<span class="badge bg-info text-dark me-1"><i class="fas fa-paper-plane me-1"></i> Contacto</span>';
        }

        modalHeaderInfo.innerHTML = `
            <div class="d-flex flex-wrap align-items-center mb-1">
                <strong>Asunto:</strong> <span class="text-break">${asunto}</span>
            </div>
            <div class="mb-1">
                <strong>De:</strong> <span class="text-break">${remitente} / ${email}</span>
            </div>
            <div>
                <strong>Fecha:</strong> ${fecha}
            </div>
        `;
        
        modalMensaje.textContent = mensaje;
        
        // Lógica para el botón "Marcar como Leído" dentro del modal
        if (leido == 0) {
            modalMarkReadBtn.style.display = 'inline-block';
            modalMarkReadBtn.setAttribute('data-id', idMensaje);
            modalMarkReadBtn.onclick = function() {
                markMessageAsRead(idMensaje);
                var bsModal = bootstrap.Modal.getInstance(messageModal);
                if (bsModal) bsModal.hide();
            };
        } else {
            modalMarkReadBtn.style.display = 'none';
            modalMarkReadBtn.removeAttribute('data-id');
            modalMarkReadBtn.onclick = null;
        }

        // Lógica para el botón "Eliminar" dentro del modal
        modalDeleteBtn.setAttribute('data-id', idMensaje);
        modalDeleteBtn.onclick = function() {
            if (confirm('¿Estás seguro de eliminar este mensaje? Esta acción no se puede deshacer.')) {
                deleteMessage(idMensaje);
                var bsModal = bootstrap.Modal.getInstance(messageModal);
                if (bsModal) bsModal.hide();
            }
        };
    });

    // --- LÓGICA AJAX para "Marcar como Leído" ---
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('mark-read-btn') || event.target.closest('.mark-read-btn')) {
            event.preventDefault();
            var button = event.target.closest('.mark-read-btn');
            var idMensaje = button.getAttribute('data-id');

            // La confirmación ya se hace desde el modal, si se activa desde allí.
            // Si se activa desde la tabla (desktop), preguntamos.
            if (!event.target.closest('#messageModal') || confirm('¿Estás seguro de marcar este mensaje como leído?')) {
                markMessageAsRead(idMensaje);
            }
        }
    });

    function markMessageAsRead(idMensaje) {
        fetch(`<?= base_url('admin/mensajes/marcar-leido/') ?>${idMensaje}`)
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Error desconocido.');
                    });
                }
                return response.json();
            })
            .then(data => {
                showAlert(data.message, data.status);
                if (data.status === 'success') {
                    // Actualizar fila de la tabla desktop
                    var row = document.getElementById(`message-row-${idMensaje}`);
                    if (row) {
                        row.classList.remove('fw-bold');
                        row.classList.add('text-muted');
                        
                        var statusCell = row.querySelector('.message-status');
                        if (statusCell) {
                            statusCell.innerHTML = '<i class="fas fa-check-circle text-success me-1"></i> Leído';
                        }
                        var markReadButtonInTable = row.querySelector('.mark-read-btn');
                        if (markReadButtonInTable) {
                            markReadButtonInTable.remove();
                        }
                    }

                    // Actualizar trigger móvil
                    var trigger = document.getElementById(`message-trigger-${idMensaje}`);
                    if (trigger) {
                        trigger.classList.remove('fw-bold');
                        trigger.classList.add('text-muted');
                        var statusText = trigger.querySelector('.message-status-text');
                        if (statusText) {
                            statusText.innerHTML = '<i class="fas fa-check-circle text-success message-status-icon"></i> <span class="d-none d-sm-inline">Leído</span>';
                        }
                    }
                }
            })
            .catch(error => {
                console.error('Error AJAX (Marcar Leído):', error);
                showAlert(error.message || 'Error al procesar la solicitud de marcado.', 'danger');
            });
    }

    // --- LÓGICA AJAX para "Eliminar Mensaje" ---
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-message-btn') || event.target.closest('.delete-message-btn')) {
            event.preventDefault();

            var button = event.target.closest('.delete-message-btn');
            var idMensaje = button.getAttribute('data-id');

            // La confirmación ya se hace desde el modal, si se activa desde allí.
            // Si se activa desde la tabla (desktop), preguntamos.
            if (!event.target.closest('#messageModal') || confirm('¿Estás seguro de eliminar este mensaje? Esta acción no se puede deshacer.')) {
                deleteMessage(idMensaje);
            }
        }
    });

    function deleteMessage(idMensaje) {
        fetch(`<?= base_url('admin/mensajes/eliminar/') ?>${idMensaje}`, {
            method: 'GET'
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(errorData => {
                    throw new Error(errorData.message || 'Error desconocido al eliminar.');
                });
            }
            return response.json();
        })
        .then(data => {
            showAlert(data.message, data.status);
            if (data.status === 'success') {
                // Remover fila de la tabla desktop
                var row = document.getElementById(`message-row-${idMensaje}`);
                if (row) {
                    row.remove();
                }
                // Remover trigger móvil
                var trigger = document.getElementById(`message-trigger-${idMensaje}`);
                if (trigger) {
                    trigger.remove();
                }
            }
        })
        .catch(error => {
            console.error('Error AJAX (Eliminar Mensaje):', error);
            showAlert(error.message || 'Error al eliminar el mensaje.', 'danger');
        });
    }
    // --- FIN LÓGICA AJAX para acciones de tabla ---

    // --- LÓGICA para el filtro (SIN AJAX, con recarga de página) ---
    var filterForm = document.getElementById('filterForm');
    var selectTipoMensaje = document.getElementById('tipo_mensaje');
    var selectEstadoMensaje = document.getElementById('estado_mensaje'); 
    var inputFechaMensaje = document.getElementById('fecha_mensaje'); 
    var clearFilterBtn = document.querySelector('#filterForm .btn-secondary');

    clearFilterBtn.addEventListener('click', function() {
        selectTipoMensaje.value = '';
        selectEstadoMensaje.value = '';
        inputFechaMensaje.value = ''; 
        filterForm.submit(); // El botón limpiar sí envía el formulario
    });
});
</script>

<?= $this->endSection() ?>