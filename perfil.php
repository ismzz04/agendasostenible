<?php
session_start();
require 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $cognoms = $_POST['cognoms'];
    $nom_usuari = $_POST['nom_usuari'];
    $email = $_POST['email'];
    $imatge_perfil = $user['imatge_perfil']; // Mantener la imagen actual si no se cambia

    // Procesar la nueva imagen si se sube una
    if (isset($_FILES['imatge_perfil']) && $_FILES['imatge_perfil']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["imatge_perfil"]["name"]);
        
        if (move_uploaded_file($_FILES["imatge_perfil"]["tmp_name"], $target_file)) {
            $imatge_perfil = basename($_FILES["imatge_perfil"]["name"]); // Actualizar con el nombre de la nueva imagen
        } else {
            echo "Error al carregar la imatge de perfil.";
        }
    }

    $sql = "UPDATE usuaris SET nom = ?, cognoms = ?, nom_usuari = ?, email = ?, imatge_perfil = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $cognoms, $nom_usuari, $email, $imatge_perfil, $user_id]);

    echo "Les teves dades s'han actualitzat correctament.";
}

$sql = "SELECT * FROM usuaris WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Perfil d'Usuari</title>
    <link rel="stylesheet" href="estils.css">
</head>
<body>
    <h2>Editar Perfil</h2>
    <form action="perfil.php" method="POST" enctype="multipart/form-data">
        <label>Nom:</label>
        <input type="text" name="nom" value="<?php echo $user['nom']; ?>" required>

        <label>Cognoms:</label>
        <input type="text" name="cognoms" value="<?php echo $user['cognoms']; ?>" required>

        <label>Nom d'Usuari:</label>
        <input type="text" name="nom_usuari" value="<?php echo $user['nom_usuari']; ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>

        <label>Imatge de Perfil:</label>
        <input type="file" name="imatge_perfil" accept="image/*">
        <?php if ($user['imatge_perfil']): ?>
            <img src="uploads/<?php echo htmlspecialchars($user['imatge_perfil']); ?>" alt="Imatge de perfil actual" width="100">
        <?php endif; ?>

        <button type="submit">Actualitzar</button>
    </form>
</body>
</html>
