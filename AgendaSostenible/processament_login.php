<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'agendasostenible');

// Comprobar conexión
if ($conn->connect_error) {
    die("Error de connexió: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escapar los inputs
    $nom_usuari = $conn->real_escape_string($_POST['nom_usuari']);
    $contrasenya = $conn->real_escape_string($_POST['contrasenya']);

    // Comprobar si el usuario existe
    $sql = "SELECT * FROM usuaris WHERE nom_usuari='$nom_usuari' OR email='$nom_usuari'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Comprobar la contraseña directamente sin encriptación
        if ($contrasenya === $user['contrasenya']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['rol']; // Guardamos el rol en la sesión
            header("Location: agendasostenible.php"); // Redirige a la página principal
            exit();
        } else {
            echo "Contrasenya incorrecta.";
        }
    } else {
        echo "Usuari no trobat.";
    }
}

$conn->close();
?>
