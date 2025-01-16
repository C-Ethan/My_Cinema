<?php
class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance(); // Suppose que vous avez une classe Database similaire
    }

    // Récupérer les utilisateurs avec pagination
    public function getUsers($limit = 20, $page = 1, $search = '') {
        $offset = ($page - 1) * $limit;

        $query = "SELECT id, name, email FROM user";
        
        // Ajouter une clause WHERE si une recherche est fournie
        if (!empty($search)) {
            $query .= " WHERE name LIKE :search OR email LIKE :search";
        }
        
        $query .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($query);

        if (!empty($search)) {
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Compter le nombre total d'utilisateurs
    public function getTotalUsers($search = '') {
        $query = "SELECT COUNT(id) as total FROM user";

        if (!empty($search)) {
            $query .= " WHERE name LIKE :search OR email LIKE :search";
        }

        $stmt = $this->db->prepare($query);

        if (!empty($search)) {
            $searchTerm = "%$search%";
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetch()['total'];
    }
}