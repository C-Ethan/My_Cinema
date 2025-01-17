<?php
class Distributor {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAllDistributors() {
        $query = "SELECT 
                    id, 
                    name 
                  FROM 
                    distributor
                  ORDER BY name ASC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }
}