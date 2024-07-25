<?php

require_once 'vendor/autoload.php'; // Assurez-vous que le chemin vers autoload.php est correct

use App\models\DemandeAnnulation;

$demande = new DemandeAnnulation(1, 1);
if ($demande->save()) {
    echo "Demande d'annulation enregistrée avec succès.";
} else {
    echo "Échec de l'enregistrement de la demande d'annulation.";
}
