<?php
session_start();
if ($_SESSION['user_role'] !== 'admin') {
    header("Location: agendasostenible.php");
    exit();
}

require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_categoria = $_POST['nom_categoria'];
    $sql = "INSERT INTO Categories (nom_categoria) VALUES (?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom_categoria]);
}

if (isset($_GET['delete'])) {
    $categoria_id = $_GET['delete'];
    $sql = "DELETE FROM Categories WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$categoria_id]);
}

$sql = "SELECT * FROM Categories";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Categories</title>
    <link rel="stylesheet" href="estils.css">
</head>
<body>
    <h2>Afegir Nova Categoria</h2>
    <form action="admin_categories.php" method="POST">
        <label>Nom de la Categoria:</label>
        <input type="text" name="nom_categoria" required>
        <button type="submit">Afegir Categoria</button>
    </form>

    <h2>Llistat de Categories</h2>
    <ul>
        <?php foreach ($categories as $categoria): ?>
            <li><?php echo htmlspecialchars($categoria['nom_categoria']); ?> 
                <a href="admin_category_edit.php?id=<?php echo $categoria['id']; ?>">Editar</a> |
                <a href="admin_categories.php?delete=<?php echo $categoria['id']; ?>" onclick="return confirm('Estàs segur de voler eliminar aquesta categoria?');">Esborrar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
