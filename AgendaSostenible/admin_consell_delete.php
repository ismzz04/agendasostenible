<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$id = $_GET['id'] ?? null;
if ($id) {
    $sql = "DELETE FROM Consells_Sostenibilitat WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

header("Location: admin_consell_list.php");
exit();
?>
