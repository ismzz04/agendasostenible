<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id) {
    $titol = $_POST['titol'];
    $descripcio = $_POST['descripcio'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $tipus = $_POST['tipus'];
    
    // Manejo de imagen
    if (isset($_FILES['imatge']) && $_FILES['imatge']['error'] === 0) {
        $imatge = 'uploads/' . basename($_FILES['imatge']['name']);
        move_uploaded_file($_FILES['imatge']['tmp_name'], $imatge);
        $sql = "UPDATE Esdeveniments SET titol = ?, descripcio = ?, data = ?, hora = ?, latitud = ?, longitud = ?, tipus = ?, imatge = ? WHERE id = ?";
        $params = [$titol, $descripcio, $data, $hora, $latitud, $longitud, $tipus, $imatge, $id];
    } else {
        $sql = "UPDATE Esdeveniments SET titol = ?, descripcio = ?, data = ?, hora = ?, latitud = ?, longitud = ?, tipus = ? WHERE id = ?";
        $params = [$titol, $descripcio, $data, $hora, $latitud, $longitud, $tipus, $id];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header("Location: admin_event_list.php");
    exit();
}

$sql = "SELECT * FROM Esdeveniments WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$event = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Editar Esdeveniment</title>
</head>
<body>
    <?php if ($event): ?>
        <h1>Editar Esdeveniment</h1>
        <form action="admin_event_edit.php?id=<?php echo $event['id']; ?>" method="post" enctype="multipart/form-data">
            <label>Títol:</label>
            <input type="text" name="titol" value="<?php echo htmlspecialchars($event['titol']); ?>" required>

            <label>Descripció:</label>
            <textarea name="descripcio" required><?php echo htmlspecialchars($event['descripcio']); ?></textarea>

            <label>Data:</label>
            <input type="date" name="data" value="<?php echo htmlspecialchars($event['data']); ?>" required>

            <label>Hora:</label>
            <input type="time" name="hora" value="<?php echo htmlspecialchars($event['hora']); ?>" required>

            <label>Latitud:</label>
            <input type="text" name="latitud" value="<?php echo htmlspecialchars($event['latitud']); ?>" required>

            <label>Longitud:</label>
            <input type="text" name="longitud" value="<?php echo htmlspecialchars($event['longitud']); ?>" required>

            <label>Tipus d’esdeveniment:</label>
            <select name="tipus" required>
                <option value="Interior" <?php echo ($event['tipus'] == 'Interior') ? 'selected' : ''; ?>>Interior</option>
                <option value="Aire lliure" <?php echo ($event['tipus'] == 'Aire lliure') ? 'selected' : ''; ?>>Aire lliure</option>
                <option value="Xerrada" <?php echo ($event['tipus'] == 'Xerrada') ? 'selected' : ''; ?>>Xerrada</option>
                <option value="Jornada" <?php echo ($event['tipus'] == 'Jornada') ? 'selected' : ''; ?>>Jornada</option>
            </select>

            <label>Imatge:</label>
            <input type="file" name="imatge">
            <?php if ($event['imatge']): ?>
                <img src="<?php echo htmlspecialchars($event['imatge']); ?>" alt="Imatge de l'esdeveniment" width="100">
            <?php endif; ?>

            <button type="submit">Actualitzar Esdeveniment</button>
        </form>
    <?php else: ?>
        <p>Esdeveniment no trobat.</p>
    <?php endif; ?>
</body>
</html>
