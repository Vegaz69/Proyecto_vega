<?= $this->extend('front/layout') ?>

<?= $this->section('content') ?>

<style>
    /* Estilos para la barra lateral fija en pantallas grandes */
    @media (min-width: 992px) { /* Aplica a partir de 'lg' breakpoint de Bootstrap */
        .sticky-sidebar {
            position: -webkit-sticky; /* Para compatibilidad con Safari */
            position: sticky;
            top: 20px; /* Distancia desde la parte superior de la ventana */
            align-self: flex-start; /* Asegura que se alinee al inicio del contenedor flex */
            z-index: 100; /* Para asegurar que esté por encima de otros elementos si es necesario */
        }
    }
</style>

<div class="container my-3">
    <h1 class="text-center fw-bold text-dark mb-4">
        <i class="bi bi-cart me-2 text-primary"></i> Tu Carrito de Compras
    </h1>

    <?php if (session()->getFlashdata('success_cart')): ?>
    <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?= esc(session()->getFlashdata('success_cart')); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error_cart')): ?>
    <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= esc(session()->getFlashdata('error_cart')); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <?php if (!empty($productos)): ?>
    <div class="row gx-4">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light text-dark fw-bold py-3">
                    <h5 class="mb-0"><i class="bi bi-bag me-2"></i> Detalles de los Productos</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped align-middle mb-0">
                            <thead class="table-primary">
                                <tr class="text-center">
                                    <th scope="col" class="py-2">Producto</th>
                                    <th scope="col" class="py-2">Imagen</th>
                                    <th scope="col" class="py-2">Precio</th>
                                    <th scope="col" class="py-2">Cantidad</th>
                                    <th scope="col" class="py-2">Subtotal</th>
                                    <th scope="col" class="py-2">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $producto): ?>
                                <tr class="text-center">
                                    <td class="fw-semibold text-dark">
                                        <?= esc($producto['nombre_producto']) ?>
                                    </td>
                                    <td>
                                        <img src="<?= base_url('uploads/productos/' . esc($producto['imagen'] ?? 'placeholder.png')) ?>"
                                            alt="<?= esc($producto['nombre_producto']) ?>" class="img-thumbnail"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td class="fw-bold text-primary">$
                                        <?= number_format($producto['precio_unitario'], 2, ',', '.') ?>
                                    </td>
                                    <td>
                                        <form action="<?= base_url('carrito/actualizar') ?>" method="post"
                                            class="d-flex align-items-center justify-content-center">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id_carrito"
                                                value="<?= esc($producto['id_carrito']) ?>">
                                            <input type="number" name="cantidad"
                                                value="<?= esc($producto['cantidad']) ?>" min="1"
                                                max="<?= esc($producto['stock_actual'] ?? 999) ?>"
                                                class="form-control form-control-sm me-2 text-center"
                                                style="width: 70px;">
                                            <button type="submit" class="btn btn-sm btn-outline-primary"
                                                title="Actualizar"><i class="bi bi-arrow-clockwise"></i></button>
                                        </form>
                                    </td>
                                    <td class="fw-bold text-primary">$
                                        <?= number_format($producto['subtotal'], 2, ',', '.') ?>
                                    </td>
                                    <td>
                                        <form action="<?= site_url('carrito/eliminar/'.$producto['id_carrito']) ?>"
                                            method="post" style="display:inline;">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                title="Eliminar">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between align-items-center py-3">
                    <a href="<?= base_url('catalogo') ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left-circle me-2"></i>Seguir Comprando
                    </a>
                    <form action="<?= base_url('carrito/vaciar') ?>" method="post" style="display:inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash-fill me-2"></i>Vaciar Carrito
                        </button>
                    </form>
                </div>
            </div>
        </div>

<<<<<<< HEAD
        <div class="col-lg-4 mb-4">
            <?php if (session()->has('isLoggedIn')): ?>
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-dark text-white fw-bold py-3">
                    <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i> Datos del Cliente para la Compra</h5>
                </div>
                <div class="card-body p-4">
                    <form id="datosClienteForm">
                        <div class="mb-3">
                            <label for="dni" class="form-label">DNI</label>
                            <input type="text" class="form-control" id="dni" name="dni" value="<?= old('dni') ?>"
                                required>
                            <div class="invalid-feedback" id="dniFeedback">Por favor, ingrese un DNI válido (solo
                                números).</div>
                        </div>
                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                value="<?= old('telefono') ?>" required>
                            <div class="invalid-feedback" id="telefonoFeedback">Por favor, ingrese un número de teléfono
                                válido (solo números).</div>
                        </div>
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion"
                                value="<?= old('direccion') ?>" required>
                            <div class="invalid-feedback" id="direccionFeedback">Por favor, ingrese su dirección.</div>
                        </div>
                        <?php if (isset($errors)): ?>
                        <div class="alert alert-danger mt-3">
                            <ul>
                                <?php foreach ($errors as $error): ?>
                                <li>
                                    <?= esc($error) ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold py-3">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i> Resumen del Pedido</h5>
                </div>
                <div class="card-body text-center p-4">
                    <h6 class="text-muted mb-2">Total a Pagar:</h6>
                    <p class="fs-2 text-success fw-bold mb-4">$
                        <?= number_format($total, 2, ',', '.') ?>
                    </p>
                    <hr class="mb-4">
                    <div class="d-grid gap-2">
                        <?php if (session()->has('isLoggedIn')): ?>
                        <form action="<?= base_url('carrito/confirmar_compra') ?>" method="post"
                            id="confirmarCompraForm">
                            <?= csrf_field() ?>
                            <input type="hidden" name="dni" id="hiddenDni">
                            <input type="hidden" name="telefono" id="hiddenTelefono">
                            <input type="hidden" name="direccion" id="hiddenDireccion">

                            <button type="submit" class="btn btn-success btn-lg w-100" id="confirmarCompraBtn" disabled>
                                <i class="bi bi-check-circle-fill me-2"></i> Confirmar Pedido
                            </button>
                        </form>
                        <?php else: ?>
                        <div class="alert alert-warning text-center small py-2" role="alert">
                            <i class="bi bi-info-circle-fill me-2"></i> Inicia sesión para finalizar tu compra.
                        </div>
                        <a href="<?= base_url('login') ?>" class="btn btn-primary btn-lg w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión
                        </a>
                        <?php endif; ?>
                    </div>
=======
            <!-- Columna derecha para el resumen y datos del cliente -->
            <div class="col-lg-4 mb-4">
                <div class="sticky-sidebar d-flex flex-column gap-4">
                    <!-- Resumen del Pedido (siempre visible) -->
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white fw-bold py-3">
                            <h5 class="mb-0"><i class="bi bi-receipt me-2"></i> Resumen del Pedido</h5>
                        </div>
                        <div class="card-body text-center p-4">
                            <h6 class="text-muted mb-2">Total a Pagar:</h6>
                            <p class="fs-2 text-success fw-bold mb-4">$<?= number_format($total, 2, ',', '.') ?></p>
                            <hr class="mb-4">
                            <div class="d-grid gap-2">
                                <?php if (session()->has('isLoggedIn')): ?>
                                    <form action="<?= base_url('carrito/confirmar_compra') ?>" method="post" id="confirmarCompraForm">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="dni" id="hiddenDni">
                                        <input type="hidden" name="telefono" id="hiddenTelefono">
                                        <input type="hidden" name="direccion" id="hiddenDireccion">

                                        <button type="submit" class="btn btn-success btn-lg w-100" id="confirmarCompraBtn" disabled>
                                            <i class="bi bi-check-circle-fill me-2"></i> Confirmar Pedido
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <div class="alert alert-warning text-center small py-2" role="alert">
                                        <i class="bi bi-info-circle-fill me-2"></i> Inicia sesión para finalizar tu compra.
                                    </div>
                                    <a href="<?= base_url('login') ?>" class="btn btn-primary btn-lg w-100">
                                        <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php if (session()->has('isLoggedIn')): ?>
                        <!-- Datos del Cliente (solo si está logueado) -->
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-dark text-white fw-bold py-3">
                                <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i> Datos del Cliente para la Compra</h5>
                            </div>
                            <div class="card-body p-4">
                                <form id="datosClienteForm">
                                    <div class="mb-3">
                                        <label for="dni" class="form-label">DNI</label>
                                        <input type="text" class="form-control" id="dni" name="dni" value="<?= old('dni') ?>" required>
                                        <div class="invalid-feedback" id="dniFeedback">Por favor, ingrese un DNI válido (solo números).</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?= old('telefono') ?>" required>
                                        <div class="invalid-feedback" id="telefonoFeedback">Por favor, ingrese un número de teléfono válido (solo números).</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="direccion" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?= old('direccion') ?>" required>
                                        <div class="invalid-feedback" id="direccionFeedback">Por favor, ingrese su dirección.</div>
                                    </div>
                                    <?php if (isset($errors)): ?>
                                        <div class="alert alert-danger mt-3">
                                            <ul>
                                                <?php foreach ($errors as $error): ?>
                                                    <li><?= esc($error) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
>>>>>>> origin/main
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-info text-center py-3 my-3 shadow-sm animate__animated animate__fadeIn" role="alert">
        <h4 class="fw-bold text-secondary mb-3"><i class="bi bi-info-circle-fill me-2"></i> Tu carrito está vacío</h4>
        <p class="lead mb-4">¡Añade productos para comenzar tu compra!</p>
        <a href="<?= base_url('catalogo') ?>" class="btn btn-primary btn-lg mt-3">
            <i class="bi bi-shop-window me-2"></i> Ir al Catálogo
        </a>
    </div>
    <?php endif; ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Animación de desaparición para alertas de Bootstrap con Animate.css
        function hideAlert(alertElement) {
            if (alertElement) {
                alertElement.classList.add('animate__fadeOutUp');
                alertElement.addEventListener('animationend', () => {
                    alertElement.remove();
                }, { once: true });
            }
        }

        setTimeout(function () {
            var successAlert = document.querySelector('.alert-success');
            hideAlert(successAlert);

            var errorAlert = document.querySelector('.alert-danger');
            hideAlert(errorAlert);
        }, 3000); // 3 segundos antes de empezar a desaparecer

        // Lógica para validación de campos y habilitación del botón de compra
        const confirmarCompraBtn = document.getElementById('confirmarCompraBtn');
        const dniInput = document.getElementById('dni');
        const telefonoInput = document.getElementById('telefono');
        const direccionInput = document.getElementById('direccion');
        const hiddenDni = document.getElementById('hiddenDni');
        const hiddenTelefono = document.getElementById('hiddenTelefono');
        const hiddenDireccion = document.getElementById('hiddenDireccion');
        const datosClienteForm = document.getElementById('datosClienteForm'); // El formulario que contiene los inputs

        // Solo si el usuario está logueado, se activa la validación
        if (dniInput && telefonoInput && direccionInput && confirmarCompraBtn) {

            const validateField = (inputElement, feedbackElement, regex, errorMessage) => {
                const value = inputElement.value.trim();
                inputElement.classList.remove('is-valid');
                if (value === '' || (regex && !regex.test(value))) {
                    inputElement.classList.add('is-invalid');
                    feedbackElement.textContent = errorMessage;
                    return false;
                } else {
                    inputElement.classList.remove('is-invalid');
                    inputElement.classList.add('is-valid');
                    return true;
                }
            };

            const checkFormValidity = () => {
                const isDniValid = validateField(dniInput, document.getElementById('dniFeedback'), /^\d+$/, 'Por favor, ingrese un DNI válido (solo números).');
                const isTelefonoValid = validateField(telefonoInput, document.getElementById('telefonoFeedback'), /^\d+$/, 'Por favor, ingrese un número de teléfono válido (solo números).');
                const isDireccionValid = validateField(direccionInput, document.getElementById('direccionFeedback'), /.+/, 'Por favor, ingrese su dirección.');

                const formIsValid = isDniValid && isTelefonoValid && isDireccionValid;

                confirmarCompraBtn.disabled = !formIsValid;

                if (formIsValid) {
                    hiddenDni.value = dniInput.value;
                    hiddenTelefono.value = telefonoInput.value;
                    hiddenDireccion.value = direccionInput.value;
                } else {
                    hiddenDni.value = '';
                    hiddenTelefono.value = '';
                    hiddenDireccion.value = '';
                }
            };

            dniInput.addEventListener('input', checkFormValidity);
            telefonoInput.addEventListener('input', checkFormValidity);
            direccionInput.addEventListener('input', checkFormValidity);

            checkFormValidity();
        }
    });
</script>

<?= $this->endSection() ?>
