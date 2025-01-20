<?php
// Charger l'autoloader pour inclure les dépendances
require __DIR__ . '/autoload.php';
require ROOT . '/views/layouts/header.php';
require ROOT . '/views/layouts/sidebar.php';

// Instancier le contrôleur des films
$controller = new MovieController();

// Appeler la méthode index() pour afficher la page des films
$controller->index();
?>