<?php
class MovieController
{
    private $movieModel;
    private $genreModel;
    private $distribModel;
    private $allowedLimits = [10, 25, 50, 100];

    public function __construct()
    {
        $this->movieModel = new Movie();
        $this->genreModel = new Genre();
        $this->distribModel = new Distributor();
    }

    public function index()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $selectedGenre = isset($_GET['genre']) ? intval($_GET['genre']) : null;
        $selectedDistrib = isset($_GET['distributor']) ? intval($_GET['distributor']) : null;
        $searchType = isset($_GET['search_type']) ? $_GET['search_type'] : 'all';
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $limit = isset($_GET['limit']) && in_array(intval($_GET['limit']), $this->allowedLimits)
            ? intval($_GET['limit'])
            : 10;
        $movies = $this->movieModel->searchMovies($search, $selectedGenre, $selectedDistrib, $searchType, $limit, $page);
        $totalMovies = $this->movieModel->getTotalMovies($search, $selectedGenre, $selectedDistrib, $searchType);
        $totalPages = ceil($totalMovies / $limit);
        $genres = $this->genreModel->getAllGenres();
        $distributors = $this->distribModel->getAllDistributors();

        extract([
            'movies' => $movies,
            'genres' => $genres,
            'distributors' => $distributors,
            'search' => $search,
            'searchType' => $searchType,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'limit' => $limit,
            'allowedLimits' => $this->allowedLimits
        ]);

        require ROOT . '/views/movie.view.php';
    }
}