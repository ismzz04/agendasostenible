<?php
session_start();
require 'db_connection.php';

if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $cognoms = $_POST['cognoms'];
    $nom_usuari = $_POST['nom_usuari'];
    $email = $_POST['email'];
    $contrasenya = password_hash($_POST['contrasenya'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];
    $imatge_perfil = null;

    // Procesar la imagen de perfil si se sube una
    if (isset($_FILES['imatge_perfil']) && $_FILES['imatge_perfil']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["imatge_perfil"]["name"]);

        if (move_uploaded_file($_FILES["imatge_perfil"]["tmp_name"], $target_file)) {
            $imatge_perfil = basename($_FILES["imatge_perfil"]["name"]); // Guardar el nombre de la imagen en la base de datos
        } else {
            echo "Error al carregar la imatge de perfil.";
        }
    }

    $sql = "INSERT INTO usuaris (nom, cognoms, nom_usuari, email, contrasenya, rol, imatge_perfil) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $cognoms, $nom_usuari, $email, $contrasenya, $rol, $imatge_perfil]);

    header("Location: admin_user_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuari</title>
</head>
<body>
    
    <h1>Crear un Nou Usuari</h1>
    <form action="admin_usuarios.php" method="POST" enctype="multipart/form-data">
        <label>Nom:</label>
        <input type="text" name="nom" required>

        <label>Cognoms:</label>
        <input type="text" name="cognoms" required>

        <label>Nom d'Usuari:</label>
        <input type="text" name="nom_usuari" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Contrasenya:</label>
        <input type="password" name="contrasenya" required>

        <label>Rol:</label>
        <select name="rol" required>
            <option value="usuari">Usuari</option>
            <option value="admin">Administrador</option>
        </select>

        <label>Imatge de Perfil:</label>
        <input type="file" name="imatge_perfil" accept="image/*">

        <button type="submit">Crear Usuari</button>
    </form>
</body>
</html>
