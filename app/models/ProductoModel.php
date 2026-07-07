<?php
// ============================================================
// app/models/ProductoModel.php (Versión limpia con MySQLi)
// ============================================================

require_once __DIR__ . '/../../config/database.php';

class ProductoModel {

    private $db;

    public function __construct() {
        $this->db = getConnection(); 
    }

    public function getAll(): array {
        $sql = "SELECT p.*, c.nombre AS categoria_nombre
                FROM productos p
                INNER JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.nombre ASC";
        $result = $this->db->query($sql);
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function getById(int $id): array|false {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.nombre AS categoria_nombre
             FROM productos p
             INNER JOIN categorias c ON p.categoria_id = c.id
             WHERE p.id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function buscar(string $termino): array {
        $stmt = $this->db->prepare(
            "SELECT p.*, c.nombre AS categoria_nombre
             FROM productos p
             INNER JOIN categorias c ON p.categoria_id = c.id
             WHERE p.nombre LIKE ? OR c.nombre LIKE ?
             ORDER BY p.nombre ASC"
        );
        $like = "%$termino%";
        $stmt->bind_param("ss", $like, $like);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO productos (categoria_id, nombre, descripcion, precio, stock, talla, imagen_url, estado)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "issdiisi", 
            $data['categoria_id'],
            $data['nombre'],
            $data['descripcion'],
            $data['precio'],
            $data['stock'],
            $data['talla'],
            $data['imagen_url'],
            $data['estado']
        );
        return $stmt->execute();
    }

    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE productos
             SET categoria_id=?, nombre=?, descripcion=?, precio=?, stock=?, talla=?, imagen_url=?, estado=?
             WHERE id=?"
        );
        $stmt->bind_param(
            "issdiisii", 
            $data['categoria_id'],
            $data['nombre'],
            $data['descripcion'],
            $data['precio'],
            $data['stock'],
            $data['talla'],
            $data['imagen_url'],
            $data['estado'],
            $id
        );
        return $stmt->execute();
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getStats(): array {
        $stats = [];
        $resTotal = $this->db->query("SELECT COUNT(*) FROM productos");
        $stats['total'] = $resTotal ? (int)$resTotal->fetch_row()[0] : 0;

        $resStock = $this->db->query("SELECT COUNT(*) FROM productos WHERE stock = 0");
        $stats['sin_stock'] = $resStock ? (int)$resStock->fetch_row()[0] : 0;

        $resInv = $this->db->query("SELECT SUM(precio * stock) FROM productos");
        $stats['valor_inv'] = $resInv ? (float)$resInv->fetch_row()[0] : 0.0;

        return $stats;
    }
}