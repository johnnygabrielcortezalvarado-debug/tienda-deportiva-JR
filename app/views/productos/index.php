<?php
$pageTitle = 'Productos';
require __DIR__ . '/../layout/header.php';
?>

<div class="container">
    <div class="page-header">
        <div>
            <h1 class="page-title">Productos</h1>
            <p class="page-sub">Gestión del catálogo de ropa deportiva</p>
        </div>
        <a href="index.php?c=productos&a=crear" class="btn btn-primary">➕ Nuevo Producto</a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <?php $msgs = [
            'creado'     => ['success', '✅ Producto creado correctamente.'],
            'actualizado'=> ['success', '✅ Producto actualizado correctamente.'],
            'eliminado'  => ['success', '🗑️ Producto eliminado correctamente.'],
            'noexiste'   => ['error',   '⚠️ El producto no existe.'],
            'error'      => ['error',   '⚠️ Error al procesar la solicitud.'],
        ]; $m = $msgs[$_GET['msg']] ?? null; ?>
        <?php if ($m): ?>
            <div class="alert alert-<?= $m[0] ?>"><?= $m[1] ?></div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Stats rápidas -->
    <div class="stats-mini">
        <span>📦 Total: <strong><?= $stats['total'] ?></strong></span>
        <span>⚠️ Sin stock: <strong><?= $stats['sin_stock'] ?></strong></span>
        <span>💰 Valor: <strong>$<?= number_format($stats['valor_inv'] ?? 0, 2) ?></strong></span>
    </div>

    <!-- Buscador -->
    <form method="GET" action="index.php" class="buscador-form">
        <input type="hidden" name="c" value="productos">
        <div class="buscador">
            <input type="text" name="buscar" class="form-control"
                   placeholder="🔍 Buscar por nombre o categoría..."
                   value="<?= htmlspecialchars($busqueda ?? '') ?>">
            <button type="submit" class="btn btn-secondary">Buscar</button>
            <?php if (!empty($busqueda)): ?>
                <a href="index.php?c=productos" class="btn btn-outline">✕ Limpiar</a>
            <?php endif; ?>
        </div>
    </form>

    <div class="card">
        <table class="tabla">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Talla</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($productos)): ?>
                    <tr><td colspan="8" class="text-center">No hay productos registrados.</td></tr>
                <?php else: ?>
                    <?php foreach ($productos as $p): ?>
                        <tr class="<?= $p['stock'] == 0 ? 'fila-sin-stock' : '' ?>">
                            <td><?= $p['id'] ?></td>
                            <td><strong><?= htmlspecialchars($p['nombre']) ?></strong></td>
                            <td><span class="badge badge-blue"><?= htmlspecialchars($p['categoria_nombre']) ?></span></td>
                            <td class="text-right"><strong>$<?= number_format($p['precio'], 2) ?></strong></td>
                            <td class="text-center">
                                <span class="badge <?= $p['stock'] > 0 ? 'badge-green' : 'badge-red' ?>">
                                    <?= $p['stock'] ?>
                                </span>
                            </td>
                            <td class="text-center"><?= htmlspecialchars($p['talla'] ?: '—') ?></td>
                            <td class="text-center">
                                <span class="badge <?= $p['estado'] ? 'badge-green' : 'badge-red' ?>">
                                    <?= $p['estado'] ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </td>
                            <td class="acciones">
                                <a href="index.php?c=productos&a=editar&id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">✏️ Editar</a>
                                <a href="index.php?c=productos&a=eliminar&id=<?= $p['id'] ?>"
                                   class="btn btn-sm btn-danger confirmar-eliminar"
                                   data-nombre="<?= htmlspecialchars($p['nombre']) ?>">🗑️ Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
