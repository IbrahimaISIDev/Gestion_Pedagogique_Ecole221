<?php

namespace App\Controller;

use App\services\Database;
use App\Core\Controller;

class AuthController extends Controller
{
    private $pdo;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        if ($db === null) {
            die('Erreur : Impossible d\'établir une connexion à la base de données.');
        }
        $this->pdo = $db;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Vérifier si c'est un professeur ou un étudiant
            $stmt = $this->pdo->prepare("SELECT * FROM Professeurs WHERE email = ?");
            $stmt->execute([$email]);
            $professeur = $stmt->fetch();

            if ($professeur && password_verify($password, $professeur['password'])) {
                $_SESSION['professeur_id'] = $professeur['id'];
                header('Location: /professeurs/cours');
                exit;
            }

            $stmt = $this->pdo->prepare("SELECT * FROM Etudiants WHERE email = ?");
            $stmt->execute([$email]);
            $etudiant = $stmt->fetch();

            if ($etudiant && password_verify($password, $etudiant['password'])) {
                $_SESSION['etudiant_id'] = $etudiant['id'];
                header('Location: /etudiants/cours');
                exit;
            }

            $this->renderView('login', ['error' => 'Email ou mot de passe incorrect']);
        } else {
            $this->renderView('login');
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }
}
