<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>


<div class="container my-5">
    <h2>Editar Producto: <?= esc($producto['nombre']) ?></h2>

    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/productos/guardar') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <input type="hidden" name="id" value="<?= esc($producto['id_producto']) ?>"> 

        <div class="mb-3">
            <label for="nombre_producto" class="form-label">Nombre del Producto:</label>
            <input type="text" class="form-control" id="nombre_producto" name="nombre" value="<?= old('nombre', $producto['nombre']) ?>" required autocomplete="product-name">
            <?php if (session('errors.nombre')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.nombre') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="marca_producto" class="form-label">Marca:</label>
            <input type="text" class="form-control" id="marca_producto" name="marca" value="<?= old('marca', $producto['marca']) ?>" required autocomplete="organization">
            <?php if (session('errors.marca')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.marca') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="id_categoria_producto" class="form-label">Categoría:</label>
            <select class="form-select" id="id_categoria_producto" name="id_categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= esc($categoria['id_categoria']) ?>" <?= (old('id_categoria', $producto['id_categoria']) == $categoria['id_categoria']) ? 'selected' : '' ?>>
                        <?= esc($categoria['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (session('errors.id_categoria')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.id_categoria') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="precio_producto" class="form-label">Precio:</label>
            <input type="number" step="0.01" class="form-control" id="precio_producto" name="precio" value="<?= old('precio', $producto['precio']) ?>" required min="0.01">
            <?php if (session('errors.precio')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.precio') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="descripcion_producto" class="form-label">Descripción:</label>
            <textarea class="form-control" id="descripcion_producto" name="descripcion" rows="3"><?= old('descripcion', $producto['descripcion']) ?></textarea>
            <?php if (session('errors.descripcion')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.descripcion') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="imagen_producto" class="form-label">Imagen del Producto:</label>
            <input type="file" class="form-control" id="imagen_producto" name="imagen_file" accept="image/*">
            <div class="form-text">Sube una imagen para el producto (JPG, PNG, GIF, etc.).</div>

            <?php if (isset($producto['imagen']) && !empty($producto['imagen'])): ?>
                <div class="mt-2">
                    <p>Imagen actual:</p>
                    <img src="<?= base_url('uploads/productos/' . $producto['imagen']) ?>" alt="Imagen actual del producto" style="max-width: 150px; border: 1px solid #ddd; padding: 5px;">
                    <input type="hidden" name="imagen_actual" value="<?= esc($producto['imagen']) ?>">
                    <div class="form-text">Al subir una nueva imagen, la actual será reemplazada.</div>
                </div>
            <?php endif; ?>
            <?php if (session('errors.imagen_file')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.imagen_file') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="stock_producto" class="form-label">Stock:</label>
            <input type="number" class="form-control" id="stock_producto" name="stock" value="<?= old('stock', $producto['stock']) ?>" required min="0">
            <?php if (session('errors.stock')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.stock') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="activo_producto" name="activo" value="1" <?= (old('activo', $producto['activo']) == 1) ? 'checked' : '' ?>>
            <label class="form-check-label" for="activo_producto">Producto Activo</label>
            <?php if (session('errors.activo')) : ?>
                <div class="invalid-feedback d-block">
                    <?= session('errors.activo') ?>
                </div>
            <?php endif; ?>
        </div>


        <button type="submit" class="btn btn-success">Actualizar Producto</button>
        <a href="<?= base_url('admin/productos') ?>" class="btn btn-secondary">Cancelar</a> </form>
</div>

<?= $this->endSection() ?>