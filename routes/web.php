<?php

use App\Core\Router;
use Dotenv\Dotenv;

// Chargement des variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Initialisation du routeur
$router = new Router();

// Routes pour l'authentification
$router->get('/login', ['Controller' => 'AuthController', 'action' => 'login']);
$router->post('/login', ['Controller' => 'AuthController', 'action' => 'login']);
$router->get('/logout', ['Controller' => 'AuthController', 'action' => 'logout']);

// Routes pour les professeurs
$router->get('/professeurs/cours', ['Controller' => 'ProfesseurController', 'action' => 'listerCours']);
$router->get('/professeurs/cours/sessions/{coursId}', ['Controller' => 'ProfesseurController', 'action' => 'listerSessions']);
$router->post('/professeurs/cours/sessions/annuler', ['Controller' => 'ProfesseurController', 'action' => 'demandeAnnulation']);

// Routes pour les étudiants
$router->get('/etudiants/cours', ['Controller' => 'EtudiantController', 'action' => 'listerCours']);

$router->get('/etudiants/cours/sessions/{coursId}', ['Controller' => 'EtudiantController', 'action' => 'listerSessions']);
$router->post('/etudiants/marquer_presence/{coursId}', ['Controller' => 'EtudiantController', 'action' => 'marquerPresence']);

$router->get('/etudiants/emploi_du_temps', ['Controller' => 'EtudiantController', 'action' => 'emploiDuTemps']);

$router->get('/etudiants/absences', ['Controller' => 'AbsenceController', 'action' => 'listAbsences']);


//$router->get('/etudiants/absences/{etudiantId}', 'AbsenceController@listAbsences');

$router->get('/etudiants/justifier_absence', ['Controller' => 'AbsenceController', 'action' => 'justifierAbsence']);



$router->get('/etudiants', ['Controller' => 'EtudiantController', 'action' => 'index']); // Liste des étudiants
$router->get('/etudiants/view/{id}', ['Controller' => 'EtudiantController', 'action' => 'view']); // Détails d'un étudiant
$router->get('/etudiants/create', ['Controller' => 'EtudiantController', 'action' => 'create']); // Formulaire de création
$router->post('/etudiants/create', ['Controller' => 'EtudiantController', 'action' => 'create']); // Soumettre le formulaire de création
$router->get('/etudiants/edit/{id}', ['Controller' => 'EtudiantController', 'action' => 'edit']); // Formulaire d'édition
$router->post('/etudiants/edit/{id}', ['Controller' => 'EtudiantController', 'action' => 'edit']); // Soumettre le formulaire d'édition
$router->get('/etudiants/delete/{id}', ['Controller' => 'EtudiantController', 'action' => 'delete']); // Supprimer un étudiant

// Exécution du routeur
$router->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
