<?php

use App\services\Database;
use Symfony\Component\Yaml\Yaml;

require __DIR__ . '/vendor/autoload.php';

try {
    $db = Database::getInstance()->getConnection();
    echo "Connexion réussie à la base de données.";
} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
