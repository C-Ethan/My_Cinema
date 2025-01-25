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

    public function getUserSubscription($userId) {
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

    public function modifySubscription($userId, $currentSubscriptionId, $newSubscriptionId) {
      if ($currentSubscriptionId === $newSubscriptionId) {
          return ['success' => false, 'message' => 'You already have this subscription.'];
      }
  
      if ($this->removeUserSubscription($userId, $currentSubscriptionId)) {
          if ($this->addUserSubscription($userId, $newSubscriptionId)) {
              return ['success' => true, 'message' => 'Subscription modified successfully.'];
          } else {
              return ['success' => false, 'message' => 'Failed to add new subscription.'];
          }
      } else {
          return ['success' => false, 'message' => 'Failed to delete current subscription.'];
      }
  }
}