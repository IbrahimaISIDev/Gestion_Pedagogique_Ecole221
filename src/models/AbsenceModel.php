<?php

namespace App\models;

use App\services\Database;
use PDO;

class AbsenceModel {
    public function getAbsencesByEtudiant($etudiant_id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT a.*, s.date, c.libelle as cours_libelle FROM absences a
                              JOIN Sessions s ON a.session_id = s.id
                              JOIN Cours c ON s.cours_id = c.id
                              WHERE a.etudiant_id = ?');
        $stmt->execute([$etudiant_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addJustification($absence_id, $motif, $fichier) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('INSERT INTO justifications (absence_id, motif, piece_jointe) VALUES (?, ?, ?)');
        return $stmt->execute([$absence_id, $motif, $fichier]);
    }
    
}
?>
