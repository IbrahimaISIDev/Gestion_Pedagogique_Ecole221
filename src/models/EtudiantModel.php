<?php

namespace App\models;

use App\services\Database;
use PDOException;
use PDO;

class EtudiantModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // public function getEtudiantById($id)
    // {
    //     $stmt = $this->pdo->prepare("SELECT * FROM Etudiants WHERE id = ?");
    //     $stmt->execute([$id]);
    //     return $stmt->fetch();
    // }

    public function getAllEtudiants()
    {
        $stmt = $this->pdo->query("SELECT * FROM Etudiants");
        return $stmt->fetchAll();
    }

    public function getEtudiantsByClasse($classeId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Etudiants WHERE classe_id = ?");
        $stmt->execute([$classeId]);
        return $stmt->fetchAll();
    }

    public function addEtudiant($nom, $prenom, $email, $password, $classeId, $niveau)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("INSERT INTO Etudiants (nom, prenom, email, password, classe_id, niveau) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nom, $prenom, $email, $hashedPassword, $classeId, $niveau]);
    }

    public function updateEtudiant($id, $nom, $prenom, $email, $password, $classeId, $niveau)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare("UPDATE Etudiants SET nom = ?, prenom = ?, email = ?, password = ?, classe_id = ?, niveau = ? WHERE id = ?");
        return $stmt->execute([$nom, $prenom, $email, $hashedPassword, $classeId, $niveau, $id]);
    }

    public function deleteEtudiant($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM Etudiants WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Etudiants WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    public function getCoursesByStudentId($studentId, $limit = 2, $offset = 0, $filter = '')
    {
        $sql = "
            SELECT Cours.id, Cours.libelle, Cours.quota_horaire, COUNT(Sessions.id) AS nombre_sessions,
                   Professeurs.nom AS professeur_nom, Professeurs.prenom AS professeur_prenom
            FROM Cours 
            JOIN Etudiants ON Cours.classe_id = Etudiants.classe_id 
            JOIN Professeurs ON Cours.professeur_id = Professeurs.id
            LEFT JOIN Sessions ON Cours.id = Sessions.cours_id
            WHERE Etudiants.id = ?
            AND (Cours.libelle LIKE ? OR Professeurs.nom LIKE ? OR Professeurs.prenom LIKE ?)
            GROUP BY Cours.id, Professeurs.nom, Professeurs.prenom
            LIMIT $limit OFFSET $offset
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, "%$filter%", "%$filter%", "%$filter%"]);
        return $stmt->fetchAll();
    }



    public function getCoursesCountByStudentId($studentId, $filter = '')
    {
        $sql = "
            SELECT COUNT(*) AS total
            FROM Cours 
            JOIN Etudiants ON Cours.classe_id = Etudiants.classe_id 
            JOIN Professeurs ON Cours.professeur_id = Professeurs.id
            WHERE Etudiants.id = ?
            AND (Cours.libelle LIKE ? OR Professeurs.nom LIKE ? OR Professeurs.prenom LIKE ?)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$studentId, "%$filter%", "%$filter%", "%$filter%"]);
        return $stmt->fetch()['total'];
    }



    public function getSessionsByCoursId($coursId)
    {
        $stmt = $this->pdo->prepare('
        SELECT s.id, s.date, s.heure_debut, s.heure_fin 
        FROM Sessions s 
        WHERE s.cours_id = ?
        ORDER BY s.date, s.heure_debut
    ');
        $stmt->execute([$coursId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function markAttendance($etudiantId, $coursId)
    // {
    //     $stmt = $this->pdo->prepare('
    //     INSERT INTO Attendance (etudiant_id, cours_id, date) 
    //     VALUES (?, ?, NOW())
    //     ON DUPLICATE KEY UPDATE date = NOW()
    // ');
    //     return $stmt->execute([$etudiantId, $coursId]);
    // }
    public function markAttendance($etudiantId, $coursId)
    {
        $sql = "INSERT INTO presences (etudiant_id, cours_id) VALUES (:etudiant_id, :cours_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':etudiant_id', $etudiantId, PDO::PARAM_INT);
        $stmt->bindParam(':cours_id', $coursId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getEmploiDuTemps($etudiantId)
    {
        $sql = "SELECT c.libelle, s.date, s.heure_debut, s.heure_fin 
                FROM Cours c
                JOIN Sessions s ON c.id = s.cours_id
                JOIN Etudiants_Cours ec ON c.id = ec.cours_id
                WHERE ec.etudiant_id = :etudiantId
                AND YEARWEEK(s.date, 1) = YEARWEEK(CURDATE(), 1)
                ORDER BY s.date, s.heure_debut";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':etudiantId', $etudiantId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEtudiantByEmailAndPassword($email, $password)
    {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare('SELECT * FROM etudiants WHERE email = ? AND password = ?');
        $stmt->execute([$email, $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEtudiantById($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM Etudiants WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return null;
        }
    }

    public function getCoursById($coursId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Cours WHERE id = ?");
        $stmt->execute([$coursId]);
        return $stmt->fetch();
    }
}
