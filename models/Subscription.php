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
        $query = "INSERT INTO membership (id_user, id_subscription) 
                  VALUES (:userId, :subscriptionId)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':subscriptionId', $subscriptionId, PDO::PARAM_INT);
        return $stmt->execute();
    }

      public function deleteUserHistory($userId) {
        try {
            $query = "DELETE membership_log 
                      FROM membership_log
                      JOIN membership ON membership_log.id_membership = membership.id
                      WHERE membership.id_user = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':user_id' => $userId]);

            $query = "DELETE movie_schedule
                      FROM movie_schedule
                      JOIN membership_log ON movie_schedule.id = membership_log.id_session
                      JOIN membership ON membership_log.id_membership = membership.id
                      WHERE membership.id_user = :user_id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':user_id' => $userId]);

            return true;
        } catch (Exception $e) {
            error_log("Error deleting user history: " . $e->getMessage());
            return false;
        }
    }

    public function removeUserSubscription($userId, $subscriptionId) {
        try {
            $this->deleteUserHistory($userId);

            $query = "DELETE FROM membership 
                      WHERE id_user = :userId 
                      AND id_subscription = :subscriptionId";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':subscriptionId', $subscriptionId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error removing user subscription: " . $e->getMessage());
            return false;
        }
    }

    public function updateUserSubscription($userId, $newSubscriptionId) {
        try {
            $query = "UPDATE membership 
                      SET id_subscription = :newSubscriptionId
                      WHERE id_user = :userId";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':newSubscriptionId', $newSubscriptionId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error updating user subscription: " . $e->getMessage());
            return false;
        }
    }

    public function modifySubscription($userId, $currentSubscriptionId, $newSubscriptionId) {
        if ($currentSubscriptionId === $newSubscriptionId) {
            return ['success' => false, 'message' => 'You already have this subscription.'];
        }

        if ($this->updateUserSubscription($userId, $newSubscriptionId)) {
            return ['success' => true, 'message' => 'Subscription modified successfully.'];
        } else {
            return ['success' => false, 'message' => 'Failed to update subscription.'];
        }
    }
}