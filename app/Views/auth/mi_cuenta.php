<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div class="container my-3">
    <h1 class="text-center fw-bold text-primary mb-3">⚙️ Mi Cuenta</h1>

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
    <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li>
                <?= esc($error) ?>
            </li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-lg p-4 rounded-3">
                <ul class="nav nav-tabs mb-4" id="myAccountTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                            type="button" role="tab" aria-controls="info" aria-selected="true">
                            <i class="fas fa-user me-2"></i>Mi Información
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="email-pass-tab" data-bs-toggle="tab" data-bs-target="#email-pass"
                            type="button" role="tab" aria-controls="email-pass" aria-selected="false">
                            <i class="fas fa-key me-2"></i>Seguridad
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders"
                            type="button" role="tab" aria-controls="orders" aria-selected="false">
                            <i class="fas fa-box-open me-2"></i>Mis Pedidos
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="messages-tab" data-bs-toggle="tab" data-bs-target="#messages"
                            type="button" role="tab" aria-controls="messages" aria-selected="false">
                            <i class="fas fa-envelope me-2"></i>Mensajes
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="myAccountTabContent">
                    <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                        <h4 class="mb-4 text-center text-secondary">Datos Personales</h4>
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <div class="border rounded bg-light p-2"><?= esc($usuario['nombre']) ?></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Apellido</label>
                            <div class="border rounded bg-light p-2"><?= esc($usuario['apellido']) ?></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <div class="border rounded bg-light p-2"><?= esc($usuario['email']) ?></div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="email-pass" role="tabpanel" aria-labelledby="email-pass-tab">
                        <h4 class="mb-4 text-center text-secondary">Actualizar Datos de Acceso</h4>
                        <form action="<?= base_url('mi-cuenta/actualizar'); ?>" method="post">
                            <?= csrf_field() ?>

                            <h5 class="mb-3 text-primary"><i class="fas fa-envelope me-2"></i>Cambiar Correo Electrónico
                            </h5>
                            <div class="mb-3">
                                <label for="email" class="form-label">Nuevo Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="<?= old('email', $usuario['email']) ?>" required>
                                <small class="form-text text-muted">Ingresa tu nuevo correo electrónico.</small>
                            </div>
                            <div class="mb-4">
                                <label for="email_current_password" class="form-label">Contraseña Actual</label>
                                <input type="password" class="form-control" id="email_current_password"
                                    name="email_current_password" placeholder="Verifica tu contraseña actual"
                                    autocomplete="off">
                                <small class="form-text text-danger">Obligatorio si se cambia el correo.</small>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3 text-primary"><i class="fas fa-lock me-2"></i>Cambiar Contraseña</h5>
                            <div class="mb-3">
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Mínimo 6 caracteres" autocomplete="new-password">
                                <small class="form-text text-muted">Dejar en blanco para no cambiar.</small>
                            </div>

                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" placeholder="Repetir nueva contraseña"
                                    autocomplete="new-password">
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3">Guardar Cambios</button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                        <h4 class="mb-4 text-center text-secondary">Mi Historial de Pedidos</h4>
                        <p class="text-center">Aquí podrás ver todos los detalles de tus compras anteriores.</p>
                        <a href="<?= base_url('mis-pedidos'); ?>" class="btn btn-info w-100">Ver Mis Pedidos</a>
                    </div>

                    <div class="tab-pane fade" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                        <h4 class="mb-4 text-center text-secondary">Enviar Mensaje al Administrador</h4>
                        <form action="<?= base_url('mi-cuenta/enviar-mensaje'); ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="subject" name="subject"
                                    value="<?= old('subject') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="message" name="message" rows="5"
                                    required><?= old('message') ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3">Enviar Mensaje</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>