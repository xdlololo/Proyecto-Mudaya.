<?php
// 1. CABECERAS (Indispensable para que sea una API funcional - Punto 3 PSP)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

// 2. CONFIGURACIÓN DE CONEXIÓN
$host = "localhost";
$user = "root";
$pass = "root"; // Password por defecto en MAMP
$db   = "MUDAYA"; // Nombre de tu base de datos en mayúsculas

// Conectamos a la base de datos
$conexion = @mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error de conexión: " . mysqli_connect_error()
    ]);
    exit;
}

// 3. EL CONTRATO (Seguridad del servicio - Punto 3 PSP)
$api_key_maestra = "MUDAYA_2026_TOKEN";
$token_recibido = $_GET['token'] ?? '';

if ($token_recibido !== $api_key_maestra) {
    http_response_code(401); // No autorizado
    echo json_encode([
        "status" => "error",
        "message" => "Acceso denegado. Token de API no válido o ausente."
    ]);
    exit;
}

// 4. LÓGICA DEL SERVIDOR (Consulta de datos - Punto 2 PSP)
// Usamos SELECT * para que no importe cómo se llamen tus columnas
$sql = "SELECT * FROM camiones";
$resultado_query = mysqli_query($conexion, $sql);

// Verificamos si la consulta falló (por ejemplo, si la tabla no existe)
if (!$resultado_query) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Error en la consulta SQL: " . mysqli_error($conexion)
    ]);
    exit;
}

// 5. PROCESAMIENTO Y RESPUESTA JSON
$camiones = [];
while ($fila = mysqli_fetch_assoc($resultado_query)) {
    $camiones[] = $fila;
}

// Enviamos los datos al cliente (Rol de servidor)
http_response_code(200);
echo json_encode([
    "status" => "success",
    "info" => "Datos servidos desde la API Mudaya",
    "count" => count($camiones),
    "data" => $camiones
]);

// Cerramos conexión
mysqli_close($conexion);
?>