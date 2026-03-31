<?php
include("conexion.php");

// Traemos los camiones y comprobamos si tienen reserva activa
$sql = "
SELECT c.*, 
       CASE 
           WHEN r.id_camion IS NOT NULL THEN 0
           ELSE 1
       END AS disponible_real
FROM camiones c
LEFT JOIN reservas r ON c.id = r.id_camion
";

$resultado = $conexion->query($sql);

$camiones = [];

while ($fila = $resultado->fetch_assoc()) {
    $camiones[] = $fila;
}

header('Content-Type: application/json');
echo json_encode($camiones);
?>