<?php

namespace App\models;

use PDO;
use PDOException;

class EmploiDuTempsModel
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=gestion_pedagogique', 'ibrahimasory', 'Sonatel@2024');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log error instead of echo
            error_log('Database connection error: ' . $e->getMessage());
        }
    }

    public function getCoursSemaine($etudiantId)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT s.date, c.libelle AS cours_libelle, s.heure_debut, s.heure_fin
                FROM Sessions s
                JOIN Cours c ON s.cours_id = c.id
                JOIN Etudiants_Cours ec ON c.id = ec.cours_id
                JOIN Etudiants e ON ec.etudiant_id = e.id
                WHERE e.id = :etudiant_id AND WEEK(s.date) = WEEK(CURDATE()) AND YEAR(s.date) = YEAR(CURDATE())
            ");

            $stmt->execute([':etudiant_id' => $etudiantId]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error instead of echo
            error_log('Error fetching courses: ' . $e->getMessage());
            return [];
        }
    }

    public function getSessionById($sessionId)
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT * FROM Sessions WHERE id = :session_id
            ");
            $stmt->execute([':session_id' => $sessionId]);

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error instead of echo
            error_log('Error fetching session: ' . $e->getMessage());
            return null;
        }
    }

    public function marquerPresence($etudiantId, $sessionId)
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO presences (etudiant_id, session_id, date_presence) 
                VALUES (:etudiant_id, :session_id, NOW())
            ");
            $stmt->bindParam(':etudiant_id', $etudiantId);
            $stmt->bindParam(':session_id', $sessionId);
            $stmt->execute();
        } catch (PDOException $e) {
            // Log error instead of echo
            error_log('Error marking presence: ' . $e->getMessage());
        }
    }

    public function marquerAbsence($etudiantId, $sessionId)
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO absences (etudiant_id, session_id, date_absence) 
                VALUES (:etudiant_id, :session_id, NOW())
            ");
            $stmt->bindParam(':etudiant_id', $etudiantId);
            $stmt->bindParam(':session_id', $sessionId);
            $stmt->execute();
        } catch (PDOException $e) {
            // Log error instead of echo
            error_log('Error marking absence: ' . $e->getMessage());
        }
    }
}
