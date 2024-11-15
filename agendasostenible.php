<?php
session_start();
require 'db_connection.php';

$rol = $_SESSION['user_role'] ?? 'public';
$user_id = $_SESSION['user_id'] ?? null;

// Obtenim tots els esdeveniments
$sql = "SELECT * FROM Esdeveniments ORDER BY data DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($user_id) {
    $sql = "SELECT nom_usuari, imatge_perfil, rol FROM usuaris WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Agenda Sostenible</title>
    <link rel="stylesheet" href="estils.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>
<body>

<div class="navbar">
    <img src="logo.jpg" alt="Logo de l'Agenda Sostenible" class="logo">
    <div class="nav-links">
        <a href="esdeveniments.php">Esdeveniments</a>
        <a href="consells.php">Consells de sostenibilitat</a>
        <a href="anuncis.php">Anunci classificat</a>
        <a href="favorits.php">Favorits</a>
        <?php if ($rol === 'admin'): ?>
            <a href="admin_panel.php">Admin Panel</a>
        <?php endif; ?>
    </div>
    <div class="user-info">
        <?php if ($rol !== 'public' && isset($user)): ?>
            <img src="uploads/<?php echo htmlspecialchars($user['imatge_perfil']); ?>" alt="Foto de perfil">
            <a href="perfil.php">Hola, <?php echo htmlspecialchars($user['nom_usuari']); ?> (<?php echo htmlspecialchars($user['rol']); ?>)</a>
            <a href="logout.php" class="button">Tancar sessió</a>
        <?php else: ?>
            <a href="registre.php" class="button">Registra't</a>
            <a href="login.php" class="button">Inicia sessió</a>
        <?php endif; ?>
    </div>
</div>

<main>
    <section id="welcome">
        <h2>Benvingut a l'Agenda Sostenible</h2>
        <p>Descobreix esdeveniments futurs relacionats amb la sostenibilitat i contribueix a un món millor.</p>
    </section>

    <section id="esdeveniments" class="card-container">
        <h3>Esdeveniments</h3>
        <?php foreach ($events as $event): ?>
            <div class="event-card">
                <h4><?php echo htmlspecialchars($event['titol']); ?></h4>
                <p><?php echo htmlspecialchars($event['descripcio']); ?></p>
                <p><strong>Data:</strong> <?php echo htmlspecialchars($event['data']); ?></p>
                <p><strong>Tipus:</strong> <?php echo htmlspecialchars($event['tipus']); ?></p>
                <p><strong>Valoració:</strong> <?php echo number_format($event['valoracio'], 1); ?> ★</p>
                <?php if ($event['imatge']): ?>
                    <img src="uploads/<?php echo htmlspecialchars($event['imatge']); ?>" alt="Imatge de l'esdeveniment" style="width: 100%; max-height: 150px; object-fit: cover;">
                <?php endif; ?>

                <!-- Mapa -->
                <div id="map-<?php echo $event['id']; ?>" class="event-map" style="width: 100%; height: 200px; margin-top: 10px;"></div>

                <!-- Valoracions -->
                <?php if ($rol !== 'public'): ?>
                    <form class="rating-form" data-event-id="<?php echo $event['id']; ?>">
                        <label for="rating">Valora l'esdeveniment (1-5):</label>
                        <select name="rating" id="rating" required>
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?> ★</option>
                            <?php endfor; ?>
                        </select>
                        <button type="submit">Enviar Valoració</button>
                    </form>
                <?php else: ?>
                    <p><a href="login.php">Inicia sessió per valorar els esdeveniments.</a></p>
                <?php endif; ?>

                <!-- Comentaris -->
                <h5>Comentaris:</h5>
                <?php
                $sql_comments = "SELECT c.comentari, u.nom_usuari 
                                 FROM Comentaris c 
                                 JOIN usuaris u ON c.usuari_id = u.id 
                                 WHERE c.esdeveniment_id = ? AND c.estat = 'publicat'";
                $stmt_comments = $pdo->prepare($sql_comments);
                $stmt_comments->execute([$event['id']]);
                $comentaris = $stmt_comments->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div id="comentaris-container-<?php echo $event['id']; ?>">
                    <?php if (!empty($comentaris)): ?>
                        <?php foreach ($comentaris as $comentari): ?>
                            <p><strong><?php echo htmlspecialchars($comentari['nom_usuari']); ?>:</strong> <?php echo htmlspecialchars($comentari['comentari']); ?></p>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hi ha comentaris encara.</p>
                    <?php endif; ?>
                </div>

                <?php if ($rol !== 'public'): ?>
                    <form class="comment-form" data-event-id="<?php echo $event['id']; ?>">
                        <textarea name="comentari" placeholder="Escriu el teu comentari..." required></textarea>
                        <button type="submit">Enviar Comentari</button>
                    </form>
                <?php else: ?>
                    <p><a href="login.php">Inicia sessió per afegir comentaris.</a></p>
                <?php endif; ?>

                <!-- Afegir a favorits -->
                <button class="favorite-btn btn btn-outline-success" data-event-id="<?php echo $event['id']; ?>">
    ❤️ Afegir a Favorits
</button>

            </div>
        <?php endforeach; ?>
    </section>
</main>

<footer>
    <div><a href="politica_cookies.html">Política de Cookies</a></div>
    <div><a href="credits.html">Crèdits d'Imatges</a></div>
</footer>

<script>
// Inicialitzar mapes
<?php foreach ($events as $event): ?>
    const map<?php echo $event['id']; ?> = L.map('map-<?php echo $event['id']; ?>').setView([<?php echo $event['latitud']; ?>, <?php echo $event['longitud']; ?>], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map<?php echo $event['id']; ?>);
    L.marker([<?php echo $event['latitud']; ?>, <?php echo $event['longitud']; ?>]).addTo(map<?php echo $event['id']; ?>)
        .bindPopup('<?php echo htmlspecialchars($event['titol']); ?>');
<?php endforeach; ?>

// AJAX per valoracions
$('.rating-form').submit(function (e) {
    e.preventDefault();
    const form = $(this);
    const eventId = form.data('event-id');
    const rating = form.find('select[name="rating"]').val();

    $.ajax({
        url: 'submit_rating.php',
        type: 'POST',
        data: { esdeveniment_id: eventId, valoracio: rating },
        success: function () {
            alert('Valoració enviada!');
        },
        error: function () {
            alert('Hi ha hagut un error.');
        }
    });
});

// AJAX per comentaris
$('.comment-form').submit(function (e) {
    e.preventDefault();
    const form = $(this);
    const eventId = form.data('event-id');
    const comentari = form.find('textarea[name="comentari"]').val();

    $.ajax({
        url: 'submit_comment.php',
        type: 'POST',
        data: { esdeveniment_id: eventId, comentari: comentari },
        success: function () {
            alert('Comentari enviat! Està pendent d\'aprovació.');
            form.find('textarea[name="comentari"]').val('');
        },
        error: function () {
            alert('Hi ha hagut un error en enviar el comentari.');
        }
    });
});

// AJAX per afegir a favorits
$('.favorite-btn').click(function () {
    const eventId = $(this).data('event-id');
    $.ajax({
        url: 'favorits.php',
        type: 'POST',
        data: { event_id: eventId },
        success: function (response) {
            alert(response); // Mostra el missatge del servidor
        },
        error: function () {
            alert('Hi ha hagut un error en afegir als favorits.');
        }
    });
});
</script>
</body>
</html>
