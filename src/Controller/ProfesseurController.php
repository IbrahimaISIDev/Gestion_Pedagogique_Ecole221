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
        // $stmt = $db->prepare("SELECT s.*, c.libelle AS cours_libelle FROM Sessions s JOIN Cours c ON s.cours_id = c.id WHERE s.cours_id = ?");
        // $stmt->execute([$coursId]);
        // $sessions = $stmt->fetchAll();

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

    public function listerToutesSessions()
    {
        $db = Database::getInstance()->getConnection();

        if (!isset($_SESSION['professeur_id'])) {
            header('Location: /login');
            exit;
        }

        // Vérifier si le bouton de réinitialisation a été cliqué
        if (isset($_GET['reset'])) {
            // Rediriger vers la même page sans paramètres pour réinitialiser les filtres
            header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
            exit;
        }

        $professeur_id = $_SESSION['professeur_id'];

        // Pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = 5; // Nombre de sessions par page
        $offset = ($page - 1) * $perPage;

        // Recherche et filtrage
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $dateFilter = isset($_GET['date_filter']) ? $_GET['date_filter'] : '';
        $statutFilter = isset($_GET['statut_filter']) ? $_GET['statut_filter'] : '';

        // Construction de la requête SQL
        $query = "
        SELECT s.*, c.libelle AS libelle_cours 
        FROM Sessions s 
        JOIN Cours c ON s.cours_id = c.id 
        JOIN Professeurs_Cours pc ON c.id = pc.cours_id
        WHERE pc.professeur_id = :professeur_id
    ";
        $params = [':professeur_id' => $professeur_id];

        if ($search) {
            $query .= " AND (c.libelle LIKE :search OR s.date LIKE :search)";
            $params[':search'] = "%$search%";
        }
        if ($dateFilter) {
            $query .= " AND s.date = :date_filter";
            $params[':date_filter'] = $dateFilter;
        }
        if ($statutFilter) {
            $query .= " AND s.statut = :statut_filter";
            $params[':statut_filter'] = $statutFilter;
        }

        // Directly include the limit and offset in the SQL query
        $query .= " ORDER BY s.date DESC LIMIT $perPage OFFSET $offset";

        // Exécution de la requête
        $stmt = $db->prepare($query);
        foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val);
        }
        $stmt->execute();
        $sessions = $stmt->fetchAll();

        // Compter le nombre total de sessions pour la pagination
        $countQuery = str_replace('SELECT s.*, c.libelle AS libelle_cours', 'SELECT COUNT(*)', $query);
        $countQuery = preg_replace('/ORDER BY.*$/i', '', $countQuery);
        $countQuery = preg_replace('/LIMIT.*$/i', '', $countQuery);
        $stmtCount = $db->prepare($countQuery);
        foreach ($params as $key => &$val) {
            if ($key !== ':limit' && $key !== ':offset') {
                $stmtCount->bindParam($key, $val);
            }
        }
        $stmtCount->execute();
        $totalSessions = $stmtCount->fetchColumn();
        $totalPages = ceil($totalSessions / $perPage);

        // Récupérer les informations du professeur
        $stmtProf = $db->prepare("SELECT * FROM Professeurs WHERE id = ?");
        $stmtProf->execute([$professeur_id]);
        $professeur = $stmtProf->fetch();

        // Passer les variables à la vue
        $this->renderView('listerAllSessionsProf', [
            'sessions' => $sessions,
            'professeur' => $professeur,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'search' => $search,
            'dateFilter' => $dateFilter,
            'statutFilter' => $statutFilter
        ]);
    }



    public function demandeAnnulation()
    {
        if (isset($_POST['session_id']) && isset($_POST['motif'])) { // Assurez-vous que 'motif' est défini dans POST
            $session_id = $_POST['session_id'];
            $motif = $_POST['motif']; // Récupérer le motif depuis POST
            if (isset($_SESSION['professeur_id'])) {
                $professeur_id = $_SESSION['professeur_id'];
                $demande = new DemandeAnnulation($session_id, $professeur_id, $motif); // Passer $motif au constructeur
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

    public function listerDemandesAnnulation()
    {
        $db = Database::getInstance()->getConnection();

        if (!isset($_SESSION['professeur_id'])) {
            header('Location: /login');
            exit;
        }

        $professeur_id = $_SESSION['professeur_id'];

        // Récupérer les informations du professeur
        $stmtProf = $db->prepare("SELECT * FROM Professeurs WHERE id = ?");
        $stmtProf->execute([$professeur_id]);
        $professeur = $stmtProf->fetch();

        // Récupérer les paramètres de filtrage et de pagination
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 3; // Nombre d'éléments par page
        $offset = ($page - 1) * $limit;

        // Récupérer les demandes d'annulation avec filtrage et pagination
        $demandesAnnulation = DemandeAnnulation::getDemandesByProfesseur($professeur_id, $filter, $limit, $offset);

        // Récupérer le nombre total de demandes pour la pagination
        $totalDemandes = DemandeAnnulation::countDemandesByProfesseur($professeur_id, $filter);
        $totalPages = ceil($totalDemandes / $limit);

        // Passer les variables à la vue
        $this->renderView('listerDemandeAnnulation', [
            'professeur' => $professeur,
            'demandesAnnulation' => $demandesAnnulation,
            'filter' => $filter,
            'page' => $page,
            'totalPages' => $totalPages
        ]);
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
