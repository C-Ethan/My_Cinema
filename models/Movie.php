<?php
class Movie {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function searchMovies($movieSearch = '', $directorSearch, $selectedGenre = null, $selectedDistrib = null, $limit = 20, $page = 1) {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT
                    movie.*,
                    movie_genre.id_genre,
                    genre.name AS 'genre',
                    distributor.name AS 'distributor_name'
                  FROM 
                    movie
                  JOIN
                    movie_genre ON movie.id = movie_genre.id_movie
                  JOIN 
                    genre ON movie_genre.id_genre = genre.id
                  JOIN
                    distributor ON movie.id_distributor = distributor.id";

        $conditions = [];
        $params = [];

        if (!empty($movieSearch)) {
            $conditions[] = "movie.title LIKE :movieSearch";
            $params[':movieSearch'] = "%$movieSearch%";
        }
    
        if (!empty($directorSearch)) {
            $conditions[] = "director LIKE :directorSearch";
            $params[':directorSearch'] = "%$directorSearch%";
        }

        if ($selectedGenre) {
            $conditions[] = "genre.id = :genre";
            $params[':genre'] = $selectedGenre;
        }

        if ($selectedDistrib) {
            $conditions[] = "distributor.id = :distributor";
            $params[':distributor'] = $selectedDistrib;
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $query .= " ORDER BY movie.id ASC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getTotalMovies($movieSearch = '', $directorSearch, $selectedGenre = null, $selectedDistrib = null) {
        $query = "SELECT COUNT(DISTINCT movie.id) as total FROM 
                    movie
                  JOIN
                    movie_genre ON movie.id = movie_genre.id_movie
                  JOIN 
                    genre ON movie_genre.id_genre = genre.id
                  JOIN
                    distributor ON movie.id_distributor = distributor.id";

        $conditions = [];
        $params = [];

        if (!empty($movieSearch)) {
            $conditions[] = "movie.title LIKE :movieSearch";
            $params[':movieSearch'] = "%$movieSearch%";
        }
    
        if (!empty($directorSearch)) {
            $conditions[] = "director LIKE :directorSearch";
            $params[':directorSearch'] = "%$directorSearch%";
        }

        if ($selectedGenre) {
            $conditions[] = "genre.id = :genre";
            $params[':genre'] = $selectedGenre;
        }

        if ($selectedDistrib) {
            $conditions[] = "distributor.id = :distributor";
            $params[':distributor'] = $selectedDistrib;
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetch()['total'];
    }

    public function getAllMovies() {
        $query = "SELECT 
                    movie.id,
                    movie.title,
                    movie.director,
                    genre.name AS genre,
                    distributor.name AS distributor_name
                  FROM 
                    movie
                  JOIN
                    movie_genre ON movie.id = movie_genre.id_movie
                  JOIN 
                    genre ON movie_genre.id_genre = genre.id
                  JOIN
                    distributor ON movie.id_distributor = distributor.id
                  ORDER BY movie.title ASC";
    
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}