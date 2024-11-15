<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$id = $_GET['id'] ?? null;

if ($id) {
    // Obtener el nombre del archivo de imagen antes de eliminar el evento
    $sql = "SELECT imatge FROM Esdeveniments WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event && !empty($event['imatge'])) {
        $image_path = "uploads/" . $event['imatge'];
        if (file_exists($image_path)) {
            unlink($image_path); // Eliminar la imagen del servidor
        }
    }

    // Eliminar el evento de la base de datos
    $sql = "DELETE FROM Esdeveniments WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

header("Location: admin_event_list.php");
exit();
?>
