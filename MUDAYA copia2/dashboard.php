<?php 
include("conexion.php"); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MUDAYA CRM | Panel de Reservas</title>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body>

<div class="main-wrapper">

    <header class="header-simple">
        <a href="logout.php" class="btn-logout-style">
            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>
        <h1>MUDAYA <b>CRM</b></h1>
        <p>Encuentra y reserva tu camión de mudanza en Valencia</p>
    </header>

    <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div id="success-alert" style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 12px; text-align: center; margin-bottom: 20px; font-weight: bold; font-family: sans-serif; transition: opacity 0.5s ease;">
            ✅ ¡Reserva realizada con éxito!
        </div>
    <?php endif; ?>

    <section class="map-section">
        <div id="map" style="height: 400px; border-radius: 15px;"></div>
    </section>

    <section class="booking-container">
        <h2>Hacer una Reserva</h2>

        <form action="reservas.php" method="POST" class="booking-grid">
            
            <div class="field-group">
                <label>Zona de recogida (Valencia)</label>
                <select name="id_camion" required>
                    <option value="" disabled selected>Selecciona ubicación...</option>

                    <?php
                    // 🔥 CONSULTA DINÁMICA (NO usa la columna disponible)
                    $sql = "
                    SELECT c.id, c.modelo, c.zona,
                           CASE 
                               WHEN r.id_camion IS NOT NULL THEN 0
                               ELSE 1
                           END AS disponible_real
                    FROM camiones c
                    LEFT JOIN reservas r ON c.id = r.id_camion
                    ";

                    $res = $conexion->query($sql);

                    while($f = $res->fetch_assoc()){
                        if($f['disponible_real'] == 1){
                            echo "<option value='".$f['id']."'>".$f['zona']." (".$f['modelo'].")</option>";
                        } else {
                            echo "<option value='".$f['id']."' disabled style='color:#999;background:#eee;'>".$f['zona']." (".$f['modelo'].") - [OCUPADO]</option>";
                        }
                    }
                    ?>

                </select>
            </div>

            <div class="field-group">
                <label>Fecha de Mudanza</label>
                <input type="date" name="fecha" id="fecha_mudanza" required>
            </div>

            <div class="field-group">
                <label>Hora</label>
                <input type="time" name="hora" required>
            </div>

            <div class="field-group">
                <label>Carga estimada (kg)</label>
                <input type="number" name="peso" placeholder="Ej: 450" required>
            </div>

            <div class="field-group full-width">
                <button type="submit" class="btn-main">Confirmar Reserva</button>
            </div>

        </form>

        <div class="admin-link-container" style="margin-top: 20px; text-align: center;">
            <a href="admin.php" class="link-alt">Panel de administración</a>
        </div>

    </section>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="script.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const inputFecha = document.getElementById('fecha_mudanza');
    if(inputFecha) {
        const hoy = new Date().toISOString().split('T')[0];
        inputFecha.setAttribute('min', hoy);
    }

    const alert = document.getElementById('success-alert');
    if(alert) {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    }
});
</script>

</body>
</html>