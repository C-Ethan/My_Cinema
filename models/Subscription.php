<?php
class Subscription {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllSubscription() {
        $query = "SELECT 
                    id, 
                    name 
                  FROM 
                    subscription
                  ORDER BY name ASC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll();
    }

    public function getUserSubscriptions($userId) {
        $query = "SELECT 
                    subscription.id, 
                    subscription.name 
                  FROM 
                    subscription
                  JOIN 
                    membership ON subscription.id = membership.id_subscription
                  WHERE 
                    membership.id_user = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function addUserSubscription($userId, $subscriptionId) {
        // Check if subscription already exist
        $query = "SELECT 
                    * 
                  FROM 
                    membership 
                  WHERE 
                    id_user = :userId 
                  AND 
                    id_subscription = :subscriptionId";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':subscriptionId', $subscriptionId, PDO::PARAM_INT);
        $stmt->execute();
    
        if ($stmt->rowCount() > 0) {
            return false; // Subscription already exist
        }
    
        // Add subscription
        $query = "INSERT INTO 
                    membership (id_user, id_subscription) 
                  VALUES 
                    (:userId, :subscriptionId)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':subscriptionId', $subscriptionId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function removeUserSubscription($userId, $subscriptionId) {
        $query = "DELETE FROM 
                    membership 
                  WHERE 
                    id_user = :userId 
                  AND 
                    id_subscription = :subscriptionId";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':subscriptionId', $subscriptionId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
