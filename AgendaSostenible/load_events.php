<?php
require 'db_connection.php';

$name = $_GET['name'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$tipus = $_GET['tipus'] ?? '';

$sql = "SELECT * FROM Esdeveniments WHERE 1=1";
$params = [];

// Filtro por título
if (!empty($name)) {
    $sql .= " AND titol LIKE ?";
    $params[] = "%$name%";
}

// Filtro por fecha de inicio
if (!empty($start_date)) {
    $sql .= " AND data >= ?";
    $params[] = $start_date;
}

// Filtro por tipus
if (!empty($tipus)) {
    $sql .= " AND tipus = ?";
    $params[] = $tipus;
}

// Ordenar por fecha más reciente
$sql .= " ORDER BY data DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$response = ['html' => '', 'events' => []];
foreach ($events as $event) {
    $response['html'] .= "
        <div class='event-card'>
            <h4>{$event['titol']}</h4>
            <p>{$event['descripcio']}</p>
            <p><strong>Data:</strong> {$event['data']}</p>
            <p><strong>Hora:</strong> {$event['hora']}</p>
            <p><strong>Tipus:</strong> {$event['tipus']}</p>
            <p><strong>Valoració:</strong> {$event['valoracio']} estrelles</p>
            <p><strong>Visualitzacions:</strong> {$event['visualitzacions']}</p>
            <a href='agendasostenible.php?event_id={$event['id']}'>Veure més...</a>
        </div>
    ";
    $response['events'][] = [
        'id' => $event['id'],
        'titol' => $event['titol'],
        'descripcio' => $event['descripcio'],
        'data' => $event['data'],
        'hora' => $event['hora'],
        'latitud' => $event['latitud'],
        'longitud' => $event['longitud'],
        'imatge' => $event['imatge'] ?? null,
        'tipus' => $event['tipus'],
        'valoracio' => $event['valoracio'] ?? 0,
        'visualitzacions' => $event['visualitzacions'] ?? 0
    ];
}

echo json_encode($response);
?>
