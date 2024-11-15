<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "DELETE FROM Anuncis WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

header("Location: admin_anunci_list.php");
exit();
?>
