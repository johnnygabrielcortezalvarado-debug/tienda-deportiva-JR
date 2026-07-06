<?php
$pageTitle = 'Nuevo Producto';
require __DIR__ . '/../layout/header.php';
?>

<div class="container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Nuevo Producto</h1>
            <p class="page-sub"><a href="index.php?c=productos">← Volver al listado</a></p>
        </div>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <div class="card form-card">
        <form action="index.php?c=productos&a=guardar" method="POST" id="formProducto" novalidate>

            <div class="form-row">
                <div class="form-group">
                    <label for="nombre">Nombre del producto *</label>
                    <input type="text" id="nombre" name="nombre" class="form-control"
                           value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>"
                           placeholder="Ej: Camiseta Running Pro" maxlength="150" required>
                    <span class="form-error" id="errNombre"></span>
                </div>

                <div class="form-group">
                    <label for="categoria_id">Categoría *</label>
                    <select id="categoria_id" name="categoria_id" class="form-control" required>
                        <option value="">— Selecciona una categoría —</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= (($_POST['categoria_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="form-error" id="errCategoria"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="3"
                          placeholder="Descripción del producto"><?= htmlspecialchars($_POST['descripcion'] ?? '') ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="precio">Precio ($) *</label>
                    <input type="number" id="precio" name="precio" class="form-control"
                           value="<?= htmlspecialchars($_POST['precio'] ?? '') ?>"
                           placeholder="0.00" min="0.01" step="0.01" required>
                    <span class="form-error" id="errPrecio"></span>
                </div>

                <div class="form-group">
                    <label for="stock">Stock *</label>
                    <input type="number" id="stock" name="stock" class="form-control"
                           value="<?= htmlspecialchars($_POST['stock'] ?? '0') ?>"
                           placeholder="0" min="0" required>
                    <span class="form-error" id="errStock"></span>
                </div>

                <div class="form-group">
                    <label for="talla">Talla</label>
                    <select id="talla" name="talla" class="form-control">
                        <option value="">— Sin talla —</option>
                        <?php foreach (['XS','S','M','L','XL','XXL','38','39','40','41','42','43','44','Única'] as $t): ?>
                            <option value="<?= $t ?>" <?= (($_POST['talla'] ?? '') === $t) ? 'selected' : '' ?>><?= $t ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="imagen_url">URL de imagen (opcional)</label>
                <input type="url" id="imagen_url" name="imagen_url" class="form-control"
                       value="<?= htmlspecialchars($_POST['imagen_url'] ?? '') ?>"
                       placeholder="https://ejemplo.com/imagen.jpg">
            </div>

            <div class="form-group form-check">
                <input type="checkbox" id="estado" name="estado" value="1"
                       <?= (!isset($_POST['estado']) || $_POST['estado']) ? 'checked' : '' ?>>
                <label for="estado">Producto activo</label>
            </div>

            <div class="form-actions">
                <a href="index.php?c=productos" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">💾 Guardar Producto</button>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
