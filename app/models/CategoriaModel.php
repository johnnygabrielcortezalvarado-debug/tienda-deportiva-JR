<?php
// ============================================================
// app/models/CategoriaModel.php
// Modelo — acceso y gestión de datos de categorías
// ============================================================

require_once __DIR__ . '/../../config/database.php';

class CategoriaModel {

    private PDO $db;

    public function __construct() {
        $this->db = getConnection();
    }

    // ── Obtener todas las categorías ──────────────────────
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM categorias ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    // ── Obtener solo categorías activas ───────────────────
    public function getActivas(): array {
        $stmt = $this->db->query("SELECT * FROM categorias WHERE estado = 1 ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    // ── Obtener una categoría por ID ──────────────────────
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ── Crear categoría ───────────────────────────────────
    public function create(string $nombre, string $descripcion, int $estado): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO categorias (nombre, descripcion, estado) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$nombre, $descripcion, $estado]);
    }

    // ── Actualizar categoría ──────────────────────────────
    public function update(int $id, string $nombre, string $descripcion, int $estado): bool {
        $stmt = $this->db->prepare(
            "UPDATE categorias SET nombre = ?, descripcion = ?, estado = ? WHERE id = ?"
        );
        return $stmt->execute([$nombre, $descripcion, $estado, $id]);
    }

    // ── Eliminar categoría ────────────────────────────────
    public function delete(int $id): bool {
        // Verificar si tiene productos asociados
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE categoria_id = ?");
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() > 0) {
            return false; // No eliminar si tiene productos
        }
        $stmt = $this->db->prepare("DELETE FROM categorias WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ── Contar productos por categoría ────────────────────
    public function countProductos(int $id): int {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE categoria_id = ?");
        $stmt->execute([$id]);
        return (int) $stmt->fetchColumn();
    }
}
