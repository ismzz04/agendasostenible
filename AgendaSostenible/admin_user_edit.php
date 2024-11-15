<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

$user_id = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $user_id) {
    $nom = $_POST['nom'];
    $cognoms = $_POST['cognoms'];
    $nom_usuari = $_POST['nom_usuari'];
    $email = $_POST['email'];
    $rol = $_POST['rol'];
    $imatge_perfil = $_POST['imatge_actual'] ?? ''; // Mantener imagen actual si no se cambia

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

    $sql = "UPDATE usuaris SET nom = ?, cognoms = ?, nom_usuari = ?, email = ?, rol = ?, imatge_perfil = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $cognoms, $nom_usuari, $email, $rol, $imatge_perfil, $user_id]);

    header("Location: admin_user_list.php");
    exit();
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
    <title>Editar Usuari</title>
</head>
<body>
    <h1>Editar Usuari</h1>
    <?php if ($user): ?>
        <form action="admin_user_edit.php?id=<?php echo $user['id']; ?>" method="POST" enctype="multipart/form-data">
            <label>Nom:</label>
            <input type="text" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>

            <label>Cognoms:</label>
            <input type="text" name="cognoms" value="<?php echo htmlspecialchars($user['cognoms']); ?>" required>

            <label>Nom d'Usuari:</label>
            <input type="text" name="nom_usuari" value="<?php echo htmlspecialchars($user['nom_usuari']); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label>Rol:</label>
            <select name="rol" required>
                <option value="usuari" <?php echo ($user['rol'] == 'usuari') ? 'selected' : ''; ?>>Usuari</option>
                <option value="admin" <?php echo ($user['rol'] == 'admin') ? 'selected' : ''; ?>>Administrador</option>
            </select>

            <label>Imatge de Perfil:</label>
            <input type="file" name="imatge_perfil" accept="image/*">
            <input type="hidden" name="imatge_actual" value="<?php echo htmlspecialchars($user['imatge_perfil']); ?>">
            <?php if ($user['imatge_perfil']): ?>
                <img src="uploads/<?php echo htmlspecialchars($user['imatge_perfil']); ?>" alt="Imatge de perfil actual" width="100">
            <?php endif; ?>

            <button type="submit">Actualitzar Usuari</button>
        </form>
    <?php else: ?>
        <p>Usuari no trobat.</p>
    <?php endif; ?>
</body>
</html>
