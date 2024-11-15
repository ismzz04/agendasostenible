<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$sql = "SELECT * FROM Esdeveniments ORDER BY data DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Llista d'Esdeveniments</title>
</head>
<body>
    <h1>Llista d'Esdeveniments</h1>
    <table>
        <tr>
            <th>Títol</th>
            <th>Tipus</th>
            <th>Data</th>
            <th>Visualitzacions</th>
            <th>Accions</th>
        </tr>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?php echo htmlspecialchars($event['titol']); ?></td>
                <td><?php echo htmlspecialchars($event['tipus']); ?></td>
                <td><?php echo htmlspecialchars($event['data']); ?></td>
                <td><?php echo htmlspecialchars($event['visualitzacions']); ?></td>
                <td>
                    <a href="admin_event_edit.php?id=<?php echo $event['id']; ?>">Editar</a>
                    <a href="admin_event_delete.php?id=<?php echo $event['id']; ?>" onclick="return confirm('Estàs segur de voler eliminar aquest esdeveniment?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
