<?php
// ============================================================
// app/controllers/ProductoController.php
// Controlador — lógica de negocio para productos
// ============================================================

require_once __DIR__ . '/../models/ProductoModel.php';
require_once __DIR__ . '/../models/CategoriaModel.php';

class ProductoController {

    private ProductoModel  $model;
    private CategoriaModel $catModel;

    public function __construct() {
        $this->model    = new ProductoModel();
        $this->catModel = new CategoriaModel();
    }

    // ── Listar productos ──────────────────────────────────
    public function index(): void {
        $busqueda = trim($_GET['buscar'] ?? '');
        $productos = $busqueda
            ? $this->model->buscar($busqueda)
            : $this->model->getAll();
        $stats = $this->model->getStats();
        require __DIR__ . '/../views/productos/index.php';
    }

    // ── Mostrar formulario de creación ────────────────────
    public function crear(): void {
        $categorias = $this->catModel->getActivas();
        require __DIR__ . '/../views/productos/crear.php';
    }

    // ── Guardar nuevo producto ────────────────────────────
    public function guardar(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php?c=productos'); exit; }

        $data = [
            'categoria_id' => (int)($_POST['categoria_id'] ?? 0),
            'nombre'       => trim($_POST['nombre'] ?? ''),
            'descripcion'  => trim($_POST['descripcion'] ?? ''),
            'precio'       => (float)($_POST['precio'] ?? 0),
            'stock'        => (int)($_POST['stock'] ?? 0),
            'talla'        => trim($_POST['talla'] ?? ''),
            'imagen_url'   => trim($_POST['imagen_url'] ?? ''),
            'estado'       => isset($_POST['estado']) ? 1 : 0,
        ];

        $errores = $this->validar($data);

        if (!empty($errores)) {
            $categorias = $this->catModel->getActivas();
            $error = implode('<br>', $errores);
            require __DIR__ . '/../views/productos/crear.php';
            return;
        }

        if ($this->model->create($data)) {
            header('Location: index.php?c=productos&msg=creado');
        } else {
            $categorias = $this->catModel->getActivas();
            $error = 'Error al guardar el producto.';
            require __DIR__ . '/../views/productos/crear.php';
        }
    }

    // ── Mostrar formulario de edición ─────────────────────
    public function editar(): void {
        $id = (int)($_GET['id'] ?? 0);
        $producto   = $this->model->getById($id);
        $categorias = $this->catModel->getActivas();
        if (!$producto) { header('Location: index.php?c=productos&msg=noexiste'); exit; }
        require __DIR__ . '/../views/productos/editar.php';
    }

    // ── Actualizar producto ───────────────────────────────
    public function actualizar(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php?c=productos'); exit; }

        $id   = (int)($_POST['id'] ?? 0);
        $data = [
            'categoria_id' => (int)($_POST['categoria_id'] ?? 0),
            'nombre'       => trim($_POST['nombre'] ?? ''),
            'descripcion'  => trim($_POST['descripcion'] ?? ''),
            'precio'       => (float)($_POST['precio'] ?? 0),
            'stock'        => (int)($_POST['stock'] ?? 0),
            'talla'        => trim($_POST['talla'] ?? ''),
            'imagen_url'   => trim($_POST['imagen_url'] ?? ''),
            'estado'       => isset($_POST['estado']) ? 1 : 0,
        ];

        $errores = $this->validar($data);

        if (!empty($errores)) {
            $producto   = $this->model->getById($id);
            $categorias = $this->catModel->getActivas();
            $error = implode('<br>', $errores);
            require __DIR__ . '/../views/productos/editar.php';
            return;
        }

        if ($this->model->update($id, $data)) {
            header('Location: index.php?c=productos&msg=actualizado');
        } else {
            $producto   = $this->model->getById($id);
            $categorias = $this->catModel->getActivas();
            $error = 'Error al actualizar el producto.';
            require __DIR__ . '/../views/productos/editar.php';
        }
    }

    // ── Eliminar producto ─────────────────────────────────
    public function eliminar(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($this->model->delete($id)) {
            header('Location: index.php?c=productos&msg=eliminado');
        } else {
            header('Location: index.php?c=productos&msg=error');
        }
        exit;
    }

    // ── Validaciones backend ──────────────────────────────
    private function validar(array $data): array {
        $errores = [];
        if ($data['categoria_id'] <= 0)    $errores[] = 'Selecciona una categoría válida.';
        if ($data['nombre'] === '')         $errores[] = 'El nombre del producto es obligatorio.';
        if (strlen($data['nombre']) > 150)  $errores[] = 'El nombre no puede superar 150 caracteres.';
        if ($data['precio'] <= 0)           $errores[] = 'El precio debe ser mayor a 0.';
        if ($data['stock'] < 0)             $errores[] = 'El stock no puede ser negativo.';
        return $errores;
    }
}
