<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $anunci_id = $_POST['anunci_id'];
    $sql = "UPDATE Anuncis SET estat = 'esborrat' WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$anunci_id]);
}

header("Location: anuncis.php");
exit();
?>
