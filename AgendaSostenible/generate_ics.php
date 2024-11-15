<?php
require 'db_connection.php';

header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="esdeveniments.ics"');

$sql = "SELECT * FROM Esdeveniments WHERE data >= CURDATE()";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$esdeveniments = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "BEGIN:VCALENDAR\nVERSION:2.0\nCALSCALE:GREGORIAN\n";
foreach ($esdeveniments as $esdeveniment) {
    $start = date('Ymd\THis\Z', strtotime("{$esdeveniment['data']} {$esdeveniment['hora']}"));
    echo "BEGIN:VEVENT\n";
    echo "SUMMARY:{$esdeveniment['titol']}\n";
    echo "DTSTART:{$start}\n";
    echo "DESCRIPTION:{$esdeveniment['descripcio']}\n";
    echo "LOCATION:{$esdeveniment['latitud']}, {$esdeveniment['longitud']}\n";
    echo "END:VEVENT\n";
}
echo "END:VCALENDAR";
?>
