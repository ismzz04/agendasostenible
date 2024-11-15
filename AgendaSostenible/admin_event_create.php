<?php
session_start();
if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit;
}
require 'db_connection.php';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titol = $_POST['titol'];
    $descripcio = $_POST['descripcio'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $tipus = $_POST['tipus'];
    $valoracio = 0;  // Se inicia en 0
    $visualitzacions = 0;

    // Procesar la imagen si existe
    $imatge = '';
    if (isset($_FILES['imatge']) && $_FILES['imatge']['error'] === 0) {
        $imatge = 'uploads/' . basename($_FILES['imatge']['name']);
        move_uploaded_file($_FILES['imatge']['tmp_name'], $imatge);
    }

    // Insertar evento
    $sql = "INSERT INTO Esdeveniments (titol, descripcio, data, hora, latitud, longitud, tipus, imatge, valoracio, visualitzacions)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titol, $descripcio, $data, $hora, $latitud, $longitud, $tipus, $imatge, $valoracio, $visualitzacions]);

    header('Location: admin_event_list.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Crear Esdeveniment</title>
</head>
<body>
    <h2>Crear Nou Esdeveniment</h2>
    <form action="admin_event_create.php" method="post" enctype="multipart/form-data">
        <label for="titol">Títol:</label>
        <input type="text" id="titol" name="titol" required>

        <label for="descripcio">Descripció:</label>
        <textarea id="descripcio" name="descripcio" required></textarea>

        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required>

        <label for="hora">Hora:</label>
        <input type="time" id="hora" name="hora" required>

        <label for="latitud">Latitud:</label>
        <input type="text" id="latitud" name="latitud" required>

        <label for="longitud">Longitud:</label>
        <input type="text" id="longitud" name="longitud" required>

        <label for="tipus">Tipus d’esdeveniment:</label>
        <select id="tipus" name="tipus" required>
            <option value="Interior">Interior</option>
            <option value="Aire lliure">Aire lliure</option>
            <option value="Xerrada">Xerrada</option>
            <option value="Jornada">Jornada</option>
        </select>

        <label for="imatge">Imatge:</label>
        <input type="file" id="imatge" name="imatge">

        <button type="submit">Crear Esdeveniment</button>
    </form>
</body>
</html>
