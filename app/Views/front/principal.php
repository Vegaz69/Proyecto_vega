<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="<?= base_url('assets/img/ryzen1.avif') ?>" class="d-block w-100 img-fluid" alt="Procesadores Ryzen">
            <div class="carousel-caption d-none d-md-block text-start">
                <h5 class="display-4 fw-bold text-white shadow-text">Potencia sin Límites</h5>
                <p class="lead text-white shadow-text">Descubre la nueva generación de rendimiento para gaming y creación de contenido.</p>
                <a href="<?= base_url('catalogo') ?>" class="btn btn-primary btn-lg mt-3 rounded-pill">Ver Productos <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="<?= base_url('assets/img/placa1.jpg') ?>" class="d-block w-100 img-fluid" alt="Placas de Video">
            <div class="carousel-caption d-none d-md-block text-center">
                <h5 class="display-4 fw-bold text-white shadow-text">Gráficos de Última Generación</h5>
                <p class="lead text-white shadow-text">Sumérgete en mundos virtuales con una fluidez y detalle asombrosos.</p>
                <a href="<?= base_url('catalogo') ?>" class="btn btn-warning btn-lg mt-3 rounded-pill">Explorar GPU <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="<?= base_url('assets/img/1234.avif') ?>" class="d-block w-100 img-fluid" alt="Componentes de PC">
            <div class="carousel-caption d-none d-md-block text-end">
                <h5 class="display-4 fw-bold text-white shadow-text">Construye tu Pc!</h5>
                <p class="lead text-white shadow-text">Todo lo que necesitas para armar la PC gamer o profesional perfecta.</p>
                <a href="<?= base_url('catalogo') ?>" class="btn btn-info btn-lg mt-3 rounded-pill">Comenzar Ahora <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="container my-4 py-4 bg-light rounded shadow-sm">
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <i class="fas fa-credit-card fa-3x text-primary mb-3"></i>
            <h3 class="fs-4 fw-bold mb-2">Hasta 12 Cuotas Sin Interés</h3>
            <p class="text-muted">Abonando con las principales tarjetas de crédito.</p>
        </div>
        <div class="col-md-4 mb-4">
            <i class="fas fa-shipping-fast fa-3x text-success mb-3"></i>
            <h3 class="fs-4 fw-bold mb-2">Envíos a Todo el País</h3>
            <p class="text-muted">Despachos rápidos y seguros a través de OCA.</p>
        </div>
        <div class="col-md-4 mb-4">
            <i class="fas fa-shield-alt fa-3x text-danger mb-3"></i>
            <h3 class="fs-4 fw-bold mb-2">Garantía Extendida</h3>
            <p class="text-muted">Hasta 12 meses de garantía oficial en todos los productos.</p>
        </div>
    </div>
</div>

<div class="container my-4">
    <h2 class="text-center mb-5 display-5 fw-bold text-dark">Nuestras Marcas Destacadas</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4"> <div class="col">
            <div class="card h-100 border-0 shadow-lg transform-on-hover">
                <img src="<?= base_url('assets/img/pin/pin1.jfif') ?>" class="card-img-top img-fluid rounded-top" alt="Procesadores AMD Ryzen">
                <div class="card-body">
                    <h5 class="card-title text-center text-primary fs-4 fw-bold">Potencia sin límites con Ryzen!</h5>
                    <p class="card-text text-justify text-muted">Descubre el rendimiento extremo de los procesadores AMD Ryzen, diseñados para llevar tu creatividad, productividad y gaming al siguiente nivel. Más núcleos, más velocidad, más eficiencia.</p>
                </div>
                <div class="card-footer bg-transparent border-top-0 text-center">
                    <small class="text-muted">Actualizado recientemente</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 shadow-lg transform-on-hover">
                <img src="<?= base_url('assets/img/pin/pin5.jfif') ?>" class="card-img-top img-fluid rounded-top" alt="Productos MSI">
                <div class="card-body">
                    <h5 class="card-title text-center text-success fs-4 fw-bold">Rendimiento sin límites con MSI!</h5>
                    <p class="card-text text-justify text-muted">Potencia, innovación y diseño se combinan en los productos MSI, creados para los gamers más exigentes y los profesionales que buscan lo mejor en hardware. Máxima velocidad, refrigeración avanzada y tecnología de vanguardia.</p>
                </div>
                <div class="card-footer bg-transparent border-top-0 text-center">
                    <small class="text-muted">Actualizado recientemente</small>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-100 border-0 shadow-lg transform-on-hover">
                <img src="<?= base_url('assets/img/pin/pin3.jfif') ?>" class="card-img-top img-fluid rounded-top" alt="Productos AORUS">
                <div class="card-body">
                    <h5 class="card-title text-center text-warning fs-4 fw-bold">AORUS: La excelencia en rendimiento.</h5>
                    <p class="card-text text-justify text-muted">Lleva tu experiencia al límite con AORUS, la marca líder en hardware de alto desempeño para gamers y creadores. Potencia inigualable, refrigeración avanzada y tecnología de vanguardia para que domines cada partida.</p>
                </div>
                <div class="card-footer bg-transparent border-top-0 text-center">
                    <small class="text-muted">Actualizado recientemente</small>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- CATEGORIAS -->


<div class="container my-2 py-2 bg-white text-dark rounded shadow-sm">
    <h2 class="text-center mb-3 display-5 fw-bold text-dark">
        Explora nuestras <span class="text-primary">Categorías</span></h2>
    
    <div class="row text-center g-2 g-md-4">
        <?php
        $categorias = [
            // Selección alternativa de iconos de Font Awesome
            ['icon_class' => 'fa-solid fa-server',             'name' => 'Almacenamiento',    'color' => '#12b886'], // 'server' es más moderno que 'hard-drive'
            ['icon_class' => 'fa-solid fa-desktop',            'name' => 'Monitores',          'color' => '#fa5252'], // 'desktop' es clásico para monitor
            ['icon_class' => 'fa-solid fa-laptop',             'name' => 'Notebooks',          'color' => '#228be6'], // 'laptop' es el mejor
            ['icon_class' => 'fa-solid fa-keyboard',           'name' => 'Periféricos',        'color' => '#fd7e14'], // 'keyboard' es un buen representante de periféricos
            ['icon_class' => 'fa-solid fa-bolt',               'name' => 'Fuentes de Poder',  'color' => '#20c997'], // 'bolt' (rayo) para energía
            ['icon_class' => 'fa-solid fa-microchip',          'name' => 'Procesadores',      'color' => '#ae3ec9'], // 'microchip' es ideal para procesadores
        ];

        foreach ($categorias as $cat): ?>
            <div class="col-6 col-md-3 col-lg-2">
                <div class="d-block text-decoration-none p-1 p-md-3 hover-lift rounded border" 
                    style="background-color: #f8f9fa;">
                     <i class="<?= esc($cat['icon_class']) ?> category-icon mb-2" 
                        style="color: <?= esc($cat['color']) ?>; font-size: 3rem;"></i> <p class="small fw-medium text-dark mb-0 mt-1 fs-md-6"><?= esc($cat['name']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="text-center mt-3 mt-md-3">
        <a href="<?= base_url('catalogo') ?>" class="btn btn-sm btn-md-lg btn-outline-primary rounded-pill px-4 px-md-5">
            Ver todas las categorías 
            <i class="fa-solid fa-arrow-right ms-2 button-arrow-icon" style="color: #228be6;"></i>
        </a>
    </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>


<?= $this->endSection() ?>