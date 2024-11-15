<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$sql = "SELECT * FROM usuaris ORDER BY nom";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestió d'Usuaris</title>
</head>
<body>
    <h1>Gestió d'Usuaris</h1>
    <table>
        <tr>
            <th>Nom d'Usuari</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Accions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['nom_usuari']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['rol']); ?></td>
                <td>
                    <a href="admin_user_edit.php?id=<?php echo $user['id']; ?>">Editar</a>
                    <a href="admin_user_delete.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Estàs segur de voler eliminar aquest usuari?');">Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
