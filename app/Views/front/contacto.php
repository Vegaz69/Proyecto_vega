<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div class="container my-4">
    <h1 class="text-center mb-4 display-4 fw-bold text-dark">¿Necesitas Ayuda? Contáctanos</h1>
    <p class="lead text-center mb-5 text-muted">Estamos aquí para responder a todas tus preguntas y brindarte el mejor soporte.</p>

    <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
        <div class="col">
            <div class="card h-100 shadow-sm border-0 transform-on-hover">
                <div class="card-body p-4">
                    <h4 class="card-title text-center mb-4 fw-bold"><i class="bi bi-building me-2"></i> Información de la Empresa</h4>
                    <p class="mb-2"><strong class="text-primary">Razón Social:</strong> TRY-HARDWARE S.A.</p>
                    <p class="mb-2"><strong class="text-primary">Titular:</strong> Zini Samuel - Vega Jose Maria</p>
                    <p class="mb-2"><strong class="text-primary">Domicilio Legal:</strong> Avenida Central 1234, Buenos Aires, Argentina</p>
                    <hr>
                    <h4 class="card-title text-center mb-4 fw-bold"><i class="bi bi-clock me-2"></i> Horario de Atención</h4>
                    <p class="mb-2"><strong class="text-primary">Lunes a Viernes:</strong> 9:00 AM - 6:00 PM</p>
                    <p class="mb-0"><strong class="text-primary">Sábados:</strong> 10:00 AM - 3:00 PM</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 shadow-sm border-0 transform-on-hover">
                <div class="card-body p-4">
                    <h4 class="card-title text-center mb-4 fw-bold"><i class="bi bi-phone me-2"></i> Contacto Directo</h4>
                    <p class="mb-3 text-center">
                        <a href="https://wa.me/541112345678" target="_blank" class="btn btn-success btn-lg rounded-pill px-4 shadow">
                            <i class="bi bi-whatsapp me-2"></i> Contactar por WhatsApp
                        </a>
                    </p>
                    <p class="mb-2 text-center"><strong class="text-primary">Teléfono Fijo:</strong> +54 11 4567-8900</p>
                    <hr>
                    <p class="mb-0 text-center"><strong class="text-primary">Correo Electrónico:</strong> contacto@techsolutions.com.ar</p>
                    <p class="mb-0 text-center text-muted small">Ideal para consultas detalladas o adjuntar documentos.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5 justify-content-center">
        <div class="col-12 col-md-10 col-lg-8"> 
            <h2 class="text-center mb-4 fw-bold text-dark">Nuestra Ubicación</h2>
            <div class="ratio ratio-16x9 rounded shadow-sm">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3284.016887889506!2d-58.3815923847844!3d-34.60370398045938!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95bccac4274c1071%3A0x6b4c101c7a8f1e6!2sObelisco%20de%20Buenos%20Aires!5e0!3m2!1ses-419!4v1678912345678!5m2!1ses-419!2sAR"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <p class="text-center text-muted small mt-3">Visítanos en nuestra oficina principal. ¡Te esperamos!</p>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="text-center mb-4 fw-bold text-dark">Envíanos tu Consulta</h2>
            <form class="p-4 p-md-5 bg-light border rounded shadow-lg" method="post" action="<?= base_url('enviar-contacto') ?>">
                <?= csrf_field() ?>
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
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="nombreCompleto" class="form-label fw-bold">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombreCompleto" name="nombre_completo" placeholder="Escribe tu nombre" value="<?= old('nombre_completo') ?>" required>
                    <div class="invalid-feedback">
                        Por favor, ingresa tu nombre completo.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="correoElectronico" class="form-label fw-bold">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correoElectronico" name="email" placeholder="ejemplo@dominio.com" value="<?= old('email') ?>" required>
                    <div class="invalid-feedback">
                        Por favor, ingresa un correo electrónico válido.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="asunto" class="form-label fw-bold">Asunto</label>
                    <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Escribe el asunto de tu consulta" value="<?= old('asunto') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="mensaje" class="form-label fw-bold">Mensaje</label>
                    <textarea class="form-control" id="mensaje" name="mensaje" rows="6" placeholder="Escribe tu consulta aquí..." required><?= old('mensaje') ?></textarea>
                    <div class="invalid-feedback">
                        Por favor, ingresa tu mensaje.
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow">
                        <i class="bi bi-send-fill me-2"></i> Enviar Consulta
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>