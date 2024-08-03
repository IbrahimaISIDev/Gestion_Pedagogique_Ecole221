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

// Nouvelle route pour lister toutes les sessions d'un professeur
$router->get('/professeurs/cours/sessions', ['Controller' => 'ProfesseurController', 'action' => 'listerToutesSessions']);

$router->get('/professeurs/annulations', ['Controller' => 'ProfesseurController', 'action' => 'listerDemandesAnnulation']);

// Routes pour les étudiants
$router->get('/etudiants/cours', ['Controller' => 'EtudiantController', 'action' => 'listerCours']);
$router->get('/etudiants/cours/sessions/{coursId}', ['Controller' => 'EtudiantController', 'action' => 'listerSessions']);
$router->post('/etudiants/marquer_presence/{coursId}', ['Controller' => 'EtudiantController', 'action' => 'marquerPresence']);
$router->get('/etudiants/emploi_du_temps', ['Controller' => 'EtudiantController', 'action' => 'emploiDuTemps']);
$router->get('/etudiants/absences', ['Controller' => 'AbsenceController', 'action' => 'listAbsences']);
$router->post('/etudiants/absences', ['Controller' => 'AbsenceController', 'action' => 'addJustification']);
$router->get('/etudiants/justifier_absence', ['Controller' => 'AbsenceController', 'action' => 'justifierAbsence']);

// Routes CRUD pour les étudiants
$router->get('/etudiants', ['Controller' => 'EtudiantController', 'action' => 'index']);
$router->get('/etudiants/view/{id}', ['Controller' => 'EtudiantController', 'action' => 'view']);
$router->get('/etudiants/create', ['Controller' => 'EtudiantController', 'action' => 'create']);
$router->post('/etudiants/create', ['Controller' => 'EtudiantController', 'action' => 'create']);
$router->get('/etudiants/edit/{id}', ['Controller' => 'EtudiantController', 'action' => 'edit']);
$router->post('/etudiants/edit/{id}', ['Controller' => 'EtudiantController', 'action' => 'edit']);
$router->get('/etudiants/delete/{id}', ['Controller' => 'EtudiantController', 'action' => 'delete']);

// Exécution du routeur
$router->run($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);