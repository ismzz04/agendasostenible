<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$sql = "SELECT Anuncis.*, Categories.nom_categoria FROM Anuncis JOIN Categories ON Anuncis.categoria_id = Categories.id ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$anuncis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestió d'Anuncis</title>
</head>
<body>
    <h1>Gestió d'Anuncis</h1>
    <table>
        <tr>
            <th>Títol</th>
            <th>Categoria</th>
            <th>Accions</th>
        </tr>
        <?php foreach ($anuncis as $anunci): ?>
            <tr>
                <td><?php echo htmlspecialchars($anunci['titol']); ?></td>
                <td><?php echo htmlspecialchars($anunci['nom_categoria']); ?></td>
                <td>
                    <a href="admin_anunci_edit.php?id=<?php echo $anunci['id']; ?>">Editar</a>
                    <a href="admin_anunci_delete.php?id=<?php echo $anunci['id']; ?>" onclick="return confirm('Estàs segur de voler eliminar aquest anunci?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
