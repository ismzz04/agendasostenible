<?php
require 'db_connection.php';
require_once 'Parsedown.php';

$parsedown = new Parsedown();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titol = $_POST['titol'];
    $descripcio_breu = $_POST['descripcio_breu'];
    $text_explicatiu = $_POST['text_explicatiu'];
    $etiquetes = $_POST['etiquetes'];

    $sql = "INSERT INTO Consells_Sostenibilitat (titol, descripcio_breu, text_explicatiu, etiquetes)
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titol, $descripcio_breu, $text_explicatiu, $etiquetes]);
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
    <title>Consells de Sostenibilitat</title>
    <link rel="stylesheet" href="estils.css">
</head>
<body class="consells">
    <header>
        <h1>Consells de Sostenibilitat</h1>
    </header>
        <section>
            <h2>Llistat de Consells</h2>
            <div id="consells-container">
                <?php foreach ($consells as $consell): ?>
                    <div class="card">
                        <h3><?php echo $consell['titol']; ?></h3>
                        <p><strong>Descripció Breu:</strong> <?php echo $consell['descripcio_breu']; ?></p>
                        <p><strong>Text Explicatiu:</strong> <?php echo $parsedown->text($consell['text_explicatiu']); ?></p>
                        <p><strong>Etiquetes:</strong> <?php echo $consell['etiquetes']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
</html>
