<?php

namespace App\Controller;

use App\services\Database;
use App\Core\Controller;
use App\models\SessionModel;
use App\models\DemandeAnnulation;

class ProfesseurController extends Controller
{
    public function listerCours()
    {
        $db = Database::getInstance()->getConnection();
        if ($db === null) {
            die('Erreur : Impossible d\'établir une connexion à la base de données.');
        }

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['professeur_id'])) {
            header('Location: /login');
            exit;
        }

        $professeur_id = $_SESSION['professeur_id'];

        // Récupérer les informations du professeur connecté
        $stmtProf = $db->prepare("SELECT * FROM Professeurs WHERE id = ?");
        $stmtProf->execute([$professeur_id]);
        $professeur = $stmtProf->fetch();

        // Gestion du filtrage
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 5; // Nombre de cours par page
        $offset = ($page - 1) * $perPage;

        // Requête SQL avec filtrage et pagination
        $query = "SELECT * FROM Cours WHERE libelle LIKE ? LIMIT $perPage OFFSET $offset";
        $stmt = $db->prepare($query);
        $stmt->execute(["%$search%"]);
        $cours = $stmt->fetchAll();

        // Compte total des cours pour la pagination
        $queryCount = "SELECT COUNT(*) FROM Cours WHERE libelle LIKE ?";
        $stmtCount = $db->prepare($queryCount);
        $stmtCount->execute(["%$search%"]);
        $totalCours = $stmtCount->fetchColumn();
        $totalPages = ceil($totalCours / $perPage);

        // Passer les variables nécessaires à la vue
        $this->renderView('listerCours', [
            'cours' => $cours,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'professeur' => $professeur
        ]);
    }

    public function listerSessions($coursId)
    {
        $db = Database::getInstance()->getConnection();

        // Récupérer les sessions par cours ID
        $stmt = $db->prepare("SELECT * FROM Sessions WHERE cours_id = ?");
        $stmt->execute([$coursId]);
        $sessions = $stmt->fetchAll();

        // Récupérer les informations du cours
        $stmt = $db->prepare("SELECT * FROM Cours WHERE id = ?");
        $stmt->execute([$coursId]);
        $cours = $stmt->fetch();

        // Initialiser le modèle de sessions
        $sessionModel = new SessionModel();

        // Passer les variables à la vue
        $this->renderView('listerSessions', [
            'sessions' => $sessions,
            'cours' => $cours,
            'sessionModel' => $sessionModel,
            'coursId' => $coursId  // Ajout de la variable coursId
        ]);
    }

    public function demandeAnnulation()
    {
        if (isset($_POST['session_id'])) {
            $session_id = $_POST['session_id'];
            if (isset($_SESSION['professeur_id'])) {
                $professeur_id = $_SESSION['professeur_id'];
                $demande = new DemandeAnnulation($session_id, $professeur_id);
                if ($demande->save()) {
                    $this->renderView('confirmationAnnulation', ['message' => 'Votre demande d\'annulation a été envoyée.']);
                } else {
                    $this->renderView('confirmationAnnulation', ['message' => 'Échec de l\'envoi de la demande d\'annulation.']);
                }
            } else {
                header('Location: /login');
                exit;
            }
        }
    }

    private function getTotalCours($search)
    {
        $db = Database::getInstance()->getConnection();
        $queryCount = "SELECT COUNT(*) FROM Cours WHERE libelle LIKE ?";
        $stmtCount = $db->prepare($queryCount);
        $stmtCount->execute(["%$search%"]);
        return $stmtCount->fetchColumn();
    }
}
