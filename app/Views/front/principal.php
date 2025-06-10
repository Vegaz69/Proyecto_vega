<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<!-- 1 -->
<div class="container-fluid"></div>
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="assets/img/ryzen1.avif" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="assets/img/placa1.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="assets/img/1234.avif" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- 2 -->
<div class="container my-4">
    <div class="row text-center">
        <div class="col-md-4">
            <i class="bi bi-credit-card fs-1 text-primary"></i>
            <p class="fs-5 fw-bold">Hasta 12 cuotas abonando con tarjetas de crédito</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-truck fs-1 text-success"></i>
            <p class="fs-5 fw-bold">Envíos a todo el país a través de OCA</p>
        </div>
        <div class="col-md-4">
            <i class="bi bi-shield-check fs-1 text-danger"></i>
            <p class="fs-5 fw-bold">Garantía oficial de hasta 12 meses en todos los productos</p>
        </div>
    </div>
</div>


<!-- 3 -->
<div class="container"> 
<div class="card-group m-3">
  <div class="card">
    <img src="assets/img/pin/pin1.jfif" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Potencia sin límites con Ryzen!</h5>
      <p class="card-text text-justify">Descubre el rendimiento extremo de los procesadores AMD Ryzen, diseñados para llevar tu creatividad, productividad y gaming al siguiente nivel. Más núcleos, más velocidad, más eficiencia.</p>
      <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
    </div>
  </div>
  <div class="card">
    <img src="assets/img/pin/pin5.jfif" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">Rendimiento sin límites con MSI!</h5>
      <p class="card-text">Potencia, innovación y diseño se combinan en los productos MSI, creados para los gamers más exigentes y los profesionales que buscan lo mejor en hardware. Máxima velocidad, refrigeración avanzada y tecnología de vanguardia.</p>
      <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
    </div>
  </div>
  <div class="card">
    <img src="assets/img/pin/pin3.jfif" class="card-img-top" alt="...">
    <div class="card-body">
      <h5 class="card-title">AORUS: La excelencia en rendimiento y diseño.</h5>
      <p class="card-text">Lleva tu experiencia al límite con AORUS, la marca líder en hardware de alto desempeño para gamers y creadores. Potencia inigualable, refrigeración avanzada y tecnología de vanguardia para que domines cada partida.</p>
      <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
    </div>
  </div>
</div>
</div>

<!-- 4 -->

<div class="container my-5">
    <h2 class="text-center mb-4">Explora nuestras categorías</h2>
    <div class="row text-center">
        <div class="col-md-3 col-6">
            <i class="bi bi-laptop fs-1 text-primary"></i>
            <p class="fs-5 fw-bold">Notebooks</p>
        </div>
        <div class="col-md-3 col-6">
            <i class="bi bi-cpu fs-1 text-success"></i>
            <p class="fs-5 fw-bold">Procesadores</p>
        </div>
        <div class="col-md-3 col-6">
            <i class="bi bi-motherboard fs-1 text-info"></i>
            <p class="fs-5 fw-bold">Mothers</p>
        </div>
        <div class="col-md-3 col-6">
            <i class="bi bi-gpu-card fs-1 text-warning"></i>
            <p class="fs-5 fw-bold">Placas de Video</p>
        </div>
        <div class="col-md-3 col-6">
            <i class="bi bi-memory fs-1 text-danger"></i>
            <p class="fs-5 fw-bold">Memorias RAM</p>
        </div>
        <div class="col-md-3 col-6">
            <i class="bi bi-hdd fs-1 text-dark"></i>
            <p class="fs-5 fw-bold">Almacenamiento</p>
        </div>
        <div class="col-md-3 col-6">
            <i class="bi bi-fan fs-1 text-primary"></i>
            <p class="fs-5 fw-bold">Refrigeración</p>
        </div>
        <div class="col-md-3 col-6">
            <i class="bi bi-pc fs-1 text-success"></i>
            <p class="fs-5 fw-bold">Gabinetes</p>
        </div>
        <div class="col-md-3 col-6">
            <i class="bi bi-display fs-1 text-warning"></i>
            <p class="fs-5 fw-bold">Monitores</p>
        </div>
        <div class="col-md-3 col-6">
            <i class="bi bi-keyboard fs-1 text-danger"></i>
            <p class="fs-5 fw-bold">Periféricos</p>
        </div>
    </div>
</div>



<?= $this->endSection() ?>