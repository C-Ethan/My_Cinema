<?php
class History {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getUserHistory($userId) {
        $query = "SELECT 
                    movie.title, 
                    room.name AS room_name, 
                    movie_schedule.date_begin AS movie_begin
                  FROM 
                    movie 
                  LEFT JOIN 
                    movie_schedule ON movie.id = movie_schedule.id_movie
                  LEFT JOIN 
                    membership_log ON movie_schedule.id = membership_log.id_session 
                  LEFT JOIN 
                    membership ON membership_log.id_membership = membership.id 
                  LEFT JOIN 
                    user ON membership.id_user = user.id 
                  LEFT JOIN 
                    room ON movie_schedule.id_room = room.id
                  WHERE 
                    user.id = :historyusersearch";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['historyusersearch' => $userId]);
        $result = $stmt->fetchAll();
    
        return $result;
    }
}