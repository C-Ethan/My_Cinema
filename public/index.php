<?php
define('ROOT', dirname(__DIR__));

// Inclure les fichiers nécessaires
require_once ROOT . '/config/Database.php';
require_once ROOT . '/models/Movie.php';
require_once ROOT . '/models/Genre.php';
require_once ROOT . '/models/Distributor.php';
require_once ROOT . '/models/Members.php';
require_once ROOT . '/controllers/Movie.Controller.php';
require_once ROOT . '/controllers/Members.Controller.php';
require_once ROOT . '/config/router.php'; // Inclure le routeur

// Récupérer la page demandée via le paramètre GET
$page = $_GET['page'] ?? 'home'; // Par défaut, afficher la page d'accueil

// Appeler la fonction de routage
route($page);