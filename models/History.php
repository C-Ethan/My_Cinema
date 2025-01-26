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
                    user.id = :historyusersearch
                  ORDER BY 
                    movie_schedule.date_begin DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['historyusersearch' => $userId]);
        $result = $stmt->fetchAll();
    
        return $result;
    }

    public function addUserHistory($userId, $movieId, $roomId, $movieDate) {
      $formattedDate = date('Y-m-d H:i:s', strtotime($movieDate));
  
      $query = "INSERT INTO movie_schedule (id_movie, id_room, date_begin) 
                VALUES (:movie_id, :room_id, :movie_date)";
      $stmt = $this->db->prepare($query);
      $stmt->execute([
          ':movie_id' => $movieId,
          ':room_id' => $roomId,
          ':movie_date' => $formattedDate
      ]);
  
      $sessionId = $this->db->lastInsertId();
  
      $stmt = $this->db->prepare("SELECT id FROM membership WHERE id_user = :user_id");
      $stmt->execute([':user_id' => $userId]);
      $membership = $stmt->fetch(PDO::FETCH_ASSOC);
  
      if (!$membership) {
          throw new Exception("The user does not have a valid subscription.");
      }
  
      $stmt = $this->db->prepare("INSERT INTO membership_log (id_membership, id_session) 
                                  VALUES (:membership_id, :session_id)");
      return $stmt->execute([
          ':membership_id' => $membership['id'],
          ':session_id' => $sessionId
      ]);
  }
}