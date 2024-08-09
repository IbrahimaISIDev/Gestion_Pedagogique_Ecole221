<?php

namespace App\models;

use PDO;

class SessionModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=gestion_pedagogique', 'ibrahimasory', 'Sonatel@2024');
    }

    public function getSessionsByCoursId($coursId)
    {
        $stmt = $this->pdo->prepare("
            SELECT s.id, s.date, s.heure_debut, s.heure_fin, s.statut, s.demande_annulation, c.libelle as cours_libelle
            FROM Sessions s 
            JOIN Cours c ON s.cours_id = c.id
            WHERE s.cours_id = ?
        ");
        $stmt->execute([$coursId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCoursById($coursId)
    {
        $stmt = $this->pdo->prepare("SELECT id, libelle FROM Cours WHERE id = ?");
        $stmt->execute([$coursId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cancelSession($sessionId, $motif)
    {
        $stmt = $this->pdo->prepare("UPDATE Sessions SET statut = 'annulée' WHERE id = ?");
        $stmt->execute([$sessionId]);

        $stmt = $this->pdo->prepare('INSERT INTO Demande_Annulation (session_id, professeur_id, date_demande, motif, statut) VALUES (?, ?, NOW(), ?, "en_attente")');
        $stmt->execute([$sessionId, $_SESSION['professeur_id'], $motif]);
    }

    public function getSessionsForWeek($professeurId, $startDate, $endDate)
    {
        $stmt = $this->pdo->prepare("
        SELECT s.*, c.libelle AS cours_libelle 
        FROM Sessions s 
        JOIN Cours c ON s.cours_id = c.id
        JOIN Professeurs_Cours pc ON c.id = pc.cours_id
        WHERE pc.professeur_id = :professeur_id
        AND s.date BETWEEN :start_date AND :end_date
        ORDER BY s.date, s.heure_debut
    ");
        $stmt->execute([
            ':professeur_id' => $professeurId,
            ':start_date' => $startDate,
            ':end_date' => $endDate
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
