<?php

namespace App\models;

use App\services\Database;
use PDO;

class JustificationModel {
    public static function add($absenceId, $motif, $pieceJointe) {
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO justifications (absence_id, motif, piece_jointe) VALUES (?, ?, ?)");
        $stmt->execute([$absenceId, $motif, $pieceJointe]);
    }

    public static function getByAbsenceId($absenceId) {
        $db = Database::getConnection();
        $stmt = $db->prepare("SELECT * FROM justifications WHERE absence_id = ?");
        $stmt->execute([$absenceId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
