<?php
// ============================================================
// app/models/CategoriaModel.php (Versión adaptada a MySQLi)
// ============================================================

require_once __DIR__ . '/../../config/database.php';

class CategoriaModel {

    private $db;

    public function __construct() {
        $this->db = getConnection(); // Retorna la conexión mysqli de tu archivo database.php
    }

    // ── Obtener todas las categorías ──────────────────────
    public function getAll(): array {
        $result = $this->db->query("SELECT * FROM categorias ORDER BY nombre ASC");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // ── Obtener solo categorías activas ───────────────────
    public function getActivas(): array {
        $result = $this->db->query("SELECT * FROM categorias WHERE estado = 1 ORDER BY nombre ASC");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // ── Obtener una categoría por ID ──────────────────────
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // ── Crear categoría ───────────────────────────────────
    public function create(string $nombre, string $descripcion, int $estado): bool {
        $stmt = $this->db->prepare("INSERT INTO categorias (nombre, descripcion, estado) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $nombre, $descripcion, $estado);
        return $stmt->execute();
    }

    // ── Actualizar categoría ──────────────────────────────
    public function update(int $id, string $nombre, string $descripcion, int $estado): bool {
        $stmt = $this->db->prepare("UPDATE categorias SET nombre = ?, descripcion = ?, estado = ? WHERE id = ?");
        $stmt->bind_param("ssii", $nombre, $descripcion, $estado, $id);
        return $stmt->execute();
    }

    // ── Eliminar categoría ────────────────────────────────
    public function delete(int $id): bool {
        $stmtCheck = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE categoria_id = ?");
        $stmtCheck->bind_param("i", $id);
        $stmtCheck->execute();
        $count = $stmtCheck->get_result()->fetch_row()[0];

        if ($count > 0) {
            return false; // No eliminar si tiene productos
        }
        
        $stmt = $this->db->prepare("DELETE FROM categorias WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    // ── Contar productos por categoría ────────────────────
    public function countProductos(int $id): int {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM productos WHERE categoria_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return (int) $stmt->get_result()->fetch_row()[0];
    }
}