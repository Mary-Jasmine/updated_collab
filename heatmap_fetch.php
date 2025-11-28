<?php
require_once "config.php";

$db = (new Database())->getConnection();

if (!isset($_GET['barangay'])) {
    echo "<p>Invalid barangay.</p>";
    exit;
}

$barangay = $_GET['barangay'];

// ✅ Match the REAL column names in your database
$stmt = $db->prepare("
    SELECT id, incident_type, description, status, submitted_at
    FROM incidents
    WHERE barangay = ?
    ORDER BY submitted_at DESC
");
$stmt->execute([$barangay]);

$incidents = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($incidents) === 0) {
    echo "<p>No incidents found for this barangay.</p>";
    exit;
}

echo "<table class='incident-table'>
        <tr>
            <th>ID</th>
            <th>Type</th>
            <th>Description</th>
            <th>Status</th>
            <th>Date Submitted</th>
        </tr>";

foreach ($incidents as $row) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['incident_type']}</td>
            <td>{$row['description']}</td>
            <td>{$row['status']}</td>
            <td>{$row['submitted_at']}</td>
         </tr>";
}

echo "</table>";
