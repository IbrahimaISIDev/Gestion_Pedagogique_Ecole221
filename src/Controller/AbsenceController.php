<?php

namespace App\Controller;

use App\Core\Controller;
use App\models\AbsenceModel;
use App\models\EtudiantModel; // Ensure you have an EtudiantModel for fetching student data
use App\models\JustificationModel; // Ensure you have a JustificationModel for adding justifications

class AbsenceController extends Controller
{
    public function listAbsences()
    {
        if (!isset($_SESSION['etudiant_id'])) {
            header('Location: /login');
            exit;
        }

        $etudiantId = $_SESSION['etudiant_id'];

        $absenceModel = new AbsenceModel();
        $absences = $absenceModel->getAbsencesByEtudiant($etudiantId);

        // Fetch student details
        $etudiantModel = new EtudiantModel();
        $etudiant = $etudiantModel->getEtudiantById($etudiantId);

        $this->renderView('absences', ['absences' => $absences, 'etudiant' => $etudiant]);
    }

    public function addJustification()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $absenceId = $_POST['absence_id'];
            $motif = $_POST['motif'];
            $pieceJointe = null;

            // Handle file upload
            if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
                $targetDir = "/var/www/html/Gestion-Ecole221/public/uploads/";
                $targetFile = $targetDir . basename($_FILES["fichier"]["name"]);
                if (move_uploaded_file($_FILES["fichier"]["tmp_name"], $targetFile)) {
                    $pieceJointe = $targetFile;
                }
            }

            $absenceModel = new AbsenceModel();
            $absenceModel->addJustification($absenceId, $motif, $pieceJointe);
            header('Location: /etudiants/absences');
        }
    }
}

