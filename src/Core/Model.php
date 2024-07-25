<?php

namespace App\Core;

use App\Services\Database;

class Model {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
}
?>
