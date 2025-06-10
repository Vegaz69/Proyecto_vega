<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<header class="text-center bg-primary text-white">
    <h1>Comercialización</h1>
</header>

<div class="container my-3">

    <!-- Tarjetas de Métodos de Pago, Envíos y Garantía -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <div class="col">
            <div class="card text-center p-4">
                <i class="bi bi-credit-card fs-1 text-primary"></i>
                <h5>Métodos de Pago</h5>
                <p>Aceptamos tarjetas, PayPal y transferencias bancarias.</p>
            </div>
        </div>
        <div class="col">
            <div class="card text-center p-4">
                <i class="bi bi-truck fs-1 text-success"></i>
                <h5>Opciones de Envío</h5>
                <p>Envío estándar y urgente a domicilio o puntos de retiro.</p>
            </div>
        </div>
        <div class="col">
            <div class="card text-center p-4">
                <i class="bi bi-shield-check fs-1 text-warning"></i>
                <h5>Garantía y Soporte</h5>
                <p>Productos con garantía y atención al cliente postventa.</p>
            </div>
        </div>
    </div>

    <!-- Tabla de Costos y Métodos de Envío -->
    <div class="table-responsive my-5">
        <h2 class="text-center mb-4">Costos y Métodos de Envío</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Tipo de Envío</th>
                    <th>Tiempo Estimado</th>
                    <th>Costo</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Estándar</td>
                    <td>5-7 días hábiles</td>
                    <td>$5.99</td>
                </tr>
                <tr>
                    <td>Urgente</td>
                    <td>2-3 días hábiles</td>
                    <td>$12.99</td>
                </tr>
                <tr>
                    <td>Internacional</td>
                    <td>10-15 días hábiles</td>
                    <td>$19.99</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Guía rápida sobre devoluciones y cambios -->
    <div class="my-5 p-4 bg-light border rounded">
        <h2 class="text-center mb-4">Guía rápida sobre devoluciones y cambios</h2>
        <p class="text-center">Si el producto no cumple con tus expectativas, ofrecemos **devolución gratuita** en un plazo de 30 días.</p>
        <ul>
            <li><strong>Plazo de devolución:</strong> Hasta 30 días después de la compra.</li>
            <li><strong>Condiciones:</strong> Producto sin uso y en su empaque original.</li>
            <li><strong>Proceso:</strong> Solicítalo desde tu perfil y envía el paquete con la etiqueta generada.</li>
            <li><strong>Reembolsos:</strong> Se procesan en un máximo de 7 días hábiles.</li>
        </ul>
    </div>

    <!-- Beneficios por suscripción o descuentos en primera compra -->
    <div class="my-5 p-4 bg-light border rounded">
        <h2 class="text-center mb-4">Beneficios Exclusivos</h2>
        <p class="text-center">¡Regístrate y obtén un **10% de descuento en tu primera compra**! Además, accede a promociones y eventos exclusivos.</p>
        <ul>
            <li><strong>Suscripción gratuita:</strong> Únete a nuestra comunidad sin costos adicionales.</li>
            <li><strong>Descuento inmediato:</strong> 10% en tu primera compra al registrarte.</li>
            <li><strong>Acceso a ofertas especiales:</strong> Recibe descuentos exclusivos y lanzamientos anticipados.</li>
        </ul>
    </div>

    <!-- Sección de Preguntas Frecuentes -->
    <div class="accordion my-5" id="faqAccordion">
        <h2 class="text-center mb-4">Preguntas Frecuentes</h2>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                    ¿Cuáles son los métodos de pago disponibles?
                </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Aceptamos tarjetas de crédito, PayPal y transferencias bancarias.
                </div>
            </div>
        </div>
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                    ¿Cuánto tiempo tarda la entrega?
                </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    Depende del tipo de envío. Estándar (5-7 días), Urgente (2-3 días) e Internacional (10-15 días).
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>