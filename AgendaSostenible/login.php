<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inici de Sessió</title>
    <link rel="stylesheet" href="estils.css">
</head>
<body>
    <div class="container">
        <h2>Inici de Sessió</h2>
        <form action="processament_login.php" method="POST">
            <label>Nom d'Usuari o Email:</label>
            <input type="text" name="nom_usuari" required>
            
            <label>Contrasenya:</label>
            <input type="password" name="contrasenya" required>

            <button type="submit">Iniciar Sessió</button>
        </form>
        <div class="redirect">
            Encara no tens compte? <a href="registre.php">Click aquí per registrar-te</a>
        </div>
    </div>
</body>
</html>
