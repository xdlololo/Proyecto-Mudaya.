<?php
include("conexion.php");

header("Content-Type: application/json");

$sql = "SELECT reservas.id, 
               reservas.usuario_id,
               camiones.modelo AS camion,
               reservas.fecha,
               reservas.hora,
               reservas.peso,
               reservas.precio,
               reservas.estado
        FROM reservas
        INNER JOIN camiones ON reservas.id_camion = camiones.id";

$resultado = mysqli_query($conexion, $sql);

$reservas = array();

while ($fila = mysqli_fetch_assoc($resultado)) {
    $reservas[] = $fila;
}

echo json_encode($reservas);
?>