<?php
require __DIR__ . '/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = intval($data['userId']);
    $subscriptionId = intval($data['subscriptionId']);

    $subscriptionModel = new Subscription();

    $existingSubscriptions = $subscriptionModel->getUserSubscriptions($userId);
    if (count($existingSubscriptions) > 0) {
        echo json_encode(['success' => false, 'message' => 'L\'utilisateur ne peut avoir qu\'un seul abonnement.']);
        exit;
    }

    if ($subscriptionModel->addUserSubscription($userId, $subscriptionId)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Échec de l\'ajout de l\'abonnement.']);
    }
    exit;
}