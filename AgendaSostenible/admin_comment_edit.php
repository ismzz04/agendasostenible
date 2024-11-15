<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$comment_id = $_GET['id'] ?? null;

if (!$comment_id) {
    echo "Comentari no trobat.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comentari = $_POST['comentari'];
    $sql = "UPDATE Comentaris SET comentari = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$comentari, $comment_id]);

    header("Location: admin_comment_list.php");
    exit();
}

// Obtener el comentario actual
$sql = "SELECT * FROM Comentaris WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$comment_id]);
$comentari = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comentari) {
    echo "Comentari no trobat.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Editar Comentari</title>
</head>
<body>
    <h1>Editar Comentari</h1>
    <form action="admin_comment_edit.php?id=<?php echo $comentari['id']; ?>" method="POST">
        <label for="comentari">Comentari:</label>
        <textarea id="comentari" name="comentari" required><?php echo htmlspecialchars($comentari['comentari']); ?></textarea>
        
        <button type="submit">Actualitzar Comentari</button>
    </form>
</body>
</html>
