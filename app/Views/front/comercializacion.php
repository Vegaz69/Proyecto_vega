<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div class="container my-3">
    <h1 class="text-center mb-4 display-4 fw-bold text-dark">
        Nuestras Políticas y Beneficios
    </h1>
    <p class="lead text-center mb-5 text-muted">
        Descubre cómo TRY-HARDWARE facilita tus compras, envíos y te ofrece el mejor
        soporte.
    </p>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
        <div class="col">
            <div class="card h-100 shadow-sm border-0 transform-on-hover">
                <div class="card-body text-center p-4">
                    <i class="bi bi-credit-card fs-1 text-primary mb-3"></i>
                    <h5 class="card-title fw-bold">Métodos de Pago Seguros</h5>
                    <p class="card-text text-muted">
                        Aceptamos las principales tarjetas de crédito y débito, PayPal y
                        transferencias bancarias para tu comodidad.
                    </p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 shadow-sm border-0 transform-on-hover">
                <div class="card-body text-center p-4">
                    <i class="bi bi-truck fs-1 text-success mb-3"></i>
                    <h5 class="card-title fw-bold">Opciones de Envío Flexibles</h5>
                    <p class="card-text text-muted">
                        Elige entre envío estándar y urgente a domicilio, o retira en puntos
                        de recogida autorizados. ¡Tú decides!
                    </p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 shadow-sm border-0 transform-on-hover">
                <div class="card-body text-center p-4">
                    <i class="bi bi-shield-check fs-1 text-warning mb-3"></i>
                    <h5 class="card-title fw-bold">Garantía y Soporte Confiable</h5>
                    <p class="card-text text-muted">
                        Todos nuestros productos cuentan con garantía. Además, te brindamos
                        atención al cliente dedicada postventa.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5 justify-content-center">
        <div class="col-lg-8">
            <h2 class="text-center mb-4 fw-bold text-dark">
                Detalle de Costos de Envío
            </h2>
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Tipo de Envío</th>
                            <th scope="col">Tiempo Estimado</th>
                            <th scope="col">Costo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="bi bi-box-seam me-2"></i>Estándar</td>
                            <td>5-7 días hábiles</td>
                            <td>$5.99</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-lightning-charge me-2"></i>Urgente</td>
                            <td>2-3 días hábiles</td>
                            <td>$12.99</td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-globe me-2"></i>Internacional</td>
                            <td>10-15 días hábiles</td>
                            <td>$19.99</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="p-5 bg-light border rounded shadow-sm">
                <h2 class="text-center mb-4 fw-bold text-dark">
                    Política de Devoluciones y Cambios
                </h2>

                <p class="lead text-center text-muted mb-4">
                    Tu satisfacción es nuestra prioridad. Ofrecemos
                    <strong>devolución gratuita</strong> en un plazo de 30 días si el
                    producto no cumple tus expectativas.
                </p>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-start bg-transparent border-0 px-0">
                        <i class="bi bi-calendar-check-fill text-info fs-5 me-3 mt-1"></i>
                        <div>
                            <strong>Plazo de devolución:</strong><br />
                            Hasta 30 días después de la compra.
                        </div>
                    </li>

                    <li class="list-group-item d-flex align-items-start bg-transparent border-0 px-0">
                        <i class="bi bi-box-seam-fill text-info fs-5 me-3 mt-1"></i>
                        <div>
                            <strong>Condiciones:</strong><br />
                            Producto sin uso, en perfectas condiciones y con su empaque
                            original intacto.
                        </div>
                    </li>

                    <li class="list-group-item d-flex align-items-start bg-transparent border-0 px-0">
                        <i class="bi bi-arrow-return-right text-info fs-5 me-3 mt-1"></i>
                        <div>
                            <strong>Proceso Sencillo:</strong><br />
                            Solicita la devolución desde tu perfil de usuario y sigue los
                            pasos para generar la etiqueta de envío.
                        </div>
                    </li>

                    <li class="list-group-item d-flex align-items-start bg-transparent border-0 px-0">
                        <i class="bi bi-wallet-fill text-info fs-5 me-3 mt-1"></i>
                        <div>
                            <strong>Reembolsos Rápidos:</strong><br />
                            Procesamos tu reembolso en un máximo de 7 días hábiles una vez
                            recibido y verificado el producto.
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- <div class="row justify-content-center mb-5">
        <div class="col-lg-10">
            <div class="p-5 bg-warning text-white rounded shadow-lg text-center">
                <h2 class="mb-4 display-6 fw-bold">¡Beneficios Exclusivos para Ti!</h2>
                <p class="lead mb-4">¡Regístrate hoy en TRY-HARDWARE y obtén un **10% de descuento en tu primera compra**!</p>
                <p class="mb-4">Además, como miembro, tendrás acceso prioritario a promociones, lanzamientos y eventos exclusivos.</p>
                <a href="<?= base_url('registro'); ?>" class="btn btn-dark btn-lg rounded-pill px-5 py-3 shadow-lg">
                    <i class="fas fa-user-plus me-2"></i> ¡Regístrate Ahora y Ahorra!
                </a>
            </div>
        </div>
    </div> -->

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="text-center mb-4 fw-bold text-dark">
                Preguntas Frecuentes (FAQ)
            </h2>
            <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            ¿Cuáles son los métodos de pago disponibles?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Aceptamos una amplia variedad de métodos de pago para tu
                            conveniencia, incluyendo tarjetas de crédito (Visa, MasterCard,
                            American Express), tarjetas de débito, PayPal, y transferencias
                            bancarias directas. Todas las transacciones son seguras y están
                            encriptadas.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            ¿Cuánto tiempo tarda la entrega de mi pedido?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            El tiempo de entrega varía según el método de envío seleccionado:
                            <ul>
                                <li>**Envío Estándar:** 5-7 días hábiles.</li>
                                <li>**Envío Urgente:** 2-3 días hábiles.</li>
                                <li>**Envío Internacional:** 10-15 días hábiles.</li>
                            </ul>
                            Los tiempos son estimados y pueden variar según la ubicación y
                            disponibilidad del producto.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            ¿Qué pasa si necesito devolver un producto?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            Nuestra política de devoluciones te permite devolver cualquier
                            producto dentro de los 30 días posteriores a la compra, siempre
                            que esté sin usar y en su empaque original. El proceso es sencillo
                            y el reembolso se procesa en 7 días hábiles. Consulta nuestra
                            sección de "Política de Devoluciones y Cambios" para más detalles.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            ¿Ofrecen descuentos para nuevos usuarios o suscriptores?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                        data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            ¡Sí! Al registrarte por primera vez en TRY-HARDWARE, obtendrás
                            automáticamente un 10% de descuento en tu primera compra. Además,
                            al suscribirte a nuestro boletín, recibirás notificaciones sobre
                            ofertas exclusivas y eventos especiales.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>