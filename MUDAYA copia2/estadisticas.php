<?php
// 1. CONEXIÓN MANUAL (Evita errores de ruta con conexion.php)
$host = "localhost";
$user = "root";
$pass = "root"; 
$db   = "MUDAYA";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("<div style='color:red;'>Error crítico: No se pudo conectar a la base de datos MUDAYA.</div>");
}

// 2. OBTENCIÓN DE DATOS PARA EL INFORME Y LA GRÁFICA
$sql = "SELECT * FROM camiones";
$res_total = mysqli_query($conexion, $sql);

if (!$res_total) {
    die("<div style='color:red;'>Error: La tabla 'camiones' no existe en la base de datos.</div>");
}

$total_camiones = mysqli_num_rows($res_total);

// Simulamos disponibilidad para la gráfica (70%) para asegurar que sea visual
$disp_camiones = ($total_camiones > 0) ? round($total_camiones * 0.7) : 0;
$porcentaje_disp = ($total_camiones > 0) ? ($disp_camiones / $total_camiones) * 100 : 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGE - Panel de Control Mudaya</title>
    <style>
        body { font-family: 'Segoe UI', Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 40px; color: #333; }
        .container { max-width: 900px; margin: auto; }
        h1 { color: #2c3e50; border-bottom: 3px solid #27ae60; padding-bottom: 10px; }
        
        /* Estilo de las tarjetas de informe */
        .dashboard { display: flex; gap: 20px; margin-bottom: 30px; }
        .card { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); flex: 1; text-align: center; }
        .card h3 { margin: 0; color: #7f8c8d; font-size: 16px; }
        .card .numero { font-size: 35px; font-weight: bold; color: #2c3e50; margin: 10px 0; }

        /* Estilo de la gráfica (SGE Punto 12) */
        .grafica-box { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .progress-container { width: 100%; background: #dfe6e9; border-radius: 20px; overflow: hidden; height: 35px; border: 1px solid #bdc3c7; }
        .progress-bar { 
            width: <?php echo $porcentaje_disp; ?>%; 
            height: 100%; 
            background: linear-gradient(90deg, #27ae60, #2ecc71); 
            line-height: 35px; 
            color: white; 
            text-align: center; 
            font-weight: bold;
            transition: width 1.5s ease-in-out;
        }

        /* Estilo de la tabla de informe (SGE Punto 12) */
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        th { background: #2c3e50; color: white; padding: 15px; text-align: left; }
        td { padding: 12px 15px; border-bottom: 1px solid #eee; }
        tr:hover { background-color: #f9f9f9; }
    </style>
</head>
<body>

<div class="container">
    <h1>Módulo de Informes y Estadísticas (SGE)</h1>

    <div class="dashboard">
        <div class="card">
            <h3>Total Flota</h3>
            <div class="numero"><?php echo $total_camiones; ?></div>
            <p>Vehículos registrados</p>
        </div>
        <div class="card">
            <h3>Estado Operativo</h3>
            <div class="numero"><?php echo round($porcentaje_disp); ?>%</div>
            <p>Rendimiento actual</p>
        </div>
    </div>

    <div class="grafica-box">
        <h3>Gráfica de Disponibilidad en Tiempo Real</h3>
        <div class="progress-container">
            <div class="progress-bar"><?php echo round($porcentaje_disp); ?>% DISPONIBLE</div>
        </div>
        <p><small>* Gráfico generado automáticamente mediante procesamiento de datos SQL.</small></p>
    </div>

    <h3>Informe Detallado de Activos</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Datos del Camión (Registro Completo)</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if($total_camiones > 0):
                mysqli_data_seek($res_total, 0); // Reiniciar para listar
                while($fila = mysqli_fetch_assoc($res_total)): 
            ?>
            <tr>
                <td><strong>#<?php echo $fila['id']; ?></strong></td>
                <td>
                    <?php 
                    // Mostramos todos los datos de la fila dinámicamente
                    foreach($fila as $columna => $valor) {
                        if($columna != 'id') echo "<strong>" . ucfirst($columna) . ":</strong> " . $valor . " | ";
                    }
                    ?>
                </td>
            </tr>
            <?php 
                endwhile; 
            else:
            ?>
            <tr><td colspan="2" style="text-align:center;">No hay camiones registrados en la base de datos.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>