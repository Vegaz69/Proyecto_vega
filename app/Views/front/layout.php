<?= view('front/head_view') ?>
<?= view('front/nav_view') ?>

<main class="flex-grow-1">
    <div class="container-fluid">
        <?= $this->renderSection('content') ?>
    </div>
</main>

<?= view('front/footer_view') ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<button onclick="window.scrollTo({top: 0, behavior: 'smooth'});"
        class="btn btn-warning rounded-circle shadow back-to-top"
        type="button" aria-label="Ir arriba">
  <i class="fas fa-arrow-up"></i>
</button>

<!-- Librerías externas -->
<script src="https://unpkg.com/swiper@10/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<div class="modal fade" id="loginRegisterModal" tabindex="-1" aria-labelledby="loginRegisterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="loginRegisterModalLabel"><i class="fas fa-user-circle me-2"></i> Acceso Requerido</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4 bg-white text-dark">
                <p class="lead mb-3">¡Necesitas iniciar sesión para agregar productos al carrito!</p>
                <p class="text-muted small">Si no tienes una cuenta, puedes registrarte fácilmente.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <a href="<?= base_url('login') ?>" class="btn btn-dark btn-lg me-3"><i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión</a>
                
                <a href="<?= base_url('registro') ?>" class="btn btn-outline-dark btn-lg"><i class="fas fa-user-plus me-2"></i> Registrarse</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
