<?php
$pageTitle = 'Editar Categoría';
require __DIR__ . '/../layout/header.php';
?>

<div class="container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Editar Categoría</h1>
            <p class="page-sub"><a href="index.php?c=categorias">← Volver al listado</a></p>
        </div>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= $error ?></div>
    <?php endif; ?>

    <div class="card form-card">
        <form action="index.php?c=categorias&a=actualizar" method="POST" id="formCategoria" novalidate>
            <input type="hidden" name="id" value="<?= $categoria['id'] ?>">

            <div class="form-group">
                <label for="nombre">Nombre de la categoría *</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                       value="<?= htmlspecialchars($_POST['nombre'] ?? $categoria['nombre']) ?>"
                       placeholder="Ej: Camisetas deportivas" maxlength="100" required>
                <span class="form-error" id="errNombre"></span>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" rows="3"
                          placeholder="Descripción opcional"><?= htmlspecialchars($_POST['descripcion'] ?? $categoria['descripcion']) ?></textarea>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" id="estado" name="estado" value="1"
                       <?= ($_POST['estado'] ?? $categoria['estado']) ? 'checked' : '' ?>>
                <label for="estado">Categoría activa</label>
            </div>

            <div class="form-actions">
                <a href="index.php?c=categorias" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">💾 Actualizar Categoría</button>
            </div>
        </form>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
