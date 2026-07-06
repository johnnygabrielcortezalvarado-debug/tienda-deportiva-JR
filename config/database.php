<?php
// ============================================================
// config/database.php — Conexión a MySQL
// Tienda de Ropa Deportiva
// ============================================================

define('DB_HOST', 'sql211.infinityfree.com');
define('DB_USER', 'if0_42346135');
define('DB_PASS', 'Gabo202517');
define('DB_NAME', 'if0_42346135_jrcreaciones');

function getConnection(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            die('<div style="font-family:Arial;color:#c0392b;padding:20px;">
                 <h2>Error de conexión</h2><p>' . $e->getMessage() . '</p></div>');
        }
    }
    return $pdo;
}
