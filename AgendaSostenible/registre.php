<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre d'Usuari</title>
    <link rel="stylesheet" href="estils.css">
    <script src="validacio.js"></script>
</head>
<body>
    <div class="container">
        <h2>Registre d'Usuari</h2>
        <form action="processament_registre.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <label>Nom:</label>
            <input type="text" name="nom" required>
            
            <label>Cognoms:</label>
            <input type="text" name="cognoms" required>
            
            <label>Nom d'Usuari:</label>
            <input type="text" name="nom_usuari" required>

            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Imatge de Perfil:</label>
            <input type="file" name="imatge_perfil" accept="image/*" required>

            <label>Contrasenya:</label>
            <input type="password" name="contrasenya" id="contrasenya" required>
            <small class="password-hint">La contrasenya ha de tenir almenys 8 dígits, incloent majúscules, números i caràcters especials.</small>

            <button type="submit">Registrar-se</button>
        </form>
        <div class="redirect">
            Ja tens compte? <a href="login.php">Click aquí per iniciar sessió</a>
        </div>
    </div>
</body>
</html>
