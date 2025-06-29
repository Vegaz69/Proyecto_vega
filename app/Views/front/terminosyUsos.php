<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div class="container my-3">
    <h1 class="text-center mb-4 display-4 fw-bold text-dark">Términos y Condiciones de Uso</h1>
    <p class="lead text-center mb-5 text-muted">A continuación, detallamos las condiciones que rigen el uso de nuestro
        sitio web y la relación con nuestros clientes.</p>

    <div class="p-4 p-md-5 bg-light border rounded shadow-sm mb-5">
        <h5 class="text-end text-muted mb-3"><strong class="text-dark">Última actualización:</strong> Abril 2025</h5>
        <p class="fs-5 text-dark mb-0">Bienvenido a <strong class="text-primary">TRY-HARDWARE</strong>. Le recomendamos
            encarecidamente que lea detenidamente los siguientes **Términos y Condiciones de Uso** antes de utilizar
            nuestros servicios y productos. Al acceder y usar este sitio web, usted acepta estar sujeto a estos términos
            en su totalidad.</p>
    </div>

    <div class="accordion mb-5" id="accordionUse">
        <h2 class="text-center mb-4 fw-bold text-dark">1. Uso del Sitio Web</h2>
        <div class="accordion-item shadow-sm mb-3 rounded">
            <h2 class="accordion-header" id="headingUse1">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseUse1" aria-expanded="false" aria-controls="collapseUse1">
                    <i class="bi bi-person-check-fill me-3 text-primary"></i> Responsabilidad del Usuario
                </button>
            </h2>
            <div id="collapseUse1" class="accordion-collapse collapse" aria-labelledby="headingUse1"
                data-bs-parent="#accordionUse">
                <div class="accordion-body text-muted">
                    El usuario se compromete a utilizar la plataforma de manera legal, ética y conforme a estos Términos
                    y Condiciones. Queda prohibido cualquier uso que pueda dañar, deshabilitar, sobrecargar o perjudicar
                    el sitio web o interferir en el uso y disfrute del mismo por parte de terceros.
                </div>
            </div>
        </div>
        <div class="accordion-item shadow-sm mb-3 rounded">
            <h2 class="accordion-header" id="headingUse2">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseUse2" aria-expanded="false" aria-controls="collapseUse2">
                    <i class="bi bi-arrow-repeat me-3 text-success"></i> Modificaciones y Actualizaciones
                </button>
            </h2>
            <div id="collapseUse2" class="accordion-collapse collapse" aria-labelledby="headingUse2"
                data-bs-parent="#accordionUse">
                <div class="accordion-body text-muted">
                    Nos reservamos el derecho de actualizar, modificar o eliminar contenido, precios, disponibilidad de
                    productos y cualquier aspecto del sitio web sin previo aviso. Es responsabilidad del usuario revisar
                    periódicamente estos términos para estar al tanto de los cambios.
                </div>
            </div>
        </div>
        <div class="accordion-item shadow-sm mb-3 rounded">
            <h2 class="accordion-header" id="headingUse3">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseUse3" aria-expanded="false" aria-controls="collapseUse3">
                    <i class="bi bi-lock-fill me-3 text-danger"></i> Seguridad y Prohibiciones
                </button>
            </h2>
            <div id="collapseUse3" class="accordion-collapse collapse" aria-labelledby="headingUse3"
                data-bs-parent="#accordionUse">
                <div class="accordion-body text-muted">
                    Está estrictamente prohibido cualquier intento de acceso no autorizado, ataque informático,
                    introducción de virus o malware, o cualquier uso indebido del sitio web que comprometa su seguridad
                    o integridad. Nos reservamos el derecho de tomar acciones legales contra cualquier infracción.
                </div>
            </div>
        </div>
    </div>

    <div class="bg-light p-4 p-md-5 border rounded shadow-sm mb-5">
        <h2 class="text-center mb-4 fw-bold text-dark">2. Servicios y Productos</h2>
        <p class="text-muted mb-4">TRY-HARDWARE ofrece una amplia gama de componentes de hardware y accesorios para
            computadoras, incluyendo procesadores, tarjetas gráficas, memorias RAM, dispositivos de almacenamiento y
            periféricos de alta calidad.</p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex align-items-start border-0 bg-transparent px-0 pb-2">
                <i class="bi bi-award-fill text-success fs-5 me-3"></i>
                <div>
                    <h5 class="fw-bold mb-0">Garantía de Productos</h5>
                    <p class="text-muted mb-0">Todos los productos comercializados en TRY-HARDWARE cuentan con la
                        garantía oficial del fabricante, asegurando su correcto funcionamiento y calidad.</p>
                </div>
            </li>
            <li class="list-group-item d-flex align-items-start border-0 bg-transparent px-0 pb-2">
                <i class="bi bi-currency-dollar text-primary fs-5 me-3"></i>
                <div>
                    <h5 class="fw-bold mb-0">Precios y Disponibilidad</h5>
                    <p class="text-muted mb-0">Los precios y la disponibilidad de los productos están sujetos a cambios
                        sin previo aviso debido a las fluctuaciones del mercado y el stock. Las ofertas son válidas
                        hasta agotar existencias.</p>
                </div>
            </li>
            <li class="list-group-item d-flex align-items-start border-0 bg-transparent px-0 pb-2">
                <i class="bi bi-image-fill text-info fs-5 me-3"></i>
                <div>
                    <h5 class="fw-bold mb-0">Imágenes y Representación</h5>
                    <p class="text-muted mb-0">Las imágenes de los productos en nuestro sitio son meramente
                        ilustrativas. Pueden existir variaciones en el diseño, color o características respecto al
                        producto final debido a mejoras o actualizaciones del fabricante.</p>
                </div>
            </li>
        </ul>
    </div>

    <div class="accordion mb-5" id="accordionPrivacy">
        <h2 class="text-center mb-4 fw-bold text-dark">3. Política de Privacidad</h2>
        <div class="accordion-item shadow-sm mb-3 rounded">
            <h2 class="accordion-header" id="headingPrivacy1">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsePrivacy1" aria-expanded="false" aria-controls="collapsePrivacy1">
                    <i class="bi bi-file-earmark-lock-fill me-3 text-warning"></i> Uso de Datos Personales
                </button>
            </h2>
            <div id="collapsePrivacy1" class="accordion-collapse collapse" aria-labelledby="headingPrivacy1"
                data-bs-parent="#accordionPrivacy">
                <div class="accordion-body text-muted">
                    La información personal recopilada será utilizada exclusivamente para la gestión de sus compras,
                    consultas, envío de productos y comunicaciones relevantes sobre su pedido. Garantizamos el
                    cumplimiento de las normativas vigentes de protección de datos.
                </div>
            </div>
        </div>
        <div class="accordion-item shadow-sm mb-3 rounded">
            <h2 class="accordion-header" id="headingPrivacy2">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsePrivacy2" aria-expanded="false" aria-controls="collapsePrivacy2">
                    <i class="bi bi-eye-slash-fill me-3 text-danger"></i> Confidencialidad
                </button>
            </h2>
            <div id="collapsePrivacy2" class="accordion-collapse collapse" aria-labelledby="headingPrivacy2"
                data-bs-parent="#accordionPrivacy">
                <div class="accordion-body text-muted">
                    Nos comprometemos a mantener la confidencialidad de su información. No compartiremos sus datos
                    personales con terceros sin su consentimiento expreso, excepto en los casos que sean necesarios para
                    el cumplimiento de una obligación legal o una transacción solicitada por usted (ej. envío a través
                    de terceros).
                </div>
            </div>
        </div>
        <div class="accordion-item shadow-sm mb-3 rounded">
            <h2 class="accordion-header" id="headingPrivacy3">
                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapsePrivacy3" aria-expanded="false" aria-controls="collapsePrivacy3">
                    <i class="bi bi-trash-fill me-3 text-secondary"></i> Eliminación de Datos
                </button>
            </h2>
            <div id="collapsePrivacy3" class="accordion-collapse collapse" aria-labelledby="headingPrivacy3"
                data-bs-parent="#accordionPrivacy">
                <div class="accordion-body text-muted">
                    Usted tiene el derecho a solicitar la eliminación o rectificación de su información personal
                    almacenada en nuestra base de datos en cualquier momento. Para ejercer este derecho, por favor,
                    póngase en contacto con nuestro equipo de soporte.
                </div>
            </div>
        </div>
    </div>

    <div class="bg-light p-4 p-md-5 border rounded shadow-sm mb-5">
        <h2 class="text-center mb-4 fw-bold text-dark">4. Garantías y Soporte</h2>
        <p class="text-muted mb-4">En TRY-HARDWARE, nos aseguramos de que todos sus productos cuenten con la cobertura y
            el respaldo necesarios.</p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex align-items-start border-0 bg-transparent px-0 pb-2">
                <i class="bi bi-calendar-check-fill text-success fs-5 me-3"></i>
                <div>
                    <h5 class="fw-bold mb-0">Garantía Estándar</h5>
                    <p class="text-muted mb-0">Todos los componentes de hardware comercializados incluyen una garantía
                        estándar de 12 meses directamente con el fabricante o, en su defecto, con TRY-HARDWARE.</p>
                </div>
            </li>
            <li class="list-group-item d-flex align-items-start border-0 bg-transparent px-0 pb-2">
                <i class="bi bi-headset me-3 text-primary fs-5"></i>
                <div>
                    <h5 class="fw-bold mb-0">Soporte Técnico Especializado</h5>
                    <p class="text-muted mb-0">Nuestro equipo de soporte técnico está disponible para asistirte con
                        cualquier consulta o problema. Puedes contactarnos vía correo electrónico o WhatsApp durante el
                        horario de atención.</p>
                </div>
            </li>
            <li class="list-group-item d-flex align-items-start border-0 bg-transparent px-0 pb-2">
                <i class="bi bi-arrow-counterclockwise text-warning fs-5 me-3"></i>
                <div>
                    <h5 class="fw-bold mb-0">Condiciones de Devolución</h5>
                    <p class="text-muted mb-0">Las devoluciones están sujetas a la evaluación del estado del producto
                        recibido. Es indispensable que el producto se encuentre sin uso, con sus accesorios y empaque
                        original.</p>
                </div>
            </li>
        </ul>
    </div>

    <div class="bg-light p-4 p-md-5 border rounded shadow-sm mb-5">
        <h2 class="text-center mb-4 fw-bold text-dark">5. Métodos de Entrega y Tiempos</h2>
        <p class="text-muted mb-4">Nos esforzamos por asegurar que su pedido llegue a sus manos de la manera más
            eficiente y segura posible.</p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item d-flex align-items-start border-0 bg-transparent px-0 pb-2">
                <i class="bi bi-box-seam-fill text-info fs-5 me-3"></i>
                <div>
                    <h5 class="fw-bold mb-0">Envío Estándar</h5>
                    <p class="text-muted mb-0">Su pedido será entregado en un plazo de 5 a 7 días hábiles a partir de la
                        confirmación de la compra.</p>
                </div>
            </li>
            <li class="list-group-item d-flex align-items-start border-0 bg-transparent px-0 pb-2">
                <i class="bi bi-lightning-charge-fill text-danger fs-5 me-3"></i>
                <div>
                    <h5 class="fw-bold mb-0">Envío Urgente</h5>
                    <p class="text-muted mb-0">Para aquellos que necesitan sus productos con rapidez, ofrecemos un envío
                        urgente con entrega en 2 a 3 días hábiles.</p>
                </div>
            </li>
            <li class="list-group-item d-flex align-items-start border-0 bg-transparent px-0 pb-2">
                <i class="bi bi-shop-window text-success fs-5 me-3"></i>
                <div>
                    <h5 class="fw-bold mb-0">Retiro en Tienda (Pick-up)</h5>
                    <p class="text-muted mb-0">Si eres un cliente local, puedes optar por retirar tu pedido directamente
                        en nuestra tienda física durante el horario de atención.</p>
                </div>
            </li>
        </ul>
    </div>

    <div class="p-4 p-md-5 bg-dark text-white rounded shadow-lg text-center">
        <h2 class="mb-4 display-6 fw-bold">6. Contacto y Soporte Legal</h2>
        <p class="lead mb-4">Para cualquier consulta específica sobre estos Términos y Condiciones, o si necesita
            asistencia legal, no dude en contactarnos.</p>
        <p class="fs-5 mb-2">
            <i class="bi bi-envelope-fill me-2"></i> <strong>Correo Electrónico:</strong> <a
                href="mailto:legal@tryhardware.com"
                class="text-white text-decoration-underline">legal@tryhardware.com</a>
        </p>
        <p class="fs-5 mb-2">
            <i class="bi bi-telephone-fill me-2"></i> <strong>Teléfono:</strong> <a href="tel:+541145678900"
                class="text-white text-decoration-underline">+54 11 4567-8900</a>
        </p>
        <p class="fs-5 mb-0">
            <a href="https://wa.me/541112345678" target="_blank"
                class="btn btn-light btn-lg rounded-pill px-4 shadow mt-3">
                <i class="bi bi-whatsapp me-2"></i> Contactar por WhatsApp
            </a>
        </p>
    </div>

</div>

<?= $this->endSection() ?>