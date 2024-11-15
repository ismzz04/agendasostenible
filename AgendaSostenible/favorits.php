<?php
session_start();
require 'db_connection.php';

// Verificar si l'usuari ha iniciat sessió
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Manejar sol·licitud POST per afegir favorits
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];

    // Comprovar si ja existeix el favorit
    $sql_check = "SELECT * FROM Favorits WHERE usuari_id = ? AND esdeveniment_id = ?";
    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([$user_id, $event_id]);

    if ($stmt_check->rowCount() > 0) {
        echo "Aquest esdeveniment ja està als teus favorits.";
    } else {
        // Afegir als favorits
        $sql_insert = "INSERT INTO Favorits (usuari_id, esdeveniment_id) VALUES (?, ?)";
        $stmt_insert = $pdo->prepare($sql_insert);
        if ($stmt_insert->execute([$user_id, $event_id])) {
            echo "Esdeveniment afegit als teus favorits!";
        } else {
            echo "Hi ha hagut un error en afegir l'esdeveniment als favorits.";
        }
    }
    exit(); // Finalitzar l'execució per evitar carregar la pàgina completa durant una sol·licitud AJAX
}

// Obtenir esdeveniments favorits
$sql_favorits = "
    SELECT e.*
    FROM Favorits f
    JOIN Esdeveniments e ON f.esdeveniment_id = e.id
    WHERE f.usuari_id = ?
    ORDER BY e.data DESC
";
$stmt_favorits = $pdo->prepare($sql_favorits);
$stmt_favorits->execute([$user_id]);
$favorits = $stmt_favorits->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Favorits</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2 class="text-success">Els meus favorits</h2>
    <?php if (!empty($favorits)): ?>
        <div class="row">
            <?php foreach ($favorits as $favorit): ?>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($favorit['titol']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($favorit['descripcio']); ?></p>
                            <p class="card-text"><strong>Data:</strong> <?php echo htmlspecialchars($favorit['data']); ?></p>
                            <p class="card-text"><strong>Tipus:</strong> <?php echo htmlspecialchars($favorit['tipus']); ?></p>
                            <?php if ($favorit['imatge']): ?>
                                <img src="uploads/<?php echo htmlspecialchars($favorit['imatge']); ?>" alt="Imatge de l'esdeveniment" class="img-fluid">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No tens esdeveniments favorits encara.</p>
    <?php endif; ?>
</div>
</body>
</html>
