<?php
$pageTitle = 'Categorías';
require __DIR__ . '/../layout/header.php';
?>

<div class="container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Categorías</h1>
            <p class="page-sub">Gestión de categorías de ropa deportiva</p>
        </div>
        <a href="index.php?c=categorias&a=crear" class="btn btn-primary">➕ Nueva Categoría</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php $msgs = [
            'creado'     => ['success', '✅ Categoría creada correctamente.'],
            'actualizado'=> ['success', '✅ Categoría actualizada correctamente.'],
            'eliminado'  => ['success', '🗑️ Categoría eliminada correctamente.'],
            'nodeletar'  => ['error',   '⚠️ No se puede eliminar: la categoría tiene productos asociados.'],
            'noexiste'   => ['error',   '⚠️ La categoría no existe.'],
        ]; $m = $msgs[$_GET['msg']] ?? null; ?>
        <?php if ($m): ?>
            <div class="alert alert-<?= $m[0] ?>"><?= $m[1] ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="card">
        <table class="tabla">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Productos</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($categorias)): ?>
                    <tr><td colspan="6" class="text-center">No hay categorías registradas.</td></tr>
                <?php else: ?>
                    <?php foreach ($categorias as $cat): ?>
                        <tr>
                            <td><?= $cat['id'] ?></td>
                            <td><strong><?= htmlspecialchars($cat['nombre']) ?></strong></td>
                            <td><?= htmlspecialchars($cat['descripcion'] ?: '—') ?></td>
                            <td class="text-center">
                                <span class="badge badge-blue">
                                    <?= (new CategoriaModel())->countProductos($cat['id']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge <?= $cat['estado'] ? 'badge-green' : 'badge-red' ?>">
                                    <?= $cat['estado'] ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </td>
                            <td class="acciones">
                                <a href="index.php?c=categorias&a=editar&id=<?= $cat['id'] ?>" class="btn btn-sm btn-warning">✏️ Editar</a>
                                <a href="index.php?c=categorias&a=eliminar&id=<?= $cat['id'] ?>"
                                   class="btn btn-sm btn-danger confirmar-eliminar"
                                   data-nombre="<?= htmlspecialchars($cat['nombre']) ?>">🗑️ Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
