<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

// Obtenim comentaris pendents i publicats
$sql_pendents = "SELECT Comentaris.*, Usuaris.nom_usuari, Esdeveniments.titol AS event_titol 
                 FROM Comentaris 
                 JOIN Usuaris ON Comentaris.usuari_id = Usuaris.id
                 JOIN Esdeveniments ON Comentaris.esdeveniment_id = Esdeveniments.id
                 WHERE estat = 'pendent'";
$stmt_pendents = $pdo->prepare($sql_pendents);
$stmt_pendents->execute();
$comentaris_pendents = $stmt_pendents->fetchAll(PDO::FETCH_ASSOC);

$sql_publicats = "SELECT Comentaris.*, Usuaris.nom_usuari, Esdeveniments.titol AS event_titol 
                  FROM Comentaris 
                  JOIN Usuaris ON Comentaris.usuari_id = Usuaris.id
                  JOIN Esdeveniments ON Comentaris.esdeveniment_id = Esdeveniments.id
                  WHERE estat = 'publicat'";
$stmt_publicats = $pdo->prepare($sql_publicats);
$stmt_publicats->execute();
$comentaris_publicats = $stmt_publicats->fetchAll(PDO::FETCH_ASSOC);

// Gestionar accions d'aprovació o eliminació
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['comentari_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if ($comment_id) {
        if ($action === 'publicar') {
            $sql = "UPDATE Comentaris SET estat = 'publicat' WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$comment_id]);
        } elseif ($action === 'eliminar') {
            $sql = "DELETE FROM Comentaris WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$comment_id]);
        }
        // Refrescar la pàgina
        header("Location: admin_comment_list.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestió de Comentaris</title>
</head>
<body>
    <h1>Gestió de Comentaris</h1>

    <!-- Comentaris Pendents -->
    <h2>Comentaris Pendents</h2>
    <table>
        <tr>
            <th>Usuari</th>
            <th>Esdeveniment</th>
            <th>Comentari</th>
            <th>Accions</th>
        </tr>
        <?php foreach ($comentaris_pendents as $comentari): ?>
            <tr>
                <td><?php echo htmlspecialchars($comentari['nom_usuari']); ?></td>
                <td><?php echo htmlspecialchars($comentari['event_titol']); ?></td>
                <td><?php echo htmlspecialchars($comentari['comentari']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="comentari_id" value="<?php echo $comentari['id']; ?>">
                        <button type="submit" name="action" value="publicar">Aprovar</button>
                    </form>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="comentari_id" value="<?php echo $comentari['id']; ?>">
                        <button type="submit" name="action" value="eliminar">Eliminar</button>
                    </form>
                    <a href="admin_comment_edit.php?id=<?php echo $comentari['id']; ?>">Editar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Comentaris Publicats -->
    <h2>Comentaris Publicats</h2>
    <table>
        <tr>
            <th>Usuari</th>
            <th>Esdeveniment</th>
            <th>Comentari</th>
            <th>Accions</th>
        </tr>
        <?php foreach ($comentaris_publicats as $comentari): ?>
            <tr>
                <td><?php echo htmlspecialchars($comentari['nom_usuari']); ?></td>
                <td><?php echo htmlspecialchars($comentari['event_titol']); ?></td>
                <td><?php echo htmlspecialchars($comentari['comentari']); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="comentari_id" value="<?php echo $comentari['id']; ?>">
                        <button type="submit" name="action" value="eliminar">Eliminar</button>
                    </form>
                    <a href="admin_comment_edit.php?id=<?php echo $comentari['id']; ?>">Editar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
