<?php
require_once "config.php";
redirectIfNotLogged();

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Missing ID"]);
    exit;
}

$incident_id = intval($_GET['id']);

$db = (new Database())->getConnection();

$sql = "SELECT * FROM incidents WHERE id = :id LIMIT 1";
$stmt = $db->prepare($sql);
$stmt->bindParam(":id", $incident_id);
$stmt->execute();
$incident = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$incident) {
    echo json_encode(["error" => "Incident not found"]);
    exit;
}

$sql2 = "SELECT * FROM incident_files WHERE incident_id = :id";
$stmt2 = $db->prepare($sql2);
$stmt2->bindParam(":id", $incident_id);
$stmt2->execute();
$files = $stmt2->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "incident" => $incident,
    "files" => $files
]);
?>
