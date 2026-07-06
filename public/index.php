<?php
// ============================================================
// public/index.php — Punto de entrada y enrutador MVC
// Tienda de Ropa Deportiva
// ============================================================

define('BASE_PATH', dirname(__DIR__) . '/');
define('BASE_CSS',  '');

require_once BASE_PATH . 'config/database.php';
require_once BASE_PATH . 'app/models/CategoriaModel.php';
require_once BASE_PATH . 'app/models/ProductoModel.php';
require_once BASE_PATH . 'app/controllers/CategoriaController.php';
require_once BASE_PATH . 'app/controllers/ProductoController.php';

$controlador = $_GET['c'] ?? 'dashboard';
$accion      = $_GET['a'] ?? 'index';

// ── Enrutamiento ──────────────────────────────────────────
switch ($controlador) {

    case 'categorias':
        $ctrl = new CategoriaController();
        switch ($accion) {
            case 'crear':    $ctrl->crear();    break;
            case 'guardar':  $ctrl->guardar();  break;
            case 'editar':   $ctrl->editar();   break;
            case 'actualizar': $ctrl->actualizar(); break;
            case 'eliminar': $ctrl->eliminar(); break;
            default:         $ctrl->index();    break;
        }
        break;

    case 'productos':
        $ctrl = new ProductoController();
        switch ($accion) {
            case 'crear':    $ctrl->crear();    break;
            case 'guardar':  $ctrl->guardar();  break;
            case 'editar':   $ctrl->editar();   break;
            case 'actualizar': $ctrl->actualizar(); break;
            case 'eliminar': $ctrl->eliminar(); break;
            default:         $ctrl->index();    break;
        }
        break;

    default:
        // Dashboard
        $catModel  = new CategoriaModel();
        $prodModel = new ProductoModel();
        $prodStats = $prodModel->getStats();
        $stats = [
            'total_productos'  => $prodStats['total'],
            'total_categorias' => count($catModel->getAll()),
            'sin_stock'        => $prodStats['sin_stock'],
            'valor_inv'        => $prodStats['valor_inv'],
        ];
        require BASE_PATH . 'app/views/dashboard.php';
        break;
}
