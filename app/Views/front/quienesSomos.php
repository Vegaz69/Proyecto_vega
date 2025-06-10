<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<!-- Sección Quiénes Somos -->
<header class="text-center bg-primary text-white">
    <h1>Quiénes Somos</h1>
</header>

<section class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Nuestra Historia</h2>
            <p>Somos una empresa comprometida con la calidad y la innovación. Desde nuestros inicios, buscamos ofrecer soluciones eficientes a nuestros clientes.</p>
        </div>
        <div class="col-md-6">
            <h2>Nuestra Misión</h2>
            <p>Brindar productos y servicios de excelencia, adaptándonos a las necesidades de cada cliente.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <h2>Nuestra Visión</h2>
            <p>Aspiramos a ser referentes en nuestro sector, ofreciendo soluciones innovadoras y mejorando continuamente la experiencia de nuestros clientes.</p>
        </div>
        <div class="col-md-6">
            <h2>Valores de la Empresa</h2>
            <ul>
                <li>🌟 <strong>Compromiso:</strong> Trabajamos con pasión y responsabilidad.</li>
                <li>💡 <strong>Innovación:</strong> Siempre buscamos nuevas formas de mejorar.</li>
                <li>🛡️ <strong>Transparencia:</strong> Operamos con honestidad y ética profesional.</li>
            </ul>
        </div>
    </div>
</section>



<!-- Sección del Equipo con Organigrama -->
<section class="container my-5">
    <h2 class="text-center mb-4">Nuestro Equipo</h2>

    <!-- Gerente (Nivel 1) -->
    <div class="text-center mb-4">
        <div class="card mx-auto" style="width: 250px;">
            <img src="assets/img/1.svg" class="card-img-top" alt="Gerente">
            <div class="card-body">
                <h5 class="card-title">Nombre del Gerente</h5>
                <p class="card-text">Gerente General</p>
            </div>
        </div>
    </div>

    <!-- Nivel 2: Directivos -->
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card text-center">
                <img src="assets/img/2.svg" class="card-img-top" alt="Directivo 1">
                <div class="card-body">
                    <h5 class="card-title">Nombre 1</h5>
                    <p class="card-text">Director de Finanzas</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <img src="assets/img/1.svg" class="card-img-top" alt="Directivo 2">
                <div class="card-body">
                    <h5 class="card-title">Nombre 2</h5>
                    <p class="card-text">Director de Operaciones</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Nivel 3: Coordinadores y Jefes de Área -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-3">
            <div class="card text-center">
                <img src="assets/img/2.svg" class="card-img-top" alt="Coordinador 1">
                <div class="card-body">
                    <h5 class="card-title">Nombre 3</h5>
                    <p class="card-text">Jefe de Marketing</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <img src="assets/img/1.svg" class="card-img-top" alt="Coordinador 2">
                <div class="card-body">
                    <h5 class="card-title">Nombre 4</h5>
                    <p class="card-text">Jefe de Ventas</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <img src="assets/img/2.svg" class="card-img-top" alt="Coordinador 3">
                <div class="card-body">
                    <h5 class="card-title">Nombre 5</h5>
                    <p class="card-text">Jefe de RRHH</p>
                </div>
            </div>
        </div>
    </div>
</section>


<?= $this->endSection() ?>






