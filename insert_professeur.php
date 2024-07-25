<?php

use App\services\Database;

require __DIR__ . '/vendor/autoload.php';

$db = Database::getInstance()->getConnection();

// Adresse email à insérer
$email = 'ibrahima.diallojunior@sonatelacademy.sn';

// Vérifier si l'email existe déjà
$queryCheck = "SELECT COUNT(*) FROM Professeurs WHERE email = ?";
$stmtCheck = $db->prepare($queryCheck);
$stmtCheck->execute([$email]);
$count = $stmtCheck->fetchColumn();

if ($count > 0) {
    // Supprimer l'entrée existante
    $queryDelete = "DELETE FROM Professeurs WHERE email = ?";
    $stmtDelete = $db->prepare($queryDelete);
    $stmtDelete->execute([$email]);
    echo "Ancien professeur supprimé.\n";
}

// Hacher le mot de passe
$passwordHash = password_hash('Sonatel@2024', PASSWORD_DEFAULT);

// Insérer le nouveau professeur
$queryInsert = "INSERT INTO Professeurs (nom, prenom, specialite, grade, email, password) VALUES (?, ?, ?, ?, ?, ?)";
$stmtInsert = $db->prepare($queryInsert);
$stmtInsert->execute(['Diallo', 'Ibrahima', 'Developpement FullStack', 'Junior', $email, $passwordHash]);

echo "Professeur inséré avec succès.\n";
