document.addEventListener('DOMContentLoaded', () => {

    // 1. Centrar mapa en Valencia
    const map = L.map('map').setView([39.4697, -0.3774], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    // 2. Icono gris para camiones OCUPADOS
    const grayIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-grey.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    // 3. Cargar camiones desde mapa.php
    fetch('mapa.php?v=' + Date.now())
        .then(response => response.json())
        .then(data => {

            data.forEach(camion => {

                // Leer coordenadas (latitud o lat)
                const lat = parseFloat(camion.latitud ?? camion.lat);
                const lng = parseFloat(camion.longitud ?? camion.lng);

                if (!isNaN(lat) && !isNaN(lng)) {

                    let markerOptions = {};
                    let estadoTexto = "<b style='color:green;'>Disponible</b>";

                    // 🔥 CAMBIO IMPORTANTE:
                    // Ahora usamos disponible_real (calculado desde reservas)
                    if (Number(camion.disponible_real) === 0) {
                        markerOptions = { icon: grayIcon };
                        estadoTexto = "<b style='color:red;'>OCUPADO</b>";
                    }

                    const marker = L.marker([lat, lng], markerOptions).addTo(map);

                    marker.bindPopup(`
                        <b>Modelo:</b> ${camion.modelo}<br>
                        <b>Zona:</b> ${camion.zona}<br>
                        <b>Estado:</b> ${estadoTexto}
                    `);
                }
            });

        })
        .catch(err => console.error("Error cargando el mapa:", err));
});