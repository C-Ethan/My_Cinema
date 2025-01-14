<?php
class MovieController {
    private $movieModel;
    private $genreModel;
    private $allowedLimits = [10, 25, 50, 100];
    
    public function __construct() {
        $this->movieModel = new Movie();
        $this->genreModel = new Genre();
    }
    
    public function index() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $selectedGenre = isset($_GET['sort']) ? intval($_GET['sort']) : null;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = isset($_GET['limit']) && in_array(intval($_GET['limit']), $this->allowedLimits) 
            ? intval($_GET['limit']) 
            : 10;

        $movies = $this->movieModel->searchMovies($search, $selectedGenre, $limit, $page);
        $totalMovies = $this->movieModel->getTotalMovies($search, $selectedGenre);
        $totalPages = ceil($totalMovies / $limit);
        $genres = $this->genreModel->getAllGenres();
        
        extract([
            'movies' => $movies,
            'genres' => $genres,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'limit' => $limit,
            'allowedLimits' => $this->allowedLimits
        ]);
        
        require_once ROOT . '/views/movie/index.php';
    }
}