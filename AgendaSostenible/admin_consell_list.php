<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$sql = "SELECT * FROM Consells_Sostenibilitat ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$consells = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestió de Consells</title>
</head>
<body>
    <h1>Gestió de Consells</h1>
    <table>
        <tr>
            <th>Títol</th>
            <th>Accions</th>
        </tr>
        <?php foreach ($consells as $consell): ?>
            <tr>
                <td><?php echo htmlspecialchars($consell['titol']); ?></td>
                <td>
                    <a href="admin_consell_edit.php?id=<?php echo $consell['id']; ?>">Editar</a>
                    <a href="admin_consell_delete.php?id=<?php echo $consell['id']; ?>" onclick="return confirm('Estàs segur de voler eliminar aquest consell?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
