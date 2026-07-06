<?php
// ============================================================
// app/models/ProductoModel.php
// Modelo — acceso y gestión de datos de productos
// ============================================================

require_once __DIR__ . '/../../config/database.php';

class ProductoModel {

    private PDO $db;

    public function __construct() {
        $this->db = getConnection();
    }

    // ── Obtener todos los productos con nombre de categoría ──
    public function getAll(): array {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre
                FROM productos p
                INNER JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.nombre ASC";
        return $this->db->query($sql)->fetchAll();
    }

    // ── Obtener un producto por ID ────────────────────────
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.nombre AS categoria_nombre
             FROM productos p
             INNER JOIN categorias c ON p.categoria_id = c.id
             WHERE p.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // ── Buscar productos por nombre ───────────────────────
    public function buscar(string $termino): array {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.nombre AS categoria_nombre
             FROM productos p
             INNER JOIN categorias c ON p.categoria_id = c.id
             WHERE p.nombre LIKE ? OR c.nombre LIKE ?
             ORDER BY p.nombre ASC"
        );
        $like = "%$termino%";
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll();
    }

    // ── Crear producto ────────────────────────────────────
    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, talla, imagen_url, estado)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['categoria_id'],
            $data['nombre'],
            $data['descripcion'],
            $data['precio'],
            $data['stock'],
            $data['talla'],
            $data['imagen_url'],
            $data['estado'],
        ]);
    }

    // ── Actualizar producto ───────────────────────────────
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE productos
             SET categoria_id=?, nombre=?, descripcion=?, precio=?, stock=?, talla=?, imagen_url=?, estado=?
             WHERE id=?"
        );
        return $stmt->execute([
            $data['categoria_id'],
            $data['nombre'],
            $data['descripcion'],
            $data['precio'],
            $data['stock'],
            $data['talla'],
            $data['imagen_url'],
            $data['estado'],
            $id,
        ]);
    }

    // ── Eliminar producto ─────────────────────────────────
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // ── Estadísticas para el dashboard ───────────────────
    public function getStats(): array {
        $stats = [];
        $stats['total']      = $this->db->query("SELECT COUNT(*) FROM productos")->fetchColumn();
        $stats['sin_stock']  = $this->db->query("SELECT COUNT(*) FROM productos WHERE stock = 0")->fetchColumn();
        $stats['valor_inv']  = $this->db->query("SELECT SUM(precio * stock) FROM productos")->fetchColumn();
        return $stats;
    }
}
