<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$user_id = $_GET['id'] ?? null;

if ($user_id) {
    $sql = "DELETE FROM usuaris WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
}

header("Location: admin_user_list.php");
exit();
?>
