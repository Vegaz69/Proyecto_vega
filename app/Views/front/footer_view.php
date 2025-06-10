<footer class="container-fluid bg-primary text-white text-center py-4 mt-5">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
        
        <div class="order-2 order-md-1">
            <h5 class="fw-bold mb-2">Síguenos en</h5>
            <div class="d-flex gap-3">
                <a href="https://www.facebook.com" class="text-white fs-3"><i class="bi bi-facebook"></i></a>
                <a href="https://www.instagram.com" class="text-white fs-3"><i class="bi bi-instagram"></i></a>
                <a href="https://www.youtube.com" class="text-white fs-3"><i class="bi bi-youtube"></i></a>
            </div>
        </div>

        <div class="order-1 order-md-2">
            <p class="fs-5 fw-normal">© 2025 TRY-HARDWARE - Todos los derechos reservados.</p>
        </div>

        <div class="order-3 order-md-3">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'});"
                    class="btn btn-warning text-dark d-flex justify-content-center align-items-center"
                    style="width: auto; padding: 10px 20px; font-size: 24px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);">
                Ir arriba
            </button>
        </div>

    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Función para obtener parámetros de la URL
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Cuando el DOM esté cargado
    document.addEventListener('DOMContentLoaded', function() {
        // Si la URL contiene '?loginModal=true'
        if (getUrlParameter('loginModal') === 'true') {
            // Abre tu modal de login
            // Necesitarás saber el ID o la forma de activar tu modal.
            // Aquí hay ejemplos comunes para Bootstrap o JQuery UI, ajusta según tu librería:

            // Si usas Bootstrap 5:
            var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();

            // Si usas Bootstrap 4:
            // $('#tuModalDeLoginId').modal('show'); 

            // Si tu modal no es de una librería popular, tendrías que llamar a la función JS que lo abre
            // abrirMiModalDeLogin(); 

            // Opcional: Elimina el parámetro de la URL para que no se abra cada vez que se recargue la página
            // window.history.replaceState(null, null, window.location.pathname); 
        }
    });
</script>

</body>
</html>