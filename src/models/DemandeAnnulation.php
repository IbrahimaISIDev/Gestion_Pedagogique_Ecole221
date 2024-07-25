<?php

namespace App\models;

use App\Core\Model;
use App\services\Database;

class DemandeAnnulation extends Model
{
    public $session_id;
    public $professeur_id;
    public $date_demande;
    public $statut;

    protected $db;

    public function __construct($session_id, $professeur_id)
    {
        $this->db = Database::getInstance()->getConnection(); // Obtenir la connexion
        $this->session_id = $session_id;
        $this->professeur_id = $professeur_id;
        $this->statut = 'en_attente'; // Valeur par défaut
    }

    public function save()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO Demande_Annulation (session_id, professeur_id, date_demande, statut) VALUES (?, ?, ?, ?)");
            $this->date_demande = date('Y-m-d H:i:s'); // Définir la date actuelle
            return $stmt->execute([$this->session_id, $this->professeur_id, $this->date_demande, $this->statut]);
        } catch (\PDOException $e) {
            // Afficher l'erreur pour le débogage
            echo "Erreur lors de l'insertion : " . $e->getMessage();
            return false;
        }
    }
}
