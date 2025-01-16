<?php
class Genre {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAllGenres() {
        $query = "SELECT 
                    id, 
                    name 
                  FROM 
                    genre 
                  ORDER BY name ASC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }
}