<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'No autoritzat']);
    exit();
}

$user_id = $_SESSION['user_id'];
$esdeveniment_id = $_POST['esdeveniment_id'] ?? null;
$comentari = $_POST['comentari'] ?? null;

if ($esdeveniment_id && $comentari) {
    $estat = 'pendent'; // Els comentaris nous comencen amb estat 'pendent'

    $sql = "INSERT INTO Comentaris (usuari_id, esdeveniment_id, comentari, estat) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $esdeveniment_id, $comentari, $estat]);

    echo json_encode(['success' => true]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Dades incompletes']);
}
?>
