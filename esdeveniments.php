<?php
require 'db_connection.php';

// Obtenemos los tipos de eventos para el filtro
$sql = "SELECT DISTINCT tipus FROM Esdeveniments WHERE tipus IS NOT NULL";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$tipus_options = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Esdeveniments</title>
    <link rel="stylesheet" href="estils.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="esdeveniments_script.js"></script> <!-- Enlace al script externo -->
</head>
<body>
    <header>
        <h1>Esdeveniments</h1>
    </header>

    <div id="filters">
        <input type="text" id="event-name" placeholder="Nom de l'esdeveniment">
        <label for="start-date">Data Inici:</label>
        <input type="date" id="start-date">
        <label for="tipus">Tipus:</label>
        <select id="tipus">
            <option value="">Tots</option>
            <?php foreach ($tipus_options as $tipus): ?>
                <option value="<?php echo htmlspecialchars($tipus['tipus']); ?>"><?php echo htmlspecialchars($tipus['tipus']); ?></option>
            <?php endforeach; ?>
        </select>
        <button id="filter-btn">Aplicar filtres</button>
    </div>

    <div id="event-container"></div>
</body>
</html>
