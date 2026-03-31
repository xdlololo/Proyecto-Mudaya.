<?php
include("seguridad.php");

$texto = "Valencia";

// Encriptar
$encriptado = encriptar($texto);

// Desencriptar
$desencriptado = desencriptar($encriptado);

echo "Original: " . $texto . "<br>";
echo "Encriptado: " . $encriptado . "<br>";
echo "Desencriptado: " . $desencriptado;
?>