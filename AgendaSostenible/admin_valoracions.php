<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header("Location: agendasostenible.php");
    exit();
}

// Obtener todas las valoraciones
$sql = "SELECT v.id, v.valoracio, u.nom_usuari, e.titol 
        FROM Valoracions v 
        JOIN usuaris u ON v.usuari_id = u.id 
        JOIN Esdeveniments e ON v.esdeveniment_id = e.id";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$valoracions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Manejo de eliminación de valoración
if (isset($_GET['delete'])) {
    $valoracio_id = $_GET['delete'];
    $sql = "DELETE FROM Valoracions WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$valoracio_id]);
    header("Location: admin_valoracions.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Administrar Valoracions</title>
    <link rel="stylesheet" href="estils.css">
</head>
<body>
    <h1>Administrar Valoracions</h1>
    <table>
        <thead>
            <tr>
                <th>Usuari</th>
                <th>Esdeveniment</th>
                <th>Valoració</th>
                <th>Accions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($valoracions as $valoracio): ?>
                <tr>
                    <td><?php echo htmlspecialchars($valoracio['nom_usuari']); ?></td>
                    <td><?php echo htmlspecialchars($valoracio['titol']); ?></td>
                    <td><?php echo htmlspecialchars($valoracio['valoracio']); ?> ★</td>
                    <td>
                        <a href="admin_valoracions.php?delete=<?php echo $valoracio['id']; ?>" onclick="return confirm('Estàs segur de voler eliminar aquesta valoració?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
