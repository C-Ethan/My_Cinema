<?php
require __DIR__ . '/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = intval($data['userId']);
    $currentSubscriptionId = intval($data['currentSubscriptionId']);
    $newSubscriptionId = intval($data['newSubscriptionId']);

    $subscriptionModel = new Subscription();

    // Delete current subscription
    if ($subscriptionModel->removeUserSubscription($userId, $currentSubscriptionId)) {
        // Add new subscription
        if ($subscriptionModel->addUserSubscription($userId, $newSubscriptionId)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Échec de l\'ajout du nouvel abonnement.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Échec de la suppression de l\'abonnement actuel.']);
    }
    exit;
}