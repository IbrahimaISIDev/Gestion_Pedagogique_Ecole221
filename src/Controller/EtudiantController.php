<?php

namespace App\Controller;

use App\models\EtudiantModel;
use App\models\SessionModel;
use App\Core\Controller;

class EtudiantController extends Controller
{
    private $etudiantModel;
    private $sessionModel;

    public function __construct()
    {
        $this->etudiantModel = new EtudiantModel();
        $this->sessionModel = new SessionModel(); // Ensure this line is present
    }

    public function listerCours()
    {
        if (!isset($_SESSION['etudiant_id'])) {
            header('Location: /login');
            exit();
        }

        $etudiantId = $_SESSION['etudiant_id'];
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 2;
        $offset = ($page - 1) * $limit;
        $filter = isset($_GET['filter']) ? $_GET['filter'] : '';

        $cours = $this->etudiantModel->getCoursesByStudentId($etudiantId, $limit, $offset, $filter);
        $totalCours = $this->etudiantModel->getCoursesCountByStudentId($etudiantId, $filter);
        $totalPages = ceil($totalCours / $limit);

        $etudiant = $this->etudiantModel->getEtudiantById($etudiantId);

        // Fixed values for now
        $anneeScolaire = "2023-2024";
        $semestre = "Semestre 1";
        $classe = "Classe A";

        $this->renderView('listerCoursEtudiant', [
            'cours' => $cours,
            'etudiant' => $etudiant,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'filter' => $filter,
            'anneeScolaire' => $anneeScolaire,
            'semestre' => $semestre,
            'classe' => $classe
        ]);
    }

    public function index()
    {
        $etudiants = $this->etudiantModel->getAllEtudiants();
        $this->renderView('etudiants/index', ['etudiants' => $etudiants]);
    }

    public function view($id)
    {
        $etudiant = $this->etudiantModel->getEtudiantById($id);
        if ($etudiant) {
            $this->renderView('etudiants/view', ['etudiant' => $etudiant]);
        } else {
            // Gérer le cas où l'étudiant n'existe pas
            $this->renderView('404');
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $classeId = $_POST['classe_id'] ?? '';
            $niveau = $_POST['niveau'] ?? '';

            $this->etudiantModel->addEtudiant($nom, $prenom, $email, $password, $classeId, $niveau);
            header('Location: /etudiants');
            exit;
        } else {
            // Charger la vue pour créer un étudiant
            $this->renderView('etudiants/create');
        }
    }

    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $classeId = $_POST['classe_id'] ?? '';
            $niveau = $_POST['niveau'] ?? '';

            $this->etudiantModel->updateEtudiant($id, $nom, $prenom, $email, $password, $classeId, $niveau);
            header('Location: /etudiants');
            exit;
        } else {
            $etudiant = $this->etudiantModel->getEtudiantById($id);
            if ($etudiant) {
                $this->renderView('etudiants/edit', ['etudiant' => $etudiant]);
            } else {
                // Gérer le cas où l'étudiant n'existe pas
                $this->renderView('404');
            }
        }
    }

    public function delete($id)
    {
        $this->etudiantModel->deleteEtudiant($id);
        header('Location: /etudiants');
        exit;
    }

    public function listerSessions($coursId)
    {
        if (!isset($_SESSION['etudiant_id'])) {
            header('Location: /login');
            exit();
        }

        $sessions = $this->sessionModel->getSessionsByCoursId($coursId); // Implement this method in SessionModel

        $this->renderView('listerSessionsEtudiant', [
            'sessions' => $sessions,
            'coursId' => $coursId
        ]);
    }

    public function marquerPresence($coursId)
    {
        if (!isset($_SESSION['etudiant_id'])) {
            header('Location: /login');
            exit();
        }

        // Assurez-vous que $coursId est valide
        $coursId = $_POST['coursId'] ?? $coursId; // Utilisez la valeur du paramètre ou de la requête POST

        if ($coursId) {
            $etudiantId = $_SESSION['etudiant_id'];
            $this->etudiantModel->markAttendance($etudiantId, $coursId);

            // Réponse de succès
            echo json_encode(['message' => 'Présence marquée avec succès !']);
        } else {
            // Réponse d'erreur
            echo json_encode(['message' => 'Erreur : ID du cours manquant.']);
        }
        exit();
    }



    public function emploiDuTemps()
    {
        if (isset($_SESSION['etudiant_id'])) {
            $etudiantId = $_SESSION['etudiant_id'];
            $emploiDuTemps = $this->etudiantModel->getEmploiDuTemps($etudiantId);
            // Passer les sessions correctement à la vue
            $this->renderView('emploi_du_temps', ['emploiDuTemps' => $emploiDuTemps]);
        } else {
            echo "L'ID de l'étudiant n'est pas défini dans la session.";
        }
    }

}
