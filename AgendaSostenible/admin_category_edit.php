<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: agendasostenible.php");
    exit();
}

$categoria_id = $_GET['id'] ?? null;

if (!$categoria_id) {
    echo "Categoria no trobada.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_categoria = $_POST['nom_categoria'];
    $sql = "UPDATE Categories SET nom_categoria = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom_categoria, $categoria_id]);

    header("Location: admin_categories.php");
    exit();
}

$sql = "SELECT * FROM Categories WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$categoria_id]);
$categoria = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$categoria) {
    echo "Categoria no trobada.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Editar Categoria</title>
    <link rel="stylesheet" href="estils.css">
</head>
<body>
    <h1>Editar Categoria</h1>
    <form action="admin_category_edit.php?id=<?php echo $categoria['id']; ?>" method="POST">
        <label>Nom de la Categoria:</label>
        <input type="text" name="nom_categoria" value="<?php echo htmlspecialchars($categoria['nom_categoria']); ?>" required>
        <button type="submit">Actualitzar Categoria</button>
    </form>
</body>
</html>
