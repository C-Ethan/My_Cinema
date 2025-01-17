<?php
function route($page) {
    // Définir les routes et leurs actions
    $routes = [
        'home' => function() {
            require_once ROOT . '/views/home.php';
        },
        'movie' => function() {
            $controller = new MovieController();
            $movies = $controller->getMovies();
            $genres = $controller->getGenres();
            $distributors = $controller->getDistributors();
            $search = $_GET['search'] ?? '';
            $searchType = $_GET['search_type'] ?? 'all';
            $allowedLimits = [10, 20, 50];
            $limit = $_GET['limit'] ?? $allowedLimits[0];

            require_once ROOT . '/views/movie.php';
        },
        'member' => function() {
            $controller = new MembersController();
            $members = $controller->getMembers();
            $search = $_GET['search'] ?? '';
            $searchType = $_GET['search_type'] ?? 'all';
            $allowedLimits = [10, 20, 50];
            $limit = $_GET['limit'] ?? $allowedLimits[0];

            require_once ROOT . '/views/member.php';
        }
    ];

    // Exécuter la route correspondante ou afficher une erreur 404
    if (array_key_exists($page, $routes)) {
        $routes[$page](); // Appeler la fonction associée à la route
    } else {
        http_response_code(404);
        echo "<h1>404 - Page non trouvée</h1>";
    }
}