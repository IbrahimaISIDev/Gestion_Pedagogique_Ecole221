<?php

namespace App\Controller;

use App\models\SessionModel;

class SessionController
{
    private $sessionModel;

    public function __construct()
    {
        $this->sessionModel = new SessionModel();
    }

    public function listerSessions($coursId)
    {
        $sessions = $this->sessionModel->getSessionsByCoursId($coursId);
        $cours = $this->sessionModel->getCoursById($coursId);
        $dateFilter = $_GET['date_filter'] ?? '';

        if (!$cours) {
            error_log("Course not found for ID: $coursId");
            die("Cours non trouvé.");
        }

        if (!isset($cours['libelle'])) {
            error_log("Course libelle not set for ID: $coursId");
            $cours['libelle'] = 'Cours sans nom';
        }

        foreach ($sessions as &$session) {
            $session['className'] = ($session['demande_annulation']) ? 'event-cancelled' : 'event-planned';
        }

        require 'src/views/listerSessions.php';
    }

    public function annulerSession()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sessionId = $_POST['session_id'];
            $motif = $_POST['motif'];
            $this->sessionModel->annulerSession($sessionId, $motif);
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
