<?php

namespace App\Controller;

use App\Core\Controller;
use App\models\AbsenceModel;
use App\models\JustificationModel;

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
        $this->renderView('absences', ['absences' => $absences, 'etudiantId' => $etudiantId]);
    }

    public function addJustification()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $absenceId = $_POST['absence_id'];
            $motif = $_POST['motif'];
            $pieceJointe = null;

            // Handle file upload
            if (isset($_FILES['piece_jointe']) && $_FILES['piece_jointe']['error'] === UPLOAD_ERR_OK) {
                $targetDir = "uploads/";
                $targetFile = $targetDir . basename($_FILES["piece_jointe"]["name"]);
                if (move_uploaded_file($_FILES["piece_jointe"]["tmp_name"], $targetFile)) {
                    $pieceJointe = $targetFile;
                }
            }

            JustificationModel::add($absenceId, $motif, $pieceJointe);
            header('Location: /etudiants/absences');
        }
    }
}
