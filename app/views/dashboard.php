<?php
$pageTitle = 'Dashboard';
require __DIR__ . '/layout/header.php';
?>

<div class="container">
    <div class="page-header">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-sub">Resumen general de la tienda deportiva</p>
    </div>

    <!-- Tarjetas de estadísticas -->
    <div class="stats-grid">
        <div class="stat-card stat-blue">
            <div class="stat-icon">📦</div>
            <div class="stat-info">
                <span class="stat-num"><?= $stats['total_productos'] ?></span>
                <span class="stat-label">Productos</span>
            </div>
        </div>
        <div class="stat-card stat-green">
            <div class="stat-icon">🏷️</div>
            <div class="stat-info">
                <span class="stat-num"><?= $stats['total_categorias'] ?></span>
                <span class="stat-label">Categorías</span>
            </div>
        </div>
        <div class="stat-card stat-orange">
            <div class="stat-icon">⚠️</div>
            <div class="stat-info">
                <span class="stat-num"><?= $stats['sin_stock'] ?></span>
                <span class="stat-label">Sin stock</span>
            </div>
        </div>
        <div class="stat-card stat-purple">
            <div class="stat-icon">💰</div>
            <div class="stat-info">
                <span class="stat-num">$<?= number_format($stats['valor_inv'] ?? 0, 2) ?></span>
                <span class="stat-label">Valor inventario</span>
            </div>
        </div>
    </div>

    <!-- Accesos rápidos -->
    <div class="quick-actions">
        <h2 class="section-title">Accesos rápidos</h2>
        <div class="actions-grid">
            <a href="index.php?c=categorias&a=crear" class="action-card">
                <span class="action-icon">➕</span>
                <span>Nueva Categoría</span>
            </a>
            <a href="index.php?c=productos&a=crear" class="action-card">
                <span class="action-icon">➕</span>
                <span>Nuevo Producto</span>
            </a>
            <a href="index.php?c=categorias" class="action-card">
                <span class="action-icon">📋</span>
                <span>Ver Categorías</span>
            </a>
            <a href="index.php?c=productos" class="action-card">
                <span class="action-icon">📋</span>
                <span>Ver Productos</span>
            </a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
