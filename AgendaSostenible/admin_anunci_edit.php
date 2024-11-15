<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "Anunci no trobat.";
    exit();
}

// Obtener las categorías para el campo de selección
$sql = "SELECT * FROM Categories";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener los datos del anuncio
$sql = "SELECT * FROM Anuncis WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$anunci = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$anunci) {
    echo "Anunci no trobat.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titol = $_POST['titol'];
    $descripcio = $_POST['descripcio'];
    $imatges = $_POST['imatges'];
    $categoria_id = $_POST['categoria_id'];
    $estat = $_POST['estat'];

    $sql = "UPDATE Anuncis SET titol = ?, descripcio = ?, imatges = ?, categoria_id = ?, estat = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titol, $descripcio, $imatges, $categoria_id, $estat, $id]);

    header("Location: admin_anunci_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Editar Anunci</title>
</head>
<body>
    <h1>Editar Anunci Classificat</h1>
    <form action="admin_anunci_edit.php?id=<?php echo $anunci['id']; ?>" method="POST">
        <label>Títol:</label>
        <input type="text" name="titol" value="<?php echo htmlspecialchars($anunci['titol']); ?>" required>

        <label>Descripció:</label>
        <textarea name="descripcio" required><?php echo htmlspecialchars($anunci['descripcio']); ?></textarea>

        <label>Imatges (URL o nom d'arxiu, separades per comes):</label>
        <input type="text" name="imatges" value="<?php echo htmlspecialchars($anunci['imatges']); ?>">

        <label>Categoria:</label>
        <select name="categoria_id" required>
            <?php foreach ($categories as $categoria): ?>
                <option value="<?php echo $categoria['id']; ?>" <?php echo $categoria['id'] == $anunci['categoria_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($categoria['nom_categoria']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Estat:</label>
        <select name="estat" required>
            <option value="esborrany" <?php echo $anunci['estat'] == 'esborrany' ? 'selected' : ''; ?>>Esborrany</option>
            <option value="public" <?php echo $anunci['estat'] == 'public' ? 'selected' : ''; ?>>Públic</option>
            <option value="caducat" <?php echo $anunci['estat'] == 'caducat' ? 'selected' : ''; ?>>Caducat</option>
            <option value="esborrat" <?php echo $anunci['estat'] == 'esborrat' ? 'selected' : ''; ?>>Esborrat</option>
        </select>

        <button type="submit">Actualitzar Anunci</button>
    </form>
</body>
</html>
