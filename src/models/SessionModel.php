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

    public function cancelSession($sessionId)
    {
        $stmt = $this->pdo->prepare("UPDATE Sessions SET statut = 'annulée' WHERE id = ?");
        return $stmt->execute([$sessionId]);
    }

    public function annulerSession($sessionId, $motif)
    {
        $stmt = $this->pdo->prepare('UPDATE Sessions SET statut = "annulée", demande_annulation = TRUE WHERE id = ?');
        $stmt->execute([$sessionId]);
    }
    
}
?>
