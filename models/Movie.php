<?php
class Movie {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function searchMovies($search = '', $selectedGenre = null, $searchType = 'all', $limit = 20, $page = 1) {
        $offset = ($page - 1) * $limit;
        
        if (!empty($search)) {
            $query = "SELECT
                        movie.*,
                        movie_genre.id_genre,
                        genre.name AS 'genre'
                      FROM 
                        movie
                      JOIN
                        movie_genre ON movie.id = movie_genre.id_movie
                      JOIN 
                        genre ON movie_genre.id_genre = genre.id
                      WHERE ";

            // Modifier la clause WHERE selon le type de recherche
            if ($searchType === 'title') {
                $query .= "movie.title LIKE :search";
            } elseif ($searchType === 'director') {
                $query .= "movie.director LIKE :search";
            } else {
                $query .= "(movie.title LIKE :search OR movie.director LIKE :search)";
            }

            if ($selectedGenre) {
                $query .= " AND genre.id = :genre";
            }

            $query .= " LIMIT :limit OFFSET :offset";

            $stmt = $this->db->prepare($query);
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm);

            if ($selectedGenre) {
                $stmt->bindParam(':genre', $selectedGenre, PDO::PARAM_INT);
            }
        } else {
            $query = "SELECT
                        movie.title,
                        movie.director,
                        movie_genre.id_genre,
                        genre.name AS 'genre'
                      FROM 
                        movie
                      JOIN
                        movie_genre ON movie.id = movie_genre.id_movie
                      JOIN 
                        genre ON movie_genre.id_genre = genre.id";

            if ($selectedGenre) {
                $query .= " WHERE genre.id = :genre";
            }

            $query .= " LIMIT :limit OFFSET :offset";
            $stmt = $this->db->prepare($query);

            if ($selectedGenre) {
                $stmt->bindParam(':genre', $selectedGenre, PDO::PARAM_INT);
            }
        }
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getTotalMovies($search = '', $selectedGenre = null, $searchType = 'all') {
        if (!empty($search)) {
            $query = "SELECT COUNT(movie.id) as total FROM 
                        movie
                      JOIN
                        movie_genre ON movie.id = movie_genre.id_movie
                      JOIN 
                        genre ON movie_genre.id_genre = genre.id
                      WHERE ";

            // Modifier la clause WHERE selon le type de recherche
            if ($searchType === 'title') {
                $query .= "movie.title LIKE :search";
            } elseif ($searchType === 'director') {
                $query .= "movie.director LIKE :search";
            } else {
                $query .= "(movie.title LIKE :search OR movie.director LIKE :search)";
            }

            if ($selectedGenre) {
                $query .= " AND genre.id = :genre";
            }

            $stmt = $this->db->prepare($query);
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm);

            if ($selectedGenre) {
                $stmt->bindParam(':genre', $selectedGenre, PDO::PARAM_INT);
            }
        } else {
            $query = "SELECT COUNT(movie.id) as total FROM 
                        movie
                      JOIN
                        movie_genre ON movie.id = movie_genre.id_movie
                      JOIN 
                        genre ON movie_genre.id_genre = genre.id";

            if ($selectedGenre) {
                $query .= " WHERE genre.id = :genre";
            }

            $stmt = $this->db->prepare($query);

            if ($selectedGenre) {
                $stmt->bindParam(':genre', $selectedGenre, PDO::PARAM_INT);
            }
        }
        
        $stmt->execute();
        return $stmt->fetch()['total'];
    }
}