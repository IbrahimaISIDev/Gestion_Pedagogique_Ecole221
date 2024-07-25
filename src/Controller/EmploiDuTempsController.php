
<?php

use App\models\EmploiDuTempsModel;

class EmploiDuTempsController
{
    public function afficherEmploiDuTemps($etudiantId)
    {
        $model = new EmploiDuTempsModel();
        $emploiDuTemps = $model->getCoursSemaine($etudiantId);

        // Passer les données à la vue
        include 'views/emploi_du_temps.php'; // Assurez-vous que le chemin est correct
    }

    public function marquerPresence()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sessionId = $_POST['session_id'];
            $etudiantId = $_SESSION['etudiant_id']; // Assurez-vous que l'ID de l'étudiant est stocké dans la session

            $model = new EmploiDuTempsModel();
            $model->marquerPresence($etudiantId, $sessionId);

            // Redirection après la soumission du formulaire
            header('Location: /etudiants/emploi_du_temps');
            exit();
        }
    }
}
