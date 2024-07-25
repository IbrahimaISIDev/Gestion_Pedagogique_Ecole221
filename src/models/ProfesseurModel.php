<?php

namespace App\models;

use PDO;
use App\Core\Model;

class Professeur extends Model
{
    public function getCours($search = '', $page = 1, $perPage = 5)
    {
        $offset = ($page - 1) * $perPage;
        $query = "
        SELECT 
            c.id, 
            c.libelle AS course_libelle, 
            m.libelle AS module_libelle,
            (SELECT COUNT(*) FROM Sessions s WHERE s.cours_id = c.id) AS nombre_sessions,
            (SELECT MIN(s.date_debut) FROM Sessions s WHERE s.cours_id = c.id) AS date_debut,
            (SELECT MAX(s.date_fin) FROM Sessions s WHERE s.cours_id = c.id) AS date_fin,
            (SELECT COUNT(*) FROM Inscriptions i WHERE i.cours_id = c.id) AS etudiants_inscrits
        FROM Cours c
        JOIN Modules m ON c.module_id = m.id
        WHERE c.libelle LIKE ?
        LIMIT :perPage OFFSET :offset
    ";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(1, "%$search%");
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSessions($coursId)
    {
        $stmt = $this->db->prepare("SELECT * FROM Sessions WHERE cours_id = ?");
        $stmt->execute([$coursId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
