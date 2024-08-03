<?php

namespace App\models;

use App\Core\Model;
use App\services\Database;

class DemandeAnnulation extends Model
{
    public $session_id;
    public $professeur_id;
    public $date_demande;
    public $motif;
    public $statut;

    protected $db;

    public function __construct($session_id, $professeur_id, $motif)
    {
        $this->db = Database::getInstance()->getConnection(); // Obtenir la connexion
        $this->session_id = $session_id;
        $this->professeur_id = $professeur_id;
        $this->motif = $motif; // Définir la propriété $motif
        $this->statut = 'en_attente'; // Valeur par défaut
    }

    public function save()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO Demande_Annulation (session_id, professeur_id, date_demande, motif, statut) VALUES (?, ?, ?, ?, ?)");
            $this->date_demande = date('Y-m-d H:i:s'); // Définir la date actuelle
            return $stmt->execute([$this->session_id, $this->professeur_id, $this->date_demande, $this->motif, $this->statut]); // Ajouter $this->motif ici
        } catch (\PDOException $e) {
            // Afficher l'erreur pour le débogage
            echo "Erreur lors de l'insertion : " . $e->getMessage();
            return false;
        }
    }
    public static function getDemandesByProfesseur($professeur_id, $filter = '', $limit = 3, $offset = 0)
    {
        $db = Database::getInstance()->getConnection();
        $query = "
            SELECT da.*, c.libelle AS libelle_cours
            FROM Demande_Annulation da
            JOIN Sessions s ON da.session_id = s.id
            JOIN Cours c ON s.cours_id = c.id
            WHERE da.professeur_id = ?
        ";

        if ($filter) {
            $query .= " AND (c.libelle LIKE ? OR da.motif LIKE ?)";
        }

        // Concaténer LIMIT et OFFSET directement dans la requête
        $query .= " ORDER BY da.date_demande DESC LIMIT $limit OFFSET $offset";

        $stmt = $db->prepare($query);

        $params = [$professeur_id];
        if ($filter) {
            $params[] = "%$filter%";
            $params[] = "%$filter%";
        }

        $stmt->execute($params);
        return $stmt->fetchAll();
    }


    public static function countDemandesByProfesseur($professeur_id, $filter = '')
    {
        $db = Database::getInstance()->getConnection();
        $query = "
            SELECT COUNT(*) AS total
            FROM Demande_Annulation da
            JOIN Sessions s ON da.session_id = s.id
            JOIN Cours c ON s.cours_id = c.id
            WHERE da.professeur_id = ?
        ";

        if ($filter) {
            $query .= " AND (c.libelle LIKE ? OR da.motif LIKE ?)";
        }

        $stmt = $db->prepare($query);

        $params = [$professeur_id];
        if ($filter) {
            $params[] = "%$filter%";
            $params[] = "%$filter%";
        }

        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
}
