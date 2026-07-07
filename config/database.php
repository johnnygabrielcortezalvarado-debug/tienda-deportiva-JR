<?php
// Usar getenv() para leer las variables de Railway, y si están vacías, usar los valores de XAMPP
$host = getenv('MYSQLHOST') ?: 'localhost';
$user = getenv('MYSQLUSER') ?: 'root';
$pass = getenv('MYSQLPASSWORD') ?: 'Gabo2025*';
$db   = getenv('MYSQLDATABASE') ?: 'tienda_deportiva'; // Cambia por el nombre real de tu BD en XAMPP
$port = getenv('MYSQLPORT') ?: 3306;

// Creamos la conexión con MySQLi
$conexion = new mysqli($host, $user, $pass, $db, $port);

// Verificar si hubo error de conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Función global para retornar la conexión a tus modelos
function getConnection() {
    global $conexion;
    return $conexion;
}
?>
