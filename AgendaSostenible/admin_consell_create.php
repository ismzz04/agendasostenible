<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titol = $_POST['titol'];
    $descripcio_breu = $_POST['descripcio_breu'];
    $text_explicatiu = $_POST['text_explicatiu'];
    $etiquetes = $_POST['etiquetes'];

    $sql = "INSERT INTO Consells_Sostenibilitat (titol, descripcio_breu, text_explicatiu, etiquetes) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titol, $descripcio_breu, $text_explicatiu, $etiquetes]);

    header("Location: admin_consell_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Crear Consell</title>
</head>
<body>
    <h1>Crear un Nou Consell</h1>
    <form action="admin_consell_create.php" method="POST">
        <label>Títol:</label>
        <input type="text" name="titol" required>

        <label>Descripció Breu:</label>
        <textarea name="descripcio_breu" required></textarea>

        <label>Text Explicatiu:</label>
        <textarea name="text_explicatiu" required></textarea>

        <label>Etiquetes:</label>
        <input type="text" name="etiquetes" required>

        <button type="submit">Crear Consell</button>
    </form>
</body>
</html>
