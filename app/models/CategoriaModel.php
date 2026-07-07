<?php
// ============================================================
// app/models/ProductoModel.php (Versión adaptada a MySQLi)
// ============================================================

require_once __DIR__ . '/../../config/database.php';

class ProductoModel {

    private $db;

    public function __construct() {
        $this->db = getConnection(); // Recibe la conexión mysqli
    }

    // ── Obtener todos los productos ───────────────────────
    public function getAll(): array {
        $result = $this->db->query("SELECT * FROM productos ORDER BY id DESC");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    // ── Obtener un producto por ID ────────────────────────
    public function getById(int $id): array|false {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // ── Crear producto ────────────────────────────────────
    public function create(string $nombre, float $precio, int $stock, int $categoria_id): bool {
        $stmt = $this->db->prepare("INSERT INTO productos (nombre, precio, stock, categoria_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdii", $nombre, $precio, $stock, $categoria_id);
        return $stmt->execute();
    }
}