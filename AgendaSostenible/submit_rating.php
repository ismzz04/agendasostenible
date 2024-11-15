<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'No autoritzat']);
    exit();
}

$user_id = $_SESSION['user_id'];
$esdeveniment_id = $_POST['esdeveniment_id'] ?? null;
$valoracio = $_POST['valoracio'] ?? null;

if ($esdeveniment_id && $valoracio) {
    // Comprovar si ja existeix una valoració
    $sql = "SELECT id FROM Valoracions WHERE usuari_id = ? AND esdeveniment_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $esdeveniment_id]);

    if ($stmt->rowCount() > 0) {
        // Actualitzar la valoració existent
        $sql = "UPDATE Valoracions SET valoracio = ? WHERE usuari_id = ? AND esdeveniment_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$valoracio, $user_id, $esdeveniment_id]);
    } else {
        // Inserir una nova valoració
        $sql = "INSERT INTO Valoracions (usuari_id, esdeveniment_id, valoracio) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $esdeveniment_id, $valoracio]);
    }

    // Calcular la nova mitjana de valoracions
    $sql = "SELECT AVG(valoracio) AS valoracio_mitjana FROM Valoracions WHERE esdeveniment_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$esdeveniment_id]);
    $valoracio_mitjana = $stmt->fetchColumn();

    // Actualitzar la mitjana a la taula Esdeveniments
    $sql = "UPDATE Esdeveniments SET valoracio = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$valoracio_mitjana, $esdeveniment_id]);

    echo json_encode(['valoracio_mitjana' => number_format($valoracio_mitjana, 1)]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Dades incompletes']);
}
?>
