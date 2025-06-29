<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<h2 class="mb-4 text-center fw-bold"><i class="fas fa-boxes me-2"></i> Editar Producto: <?= esc($producto['nombre'] ?? 'Cargando...') ?></h2>

<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title text-white mb-0">Detalles del Producto</h5>
                <a href="<?= base_url('admin/productos') ?>" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Volver al Listado
                </a>
            </div>
            <div class="card-body">
                <!-- Mostrar mensajes de éxito o error generales -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Mostrar errores de validación específicos por campo -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Errores de Validación:</h4>
                        <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php
                // Obtener los datos antiguos explícitamente
                $oldInput = session()->getFlashdata('old_input');
                // Si no hay oldInput, inicializar con los datos del producto actual
                if (empty($oldInput) && isset($producto)) {
                    $oldInput = $producto;
                }
                ?>

                <form action="<?= base_url('admin/productos/guardar') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <!-- Campo oculto para el ID del producto (para edición) -->
                    <input type="hidden" name="id_producto" value="<?= esc($oldInput['id_producto'] ?? $producto['id_producto'] ?? '') ?>">
                    <!-- Campo oculto para la imagen actual -->
                    <input type="hidden" name="imagen_actual" value="<?= esc($oldInput['imagen'] ?? $producto['imagen'] ?? '') ?>">


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Producto:</label>
                                <!-- CAMBIO AQUÍ: maxlength="100" -->
                                <input type="text" class="form-control <?= session('errors.nombre') ? 'is-invalid' : '' ?>" id="nombre" name="nombre" value="<?= esc($oldInput['nombre'] ?? $producto['nombre'] ?? '') ?>" required minlength="3" maxlength="100" autocomplete="product-name">
                                <?php if (session('errors.nombre')) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?= esc(session('errors.nombre')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="marca" class="form-label">Marca:</label>
                                <input type="text" class="form-control <?= session('errors.marca') ? 'is-invalid' : '' ?>" id="marca" name="marca" value="<?= esc($oldInput['marca'] ?? $producto['marca'] ?? '') ?>" required minlength="2" maxlength="100" autocomplete="organization">
                                <?php if (session('errors.marca')) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?= esc(session('errors.marca')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_categoria" class="form-label">Categoría:</label>
                                <select class="form-select <?= session('errors.id_categoria') ? 'is-invalid' : '' ?>" id="id_categoria" name="id_categoria" required>
                                    <option value="">Seleccione una categoría</option>
                                    <?php foreach ($categorias as $categoria) : ?>
                                        <option value="<?= esc($categoria['id_categoria']) ?>"
                                            <?= (isset($oldInput['id_categoria']) && $oldInput['id_categoria'] == $categoria['id_categoria']) ? 'selected' : '' ?>
                                            <?= (!isset($oldInput['id_categoria']) && isset($producto['id_categoria']) && $producto['id_categoria'] == $categoria['id_categoria']) ? 'selected' : '' ?>>
                                            <?= esc($categoria['nombre']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session('errors.id_categoria')) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?= esc(session('errors.id_categoria')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio:</label>
                                <input type="number" step="0.01" class="form-control <?= session('errors.precio') ? 'is-invalid' : '' ?>" id="precio" name="precio" value="<?= esc($oldInput['precio'] ?? $producto['precio'] ?? '') ?>" required min="0.01">
                                <?php if (session('errors.precio')) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?= esc(session('errors.precio')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción:</label>
                        <textarea class="form-control <?= session('errors.descripcion') ? 'is-invalid' : '' ?>" id="descripcion" name="descripcion" rows="4" maxlength="65535"><?= esc($oldInput['descripcion'] ?? $producto['descripcion'] ?? '') ?></textarea>
                        <?php if (session('errors.descripcion')) : ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.descripcion')) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label for="imagen_file" class="form-label">Imagen del Producto:</label>
                        <input type="file" class="form-control <?= session('errors.imagen_file') ? 'is-invalid' : '' ?>" id="imagen_file" name="imagen_file" accept="image/*">
                        <div class="form-text">Sube una nueva imagen para el producto (JPG, JPEG, PNG, GIF, etc.).</div>

                        <?php if (isset($producto['imagen']) && !empty($producto['imagen'])) : ?>
                            <div class="mt-3 p-3 border rounded text-center bg-light">
                                <p class="mb-2 fw-bold">Imagen actual:</p>
                                <img src="<?= base_url('uploads/productos/' . $producto['imagen']) ?>" alt="Imagen actual del producto" class="img-thumbnail" style="max-width: 200px; height: auto;">
                                <div class="form-text mt-2">Al subir una nueva imagen, la actual será reemplazada.</div>
                            </div>
                        <?php endif; ?>
                        <?php if (session('errors.imagen_file')) : ?>
                            <div class="invalid-feedback d-block">
                                <?= esc(session('errors.imagen_file')) ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock:</label>
                                <input type="number" class="form-control <?= session('errors.stock') ? 'is-invalid' : '' ?>" id="stock" name="stock" value="<?= esc($oldInput['stock'] ?? $producto['stock'] ?? '') ?>" required min="0">
                                <?php if (session('errors.stock')) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?= esc(session('errors.stock')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="col-md-6 d-flex align-items-center mt-3 mt-md-0">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input <?= session('errors.activo') ? 'is-invalid' : '' ?>" id="activo" name="activo" value="1"
                                    <?= (isset($oldInput['activo']) ? ($oldInput['activo'] == 1 ? 'checked' : '') : (isset($producto['activo']) && $producto['activo'] == 1 ? 'checked' : '')) ?>>
                                <label class="form-check-label" for="activo">Producto Activo</label>
                                <div class="form-text">Marcar si el producto debe estar visible en el catálogo público.</div>
                                <?php if (session('errors.activo')) : ?>
                                    <div class="invalid-feedback d-block">
                                        <?= esc(session('errors.activo')) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Actualizar Producto
                        </button>
                        <a href="<?= base_url('admin/productos') ?>" class="btn btn-secondary">
                            <i class="fas fa-times-circle me-1"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>