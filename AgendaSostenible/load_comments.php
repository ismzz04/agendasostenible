<?php
require 'db_connection.php';

$esdeveniment_id = $_GET['esdeveniment_id'] ?? null;

if ($esdeveniment_id) {
    $sql = "SELECT Comentaris.*, Usuaris.nom_usuari FROM Comentaris
            JOIN Usuaris ON Comentaris.usuari_id = Usuaris.id
            WHERE esdeveniment_id = ? AND estat = 'publicat'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$esdeveniment_id]);
    $comentaris = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($comentaris as $comentari) {
        echo "<div class='comentari'>
                <p><strong>" . htmlspecialchars($comentari['nom_usuari']) . ":</strong> " . htmlspecialchars($comentari['comentari']) . "</p>
              </div>";
    }
} else {
    echo "No hi ha comentaris disponibles.";
}
?>
