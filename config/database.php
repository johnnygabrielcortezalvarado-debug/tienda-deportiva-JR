<?php
// Usamos getenv() para leer las variables que Railway le mandará al servidor
$host = getenv('MYSQLHOST');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');
$port = getenv('MYSQLPORT');

// Creamos la conexión (ejemplo con MySQLi)
$conexion = new mysqli($host, $user, $pass, $db, $port);

// Verificar si hubo error de conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
