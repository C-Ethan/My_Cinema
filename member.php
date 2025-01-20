<?php
// Charger l'autoloader pour inclure les dépendances
require __DIR__ . '/autoload.php';
require ROOT . '/views/layouts/header.php';
require ROOT . '/views/layouts/sidebar.php';

// Instancier le contrôleur des membres
$controller = new MemberController();

// Appeler la méthode index() pour afficher la page des membres
$controller->index();
?>