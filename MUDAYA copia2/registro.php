<?php
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hashear contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, email, contraseña) 
            VALUES ('$nombre', '$email', '$password_hash')";

    if (mysqli_query($conexion, $sql)) {
        echo "Usuario registrado correctamente";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}
?>