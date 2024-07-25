<?php

namespace App\models;

use App\services\Database;
use PDO;

class ModuleModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function getModulesByProfesseurId($professeurId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Modules WHERE professeur_id = ?");
        $stmt->execute([$professeurId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
