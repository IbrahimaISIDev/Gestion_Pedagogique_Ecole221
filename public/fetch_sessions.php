<?php
require_once __DIR__ . '/../vendor/autoload.php'; // Charge l'autoload de Composer

use App\services\Database;

$pdo = Database::getInstance()->getConnection();
$currentMonth = date('m');
$currentYear = date('Y');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);

$sql = "SELECT s.date, s.heure_debut, s.heure_fin, c.libelle 
        FROM Sessions s 
        JOIN Cours c ON s.cours_id = c.id
        WHERE MONTH(s.date) = :currentMonth AND YEAR(s.date) = :currentYear";

$stmt = $pdo->prepare($sql);
$stmt->execute([':currentMonth' => $currentMonth, ':currentYear' => $currentYear]);
$sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$events = [];
foreach ($sessions as $session) {
    $eventDate = date('j', strtotime($session['date']));
    $events[$eventDate][] = $session['libelle'];
}
?>
