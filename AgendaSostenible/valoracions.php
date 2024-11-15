<?php
session_start();
require 'db_connection.php';

$esdeveniment_id = $_GET['esdeveniment_id'] ?? null;

if (!$esdeveniment_id) {
    die('Esdeveniment no especificat.');
}

// Verificar si el usuario está registrado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Manejo del envío del formulario de valoración
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valoracio = $_POST['valoracio'];

    // Verificar si el usuario ya ha valorado este evento
    $sql = "SELECT id FROM Valoracions WHERE usuari_id = ? AND esdeveniment_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $esdeveniment_id]);

    if ($stmt->fetch()) {
        echo "Ja has valorat aquest esdeveniment.";
    } else {
        // Insertar nueva valoración
        $sql = "INSERT INTO Valoracions (usuari_id, esdeveniment_id, valoracio) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $esdeveniment_id, $valoracio]);
        echo "Gràcies per la teva valoració!";
    }
}

// Calcular la valoración media del evento
$sql = "SELECT AVG(valoracio) AS valoracio_mitjana FROM Valoracions WHERE esdeveniment_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$esdeveniment_id]);
$valoracio_mitjana = $stmt->fetchColumn();

// Obtener todas las valoraciones del evento para mostrarlas
$sql = "SELECT v.valoracio, u.nom_usuari 
        FROM Valoracions v 
        JOIN usuaris u ON v.usuari_id = u.id 
        WHERE v.esdeveniment_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$esdeveniment_id]);
$valoracions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Valoracions</title>
    <link rel="stylesheet" href="estils.css">
</head>
<body>
    <h2>Valoració Mitjana: <?php echo number_format($valoracio_mitjana, 1); ?> ★</h2>

    <h3>Valora aquest Esdeveniment</h3>
    <form action="valoracions.php?esdeveniment_id=<?php echo $esdeveniment_id; ?>" method="post">
        <label for="valoracio">Valoració (1-5):</label>
        <input type="number" name="valoracio" min="1" max="5" required>
        <button type="submit">Enviar Valoració</button>
    </form>

    <h3>Valoracions dels Usuaris</h3>
    <ul>
        <?php foreach ($valoracions as $valoracio): ?>
            <li><?php echo htmlspecialchars($valoracio['nom_usuari']); ?>: <?php echo htmlspecialchars($valoracio['valoracio']); ?> ★</li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
