<?php
require 'db_connection.php';
require_once 'Parsedown.php';

$parsedown = new Parsedown();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titol = $_POST['titol'];
    $descripcio = $_POST['descripcio'];
    $imatges = $_POST['imatges'];
    $categoria_id = $_POST['categoria_id'];
    $estat = $_POST['estat'];

    $sql = "INSERT INTO Anuncis (titol, descripcio, imatges, categoria_id, estat)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titol, $descripcio, $imatges, $categoria_id, $estat]);
}

$sql = "SELECT Anuncis.*, Categories.nom_categoria FROM Anuncis
        JOIN Categories ON Anuncis.categoria_id = Categories.id
        WHERE Anuncis.estat != 'esborrat'
        ORDER BY Anuncis.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$anuncis = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Anuncis Classificats</title>
    <link rel="stylesheet" href="estils.css">
</head>
<body class="anuncis">
    <header>
        <h1>Anuncis Classificats</h1>
    </header>
    <section>
        <h2>Llistat d'Anuncis</h2>
        <div id="anuncis-container">
            <?php foreach ($anuncis as $anunci): ?>
                <div class="card">
                    <h3><?php echo htmlspecialchars($anunci['titol']); ?></h3>
                    <p><strong>Descripció:</strong> <?php echo $parsedown->text($anunci['descripcio']); ?></p>
                    <p><strong>Categoria:</strong> <?php echo htmlspecialchars($anunci['nom_categoria']); ?></p>
                    <p><strong>Estat:</strong> <?php echo htmlspecialchars($anunci['estat']); ?></p>
                    <?php if (!empty($anunci['imatges'])): ?>
                        <p><strong>Imatges:</strong></p>
                        <div class="imatges">
                            <?php
                            // Gestionar múltiples imatges separades per comes
                            $imatges = explode(',', $anunci['imatges']);
                            foreach ($imatges as $imatge):
                                $imatge = trim($imatge); // Eliminar espais innecessaris
                                if (!empty($imatge)): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($imatge); ?>" alt="Imatge de l'anunci" style="width: 100%; max-height: 150px; object-fit: cover; margin-bottom: 10px;">
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p><strong>Imatges:</strong> No hi ha imatges disponibles.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</body>
</html>
