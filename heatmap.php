<?php 
require_once 'config.php';
redirectIfNotLogged();

$db = (new Database())->getConnection();

/* ================================
    1. GET TOTAL INCIDENTS
================================ */
$total_stmt = $db->query("SELECT COUNT(*) AS total FROM incidents");
$total_incidents = $total_stmt->fetch(PDO::FETCH_ASSOC)['total'];

/* ================================
    2. GET INCIDENTS RESOLVED
================================ */
$resolved_stmt = $db->query("SELECT COUNT(*) AS resolved FROM incidents WHERE status = 'resolved'");
$resolved_incidents = $resolved_stmt->fetch(PDO::FETCH_ASSOC)['resolved'];

/* ================================
    3. GET INCIDENT COUNT PER BARANGAY
================================ */
$barangay_stmt = $db->query("
    SELECT barangay, COUNT(*) AS incident_count 
    FROM incidents 
    GROUP BY barangay
");
$barangay_data = $barangay_stmt->fetchAll(PDO::FETCH_ASSOC);

/* Count high risk (incidentCount >= 16) */
$high_risk = 0;
foreach ($barangay_data as $b) {
    if ($b['incident_count'] >= 16) $high_risk++;
}

/* ================================
    4. BASE COORDINATES FOR SAN PABLO CITY
================================ */
$baseLat = 14.0856;
$baseLng = 121.3253;

/* ================================
    5. BARANGAY COORDINATES (example)
================================ */
// Replace these with actual coordinates from your database
$barangay_coords = [
    'Cogon' => ['lat' => 14.0870, 'lng' => 121.3240],
    'San Antonio' => ['lat' => 14.0900, 'lng' => 121.3280],
    'San Francisco' => ['lat' => 14.0820, 'lng' => 121.3200],
    // add all barangays...
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Heatmap Visualization - Municipality Incident Reporting</title>
<link rel="stylesheet" href="style.css">

<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- Cesium -->
<link href="https://cesium.com/downloads/cesiumjs/releases/1.120/Build/Cesium/Widgets/widgets.css" rel="stylesheet">
<script src="https://cesium.com/downloads/cesiumjs/releases/1.120/Build/Cesium/Cesium.js"></script>

<style>

#mapContainer2D, #mapContainer3D { width: 100%; height: 900px; }
#mapContainer3D { display: none%; }
.map-container { width: 100%; }

/* Modal styling */
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    left: 0; top: 0;
    width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.5);
}
.modal-content {
    background-color: #fff;
    padding: 20px;
    width: 600px;
    max-height: 80%;
    overflow-y: auto;
    position: fixed;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    border-radius: 8px;
}
.close { float: right; font-size: 24px; cursor: pointer; }
</style>
</head>
<body class="dashboard-page">
<?php include 'header.php'; ?>

<div class="dashboard-container">
    <div class="heat-content" style="background-color: white;">
        <header class="page-heat">
            <h1>Heatmap Visualization</h1>
            <p class="page-subt">Analyze incident hotspots across barangays with interactive filters.</p>
        </header>

        <!-- STATS -->
        <div class="heatmap-stats">
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Total Incidents</h3>
                    <div class="stat-number"><?= $total_incidents ?></div>
                    <div class="stat-subtext">Live data from reports</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>High-Risk Barangays</h3>
                    <div class="stat-number"><?= $high_risk ?></div>
                    <div class="stat-subtext">16+ incidents</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-info">
                    <h3>Incidents Resolved</h3>
                    <div class="stat-number"><?= $resolved_incidents ?></div>
                    <div class="stat-subtext">
                        <?= $total_incidents > 0 ? round(($resolved_incidents/$total_incidents)*100) : 0 ?>% resolution rate
                    </div>
                </div>
            </div>
        </div>

        <!-- MAP AREA -->
        <div class="map-area">
            <h3>Incident Heatmap by Barangay</h3>
            <div class="map-container">
                <button id="toggleMapBtn">Switch to 3D</button>
                <div id="mapContainer2D"></div>
                <div id="mapContainer3D"></div>
            </div>
        </div>

        <!-- MODAL -->
        <div id="incidentModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h3 id="modalTitle">Barangay Incident Details</h3>
                <div id="incidentListContainer">Loading...</div>
            </div>
        </div>

    </div>
</div>

<script>
// MODAL FUNCTIONS
function openModal(barangay) {
    document.getElementById('modalTitle').innerText = barangay + " – Incident List";
    fetch("heatmap_fetch.php?barangay=" + barangay)
        .then(res => res.text())
        .then(data => document.getElementById('incidentListContainer').innerHTML = data);
    document.getElementById('incidentModal').style.display = "block";
}
function closeModal() { document.getElementById('incidentModal').style.display = "none"; }

// BASE CITY COORDINATES
const cityLat = <?= $baseLat ?>;
const cityLng = <?= $baseLng ?>;

// === LEAFLET 2D MAP ===
const leafletMap = L.map('mapContainer2D').setView([cityLat, cityLng], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; OpenStreetMap contributors' }).addTo(leafletMap);

<?php foreach($barangay_data as $b):
    $barangay = htmlspecialchars($b['barangay']);
    $count = $b['incident_count'];
    $color = $count >= 16 ? 'red' : ($count >= 6 ? 'orange' : 'green');
    $lat = $barangay_coords[$b['barangay']]['lat'] ?? $baseLat;
    $lng = $barangay_coords[$b['barangay']]['lng'] ?? $baseLng;
?>
L.circle([<?= $lat ?>, <?= $lng ?>], { color: '<?= $color ?>', fillColor: '<?= $color ?>', fillOpacity: 0.5, radius: 200 })
.addTo(leafletMap)
.bindPopup("<b><?= $barangay ?></b><br>Incidents: <?= $count ?><br><button onclick=\"openModal('<?= $barangay ?>')\">View Details</button>");
<?php endforeach; ?>


let cesiumViewer = null;
let showingLeaflet = true;

document.getElementById('toggleMapBtn').addEventListener('click', function() {
    const map2D = document.getElementById('mapContainer2D');
    const map3D = document.getElementById('mapContainer3D');

    if (showingLeaflet) {
        // Hide 2D and show 3D
        map2D.style.display = 'none';
        map3D.style.display = 'block';
        this.textContent = 'Switch to 2D';
        showingLeaflet = false;

        // Initialize Cesium only when showing
        if (!cesiumViewer) {
            Cesium.Ion.defaultAccessToken = 'YOUR_CESIUM_TOKEN_HERE';
            cesiumViewer = new Cesium.Viewer('mapContainer3D', {
                terrainProvider: Cesium.createWorldTerrain(),
                timeline: false,
                animation: false
            });

            // Add barangay markers
            <?php foreach($barangay_data as $b):
                $barangay = htmlspecialchars($b['barangay']);
                $count = $b['incident_count'];
                $color = $count >= 16 ? 'Cesium.Color.RED' : ($count >= 6 ? 'Cesium.Color.ORANGE' : 'Cesium.Color.GREEN');
                $lat = $barangay_coords[$b['barangay']]['lat'] ?? $baseLat;
                $lng = $barangay_coords[$b['barangay']]['lng'] ?? $baseLng;
            ?>
            cesiumViewer.entities.add({
                name: "<?= $barangay ?>",
                position: Cesium.Cartesian3.fromDegrees(<?= $lng ?>, <?= $lat ?>, 0),
                point: { pixelSize: 12, color: <?= $color ?>, outlineColor: Cesium.Color.WHITE, outlineWidth: 2 },
                description: "<b><?= $barangay ?></b><br>Incidents: <?= $count ?><br><button onclick=\"openModal('<?= $barangay ?>')\">View Details</button>"
            });
            <?php endforeach; ?>

            cesiumViewer.camera.flyTo({
                destination: Cesium.Cartesian3.fromDegrees(<?= $baseLng ?>, <?= $baseLat ?>, 3000),
                orientation: { heading: 0, pitch: Cesium.Math.toRadians(-35), roll: 0 }
            });
        } else {
            // Recompute Cesium size if already initialized
            cesiumViewer.resize();
        }

    } else {
        // Switch back to Leaflet 2D
        map3D.style.display = 'none';
        map2D.style.display = 'block';
        this.textContent = 'Switch to 3D';
        showingLeaflet = true;
    }
});
</script>

</script>
</body>
</html>
<br><br>
<?php include 'footer.html'; ?>
