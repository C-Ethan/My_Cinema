<?php
class Member {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function searchMembers($lastnameSearch = '', $firstnameSearch = '', $limit = 20, $page = 1) {
        $offset = ($page - 1) * $limit;
        
        $query = "SELECT * 
                  FROM user";
    
        $conditions = [];
        $params = [];
    
        // Filtre par lastname
        if (!empty($lastnameSearch)) {
            $conditions[] = "lastname LIKE :lastnameSearch";
            $params[':lastnameSearch'] = "%$lastnameSearch%";
        }
    
        // Filtre par firstname
        if (!empty($firstnameSearch)) {
            $conditions[] = "firstname LIKE :firstnameSearch";
            $params[':firstnameSearch'] = "%$firstnameSearch%";
        }
    
        // Ajouter les conditions à la requête
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
    
    public function getTotalMembers($lastnameSearch = '', $firstnameSearch = '') {
        $query = "SELECT COUNT(*) as total 
                  FROM user";
    
        $conditions = [];
        $params = [];
    
        // Filtre par lastname
        if (!empty($lastnameSearch)) {
            $conditions[] = "lastname LIKE :lastnameSearch";
            $params[':lastnameSearch'] = "%$lastnameSearch%";
        }
    
        // Filtre par firstname
        if (!empty($firstnameSearch)) {
            $conditions[] = "firstname LIKE :firstnameSearch";
            $params[':firstnameSearch'] = "%$firstnameSearch%";
        }
    
        // Ajouter les conditions à la requête
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