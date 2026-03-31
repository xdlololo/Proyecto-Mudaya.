<?php
include("conexion.php");
session_start();

// LÓGICA DE REGISTRO
if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $pass   = password_hash($_POST['password'], PASSWORD_DEFAULT); // Seguridad

    $sql = "INSERT INTO usuarios (nombre, correo, password) VALUES ('$nombre', '$correo', '$pass')";

    if ($conexion->query($sql) === TRUE) {
        echo "<script>alert('Cuenta creada. Ya puedes iniciar sesión.'); window.location.href='index.php';</script>";
    } else {
        echo "Error: El correo ya existe.";
    }
}

// LÓGICA DE LOGIN
if (isset($_POST['login'])) {
    $correo = $_POST['correo'];
    $pass   = $_POST['password'];

    $res = $conexion->query("SELECT * FROM usuarios WHERE correo='$correo'");
    $user = $res->fetch_assoc();

    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['usuario'] = $user['nombre'];
        header("Location: dashboard.php");
    } else {
        echo "<script>alert('Correo o contraseña incorrectos'); window.location.href='index.php';</script>";
    }
}
?>