<?php
$conexion = new mysqli("127.0.0.1", "root", "root", "mudaya", 8889);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>