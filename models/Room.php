<?php
class Room {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAllRooms() {
        $query = "SELECT 
                    id,
                    name
                  FROM 
                    room
                  ORDER BY name ASC";
    
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $rooms;
    }
}