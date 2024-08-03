<?php

namespace App\controllers;

use App\models\EmploiDuTempsModel;
use App\models\EtudiantModel;

class EmploiDuTempsController
{
    public function emploiDuTemps($etudiantId)
    {
        $etudiantModel = new EtudiantModel();
        $etudiant = $etudiantModel->getEtudiantById($etudiantId);

        if ($etudiant === null) {
            $this->renderView('views/emploi_du_temps.php', ['error' => "Étudiant non trouvé."]);
            return;
        }

        $this->renderView('views/emploi_du_temps.php', ['etudiant' => $etudiant]);
    }

    public function marquerPresence()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sessionId = $_POST['session_id'] ?? null;
            $etudiantId = $_SESSION['etudiant_id'] ?? null;

            if (!$sessionId || !$etudiantId) {
                echo "Données invalides.";
                return;
            }

            $emploiDuTempsModel = new EmploiDuTempsModel();
            $session = $emploiDuTempsModel->getSessionById($sessionId);

            if ($session) {
                $currentDateTime = new \DateTime();
                $courseDate = new \DateTime($session['date']);
                $courseStartTime = new \DateTime($session['heure_debut']);
                $courseEndTime = new \DateTime($session['heure_fin']);

                if ($currentDateTime > $courseDate) {
                    echo "La date du cours est passée. Vous ne pouvez plus marquer votre présence.";
                    return;
                }

                $thirtyMinutesAfterStart = (clone $courseStartTime)->modify('+30 minutes');
                if ($currentDateTime > $thirtyMinutesAfterStart) {
                    $emploiDuTempsModel->marquerAbsence($etudiantId, $sessionId);
                    echo "Vous ne pouvez plus marquer votre présence. Votre absence a été automatiquement enregistrée.";
                    return;
                }

                if ($currentDateTime < $courseStartTime) {
                    echo "Le cours n'a pas encore commencé. Vous ne pouvez pas marquer votre présence avant le début du cours.";
                    return;
                }

                $emploiDuTempsModel->marquerPresence($etudiantId, $sessionId);
                echo "Votre présence a été marquée avec succès.";
            } else {
                echo "Session non trouvée.";
            }
        }
    }

    private function renderView($viewPath, $data = [])
    {
        extract($data);
        require $viewPath;
    }
}
