<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Tienda Deportiva' ?> — SportStore</title>
    <link rel="stylesheet" href="<?= BASE_CSS ?>css/estilos.css">
</head>
<body>

<header class="header">
    <div class="header-inner">
        <a href="index.php" class="logo">
            <span class="logo-icon">👟</span>
            <span class="logo-text">"JR Creaciones"</span>
        </a>
        <nav class="navbar">
            <a href="index.php" class="nav-link <?= (!isset($_GET['c'])) ? 'active' : '' ?>">Dashboard</a>
            <a href="index.php?c=categorias" class="nav-link <?= (($_GET['c'] ?? '') === 'categorias') ? 'active' : '' ?>">Categorías</a>
            <a href="index.php?c=productos"  class="nav-link <?= (($_GET['c'] ?? '') === 'productos')  ? 'active' : '' ?>">Productos</a>
        </nav>
    </div>
</header>

<main class="main-content">
