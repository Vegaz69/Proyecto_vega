<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<header class="text-center bg-primary text-white">
    <h1>Información de Contacto</h1>
</header>

<div class="container my-3">

    <!-- Datos de la empresa -->
    <div class="row row-cols-1 row-cols-md-2 g-4">
        <div class="col">
            <div class="card p-4">
                <h5>Razón Social:</h5>
                <p>TRY-HARDWARE S.A.</p>
                <h5>Titular:</h5>
                <p>Carlos Méndez</p>
                <h5>Domicilio Legal:</h5>
                <p>Avenida Central 1234, Buenos Aires, Argentina</p>
                <h5>Horario de Atención:</h5>
                <p>Lunes a Viernes: 9:00 AM - 6:00 PM</p>
                <p>Sábados: 10:00 AM - 3:00 PM</p>
            </div>
        </div>
        <div class="col">
            <div class="card p-4">
                <h5>Teléfonos:</h5>
                <p>
                    <a href="https://wa.me/541112345678" target="_blank" class="btn btn-success btn-sm d-block">
                        <i class="bi bi-whatsapp"></i> Contactar por WhatsApp
                    </a>
                </p>
                <p>+54 11 4567-8900</p>
                <h5>Correo Electrónico:</h5>
                <p>contacto@techsolutions.com.ar</p>
            </div>
        </div>
    </div>

    <!-- Cuestionario de Contacto -->
      <div class="my-5">
        <h2 class="text-center mb-4">Envíanos tu consulta</h2>
        <form class="p-4 bg-light border rounded">
            <div class="mb-3">
                <label class="form-label">Nombre Completo</label>
                <input type="text" class="form-control" placeholder="Escribe tu nombre" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" placeholder="Escribe tu email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mensaje</label>
                <textarea class="form-control" rows="4" placeholder="Escribe tu consulta" required></textarea>
            </div>
        <button type="button" class="btn btn-primary w-100" onclick="window.location.href='<?= base_url('construccion') ?>'">Enviar Consulta</button>
        </form>
       <script>
    function redirigirConstruccion() {
        window.location.href = "public/index.html"; // Redirige a la nueva vista
    }
</script>
    </div>

<?= $this->endSection() ?>