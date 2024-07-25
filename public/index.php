<?php

session_start();


define('ROOT', '/var/www/html/Gestion-Ecole221/');

require_once __DIR__ . '/../vendor/autoload.php';

// Include routes
require_once ROOT . 'routes/web.php';

