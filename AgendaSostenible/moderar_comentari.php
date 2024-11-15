<?php
session_start();
if ($_SESSION['rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}

require 'db_connection.php';

$comentari_id = $_POST['comentari_id'];
$action = $_POST['action'];

if ($action === 'publicar') {
    $sql = "UPDATE Comentaris SET estat = 'publicat' WHERE id = ?";
} elseif ($action === 'eliminar') {
    $sql = "DELETE FROM Comentaris WHERE id = ?";
}

$stmt = $pdo->prepare($sql);
$stmt->execute([$comentari_id]);

header('Location: admin_panel.php');
exit;
?>
