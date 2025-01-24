<?php
class Member {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function searchMembers($lastnameSearch = '', $firstnameSearch = '', $limit = 20, $page = 1) {
        $offset = ($page - 1) * $limit;
    
        $query = "SELECT 
                    user.id,
                    user.lastname,
                    user.firstname,
                    user.email,
                    GROUP_CONCAT(DISTINCT subscription.name SEPARATOR ', ') AS subscriptions
                  FROM 
                    user
                  LEFT JOIN
                    membership ON user.id = membership.id_user
                  LEFT JOIN
                    subscription ON membership.id_subscription = subscription.id";
    
        $conditions = [];
        $params = [];
    
        if (!empty($lastnameSearch)) {
            $conditions[] = "user.lastname LIKE :lastnameSearch";
            $params[':lastnameSearch'] = "%$lastnameSearch%";
        }
    
        if (!empty($firstnameSearch)) {
            $conditions[] = "user.firstname LIKE :firstnameSearch";
            $params[':firstnameSearch'] = "%$firstnameSearch%";
        }
    
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }
    
        $query .= " GROUP BY user.id";
    
        $query .= " ORDER BY user.id ASC LIMIT :limit OFFSET :offset";
    
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
        $query = "SELECT COUNT(DISTINCT user.id) as total 
                  FROM user
                  LEFT JOIN
                    membership ON user.id = membership.id_user
                  LEFT JOIN
                    subscription ON membership.id_subscription = subscription.id";
    
        $conditions = [];
        $params = [];
    
        if (!empty($lastnameSearch)) {
            $conditions[] = "user.lastname LIKE :lastnameSearch";
            $params[':lastnameSearch'] = "%$lastnameSearch%";
        }
    
        if (!empty($firstnameSearch)) {
            $conditions[] = "user.firstname LIKE :firstnameSearch";
            $params[':firstnameSearch'] = "%$firstnameSearch%";
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