<?php

namespace App\services;

use PDO;
use Symfony\Component\Yaml\Yaml;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $configFile = __DIR__ . '/../config/config.yaml';
        if (!file_exists($configFile)) {
            die("Le fichier de configuration n'existe pas : $configFile");
        }

        $config = Yaml::parseFile($configFile);

        try {
            $this->connection = new PDO(
                "mysql:host={$config['database']['host']};dbname={$config['database']['dbname']}",
                $config['database']['user'],
                $config['database']['password']
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die('Erreur de connexion: ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
