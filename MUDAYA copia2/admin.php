<?php
include("conexion.php");

// 1. Consulta corregida usando el nuevo nombre 'id_camion'
// Hacemos un JOIN para ver el modelo del camión en lugar de solo el ID
$sql = "SELECT reservas.*, camiones.modelo, camiones.zona 
        FROM reservas 
        INNER JOIN camiones ON reservas.id_camion = camiones.id 
        ORDER BY reservas.fecha DESC";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MUDAYA | Panel de Administración</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Estilo rápido para la tabla de administración */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 10px;
            overflow: hidden;
        }
        .admin-table th, .admin-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .admin-table th {
            background-color: #4a90e2;
            color: white;
        }
    </style>
</head>
<body>
    <div class="main-wrapper">
        <header class="header-simple">
            <h1>Panel de <b>Administración</b></h1>
            <p>Listado de mudanzas reservadas</p>
        </header>

        <section class="booking-container">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID Reserva</th>
                        <th>Camión / Zona</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Carga (kg)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultado->num_rows > 0): ?>
                        <?php while($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td>
                                    <strong><?php echo $row['modelo']; ?></strong><br>
                                    <small><?php echo $row['zona']; ?></small>
                                </td>
                                <td><?php echo $row['fecha']; ?></td>
                                <td><?php echo $row['hora']; ?></td>
                                <td><?php echo $row['peso']; ?> kg</td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">No hay reservas registradas todavía.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <br>
            <a href="dashboard.php" class="btn-main" style="text-decoration:none; display:inline-block; text-align:center;">Volver al Mapa</a>
        </section>
    </div>
</body>
</html>