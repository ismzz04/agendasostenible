<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

// Obtener las categorías para el campo de selección
$sql = "SELECT * FROM Categories";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titol = $_POST['titol'];
    $descripcio = $_POST['descripcio'];
    $imatges = $_POST['imatges'];
    $categoria_id = $_POST['categoria_id'];
    $estat = $_POST['estat'];

    $sql = "INSERT INTO Anuncis (titol, descripcio, imatges, categoria_id, estat) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titol, $descripcio, $imatges, $categoria_id, $estat]);

    header("Location: admin_anunci_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Crear Anunci Classificat</title>
</head>
<body>
    <h1>Crear un Nou Anunci Classificat</h1>
    <form action="admin_anunci_create.php" method="POST">
        <label>Títol:</label>
        <input type="text" name="titol" required>

        <label>Descripció:</label>
        <textarea name="descripcio" required></textarea>

        <label>Imatges (URL o nom d'arxiu, separades per comes):</label>
        <input type="text" name="imatges">

        <label>Categoria:</label>
        <select name="categoria_id" required>
            <?php foreach ($categories as $categoria): ?>
                <option value="<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['nom_categoria']); ?></option>
            <?php endforeach; ?>
        </select>

        <label>Estat:</label>
        <select name="estat" required>
            <option value="esborrany">Esborrany</option>
            <option value="public">Públic</option>
            <option value="caducat">Caducat</option>
            <option value="esborrat">Esborrat</option>
        </select>

        <button type="submit">Crear Anunci</button>
    </form>
</body>
</html>
