<?php

namespace App\models;

use PDO;
use PDOException;

class EmploiDuTempsModel
{
    public function getCoursSemaine($etudiantId)
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=gestion_pedagogique', 'ibrahimasory', 'Sonatel@2024');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("
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
            echo "Erreur : " . $e->getMessage();
            return [];
        }
    }

    public function marquerPresence($etudiantId, $sessionId)
    {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=gestion_pedagogique', 'ibrahimasory', 'Sonatel@2024');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("
                INSERT INTO presences (etudiant_id, session_id, date_presence) 
                VALUES (:etudiant_id, :session_id, NOW())
            ");
            $stmt->bindParam(':etudiant_id', $etudiantId);
            $stmt->bindParam(':session_id', $sessionId);
            $stmt->execute();
        } catch (PDOException $e) {
            // Gérer les erreurs de connexion à la base de données
            echo 'Erreur de connexion : ' . $e->getMessage();
        }
    }
}
