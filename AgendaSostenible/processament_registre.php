<?php
// Connexió a la base de dades
$conn = new mysqli('localhost', 'root', '', 'agendasostenible');

// Comprovar si la connexió és correcta
if ($conn->connect_error) {
    die("Error de connexió: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escapar els inputs
    $nom = $conn->real_escape_string($_POST['nom']);
    $cognoms = $conn->real_escape_string($_POST['cognoms']);
    $nom_usuari = $conn->real_escape_string($_POST['nom_usuari']);
    $email = $conn->real_escape_string($_POST['email']);
    $contrasenya = $conn->real_escape_string($_POST['contrasenya']); // No encriptada

    // Assignar el rol per defecte
    $rol = 'usuari';

    // Comprovar si el nom d'usuari o email ja existeixen
    $sql = "SELECT * FROM usuaris WHERE nom_usuari='$nom_usuari' OR email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "El nom d'usuari o email ja estan registrats.";
    } else {
        // Gestionar la càrrega de la imatge de perfil
        $imatge = "";
        if (isset($_FILES['imatge_perfil']) && $_FILES['imatge_perfil']['error'] === 0) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["imatge_perfil"]["name"]);
            
            // Moure l'arxiu
            if (move_uploaded_file($_FILES["imatge_perfil"]["tmp_name"], $target_file)) {
                $imatge = basename($_FILES["imatge_perfil"]["name"]);
            } else {
                echo "Error al carregar la imatge de perfil.";
                exit();
            }
        } else {
            echo "No s'ha seleccionat cap imatge de perfil.";
            exit();
        }

        // Inserir a la base de dades, incloent el camp rol
        $sql = "INSERT INTO usuaris (nom, cognoms, nom_usuari, email, contrasenya, imatge_perfil, rol)
                VALUES ('$nom', '$cognoms', '$nom_usuari', '$email', '$contrasenya', '$imatge', '$rol')";

        if ($conn->query($sql) === TRUE) {
            // Redirigeix al login després del registre
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
