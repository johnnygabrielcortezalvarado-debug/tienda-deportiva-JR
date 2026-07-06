<?php
// ============================================================
// app/controllers/CategoriaController.php
// Controlador — lógica de negocio para categorías
// ============================================================

require_once __DIR__ . '/../models/CategoriaModel.php';

class CategoriaController {

    private CategoriaModel $model;

    public function __construct() {
        $this->model = new CategoriaModel();
    }

    // ── Listar categorías ─────────────────────────────────
    public function index(): void {
        $categorias = $this->model->getAll();
        require __DIR__ . '/../views/categorias/index.php';
    }

    // ── Mostrar formulario de creación ────────────────────
    public function crear(): void {
        require __DIR__ . '/../views/categorias/crear.php';
    }

    // ── Guardar nueva categoría ───────────────────────────
    public function guardar(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php?c=categorias'); exit; }

        $nombre      = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $estado      = isset($_POST['estado']) ? 1 : 0;

        $errores = [];
        if ($nombre === '')          $errores[] = 'El nombre es obligatorio.';
        if (strlen($nombre) > 100)   $errores[] = 'El nombre no puede superar 100 caracteres.';

        if (!empty($errores)) {
            $error = implode('<br>', $errores);
            require __DIR__ . '/../views/categorias/crear.php';
            return;
        }

        if ($this->model->create($nombre, $descripcion, $estado)) {
            header('Location: index.php?c=categorias&msg=creado');
        } else {
            $error = 'Error al guardar la categoría.';
            require __DIR__ . '/../views/categorias/crear.php';
        }
    }

    // ── Mostrar formulario de edición ─────────────────────
    public function editar(): void {
        $id = (int)($_GET['id'] ?? 0);
        $categoria = $this->model->getById($id);
        if (!$categoria) { header('Location: index.php?c=categorias&msg=noexiste'); exit; }
        require __DIR__ . '/../views/categorias/editar.php';
    }

    // ── Actualizar categoría ──────────────────────────────
    public function actualizar(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php?c=categorias'); exit; }

        $id          = (int)($_POST['id'] ?? 0);
        $nombre      = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $estado      = isset($_POST['estado']) ? 1 : 0;

        $errores = [];
        if ($nombre === '')        $errores[] = 'El nombre es obligatorio.';
        if (strlen($nombre) > 100) $errores[] = 'El nombre no puede superar 100 caracteres.';

        if (!empty($errores)) {
            $categoria = $this->model->getById($id);
            $error = implode('<br>', $errores);
            require __DIR__ . '/../views/categorias/editar.php';
            return;
        }

        if ($this->model->update($id, $nombre, $descripcion, $estado)) {
            header('Location: index.php?c=categorias&msg=actualizado');
        } else {
            $error = 'Error al actualizar la categoría.';
            $categoria = $this->model->getById($id);
            require __DIR__ . '/../views/categorias/editar.php';
        }
    }

    // ── Eliminar categoría ────────────────────────────────
    public function eliminar(): void {
        $id = (int)($_GET['id'] ?? 0);
        if ($this->model->delete($id)) {
            header('Location: index.php?c=categorias&msg=eliminado');
        } else {
            header('Location: index.php?c=categorias&msg=nodeletar');
        }
        exit;
    }
}
