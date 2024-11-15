<?php
require 'db_connection.php';

// Inserir un nou comentari si el formulari ha estat enviat
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuari_id = $_POST['usuari_id'];
    $esdeveniment_id = $_POST['esdeveniment_id'];
    $comentari = $_POST['comentari'];
    $estat = 'pendent';  // Els comentaris nous comencen amb l'estat 'pendent'

    $sql = "INSERT INTO Comentaris (usuari_id, esdeveniment_id, comentari, estat)
            VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuari_id, $esdeveniment_id, $comentari, $estat]);
}

// Obtenir tots els comentaris associats a un esdeveniment específic
$esdeveniment_id = $_GET['esdeveniment_id'];
$sql = "SELECT Comentaris.*, Usuaris.nom_usuari FROM Comentaris
        JOIN Usuaris ON Comentaris.usuari_id = Usuaris.id
        WHERE esdeveniment_id = ? AND estat = 'publicat'";
$stmt = $pdo->prepare($sql);
$stmt->execute([$esdeveniment_id]);
$comentaris = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Comentaris</title>
</head>
<body>
    <h2>Comentaris per a l'Esdeveniment</h2>
    <?php foreach ($comentaris as $comentari): ?>
        <div class="comentari">
            <p><strong><?php echo $comentari['nom_usuari']; ?>:</strong> <?php echo $comentari['comentari']; ?></p>
        </div>
    <?php endforeach; ?>

    <h3>Afegeix un Comentari</h3>
    <form action="comentaris.php?esdeveniment_id=<?php echo $esdeveniment_id; ?>" method="post">
        <input type="hidden" name="usuari_id" value="<?php echo $_SESSION['usuari_id']; ?>">
        <input type="hidden" name="esdeveniment_id" value="<?php echo $esdeveniment_id; ?>">
        <textarea name="comentari" required></textarea>
        <button type="submit">Enviar Comentari</button>
    </form>
</body>
</html>
