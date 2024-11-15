<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$comment_id = $_GET['id'] ?? null;

if ($comment_id) {
    $sql = "DELETE FROM Comentaris WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$comment_id]);
}

header("Location: admin_comment_list.php");
exit();
?>
