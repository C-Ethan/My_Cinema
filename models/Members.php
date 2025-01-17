<?php
class Member {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function searchMembers($search = '', $searchType = 'all', $limit = 20, $page = 1) {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT * 
                  FROM user";

        $conditions = [];
        $params = [];

        if (!empty($search)) {
            if ($searchType === 'lastname') {
                $conditions[] = "lastname LIKE :search";
            } elseif ($searchType === 'email') {
                $conditions[] = "email LIKE :search";
            } else {
                $conditions[] = "(lastname LIKE :search OR email LIKE :search)";
            }
            $params[':search'] = "%$search%";
        }

        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $query .= " ORDER BY id ASC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public function getTotalMembers($search = '', $searchType = 'all') {
        $query = "SELECT COUNT(*) as total FROM user";

        $conditions = [];
        $params = [];

        if (!empty($search)) {
            if ($searchType === 'lastname') {
                $conditions[] = "lastname LIKE :search";
            } elseif ($searchType === 'email') {
                $conditions[] = "email LIKE :search";
            } else {
                $conditions[] = "(lastname LIKE :search OR email LIKE :search)";
            }
            $params[':search'] = "%$search%";
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
}