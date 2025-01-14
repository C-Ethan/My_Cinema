<?php
define('ROOT', dirname(__DIR__));

require_once ROOT . '/config/Database.php';
require_once ROOT . '/models/Movie.php';
require_once ROOT . '/models/Genre.php';
require_once ROOT . '/controllers/MovieController.php';

try {
    $controller = new MovieController();
    $controller->index();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}