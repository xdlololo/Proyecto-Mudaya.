<?php
session_start();
include("conexion.php");

// Obtener usuario logueado
$usuario_id = $_SESSION['usuario_id'];

$id_camion = $_POST['id_camion'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$peso = $_POST['peso'];
$estado = "Pendiente";

$sql = "INSERT INTO reservas (usuario_id, id_camion, fecha, hora, peso, estado)
        VALUES ('$usuario_id', '$id_camion', '$fecha', '$hora', '$peso', '$estado')";

if (mysqli_query($conexion, $sql)) {
    echo "Reserva creada correctamente";
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>