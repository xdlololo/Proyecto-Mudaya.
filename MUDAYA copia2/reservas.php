<?php
include("conexion.php");

$id_camion = $_POST['id_camion'];
$fecha     = $_POST['fecha'];
$hora      = $_POST['hora'];
$peso      = $_POST['peso'];

$sql_insert = "INSERT INTO reservas (id_camion, fecha, hora, peso) 
               VALUES ('$id_camion', '$fecha', '$hora', '$peso')";

if ($conexion->query($sql_insert) === TRUE) {

    // CAMIÓN PASA A OCUPADO
    $conexion->query("UPDATE camiones SET disponible = 0 WHERE id = '$id_camion'");

    header("Location: dashboard.php?status=success");
    exit();

} else {
    echo "Error: " . $conexion->error;
}
?>