<?php
require __DIR__ . '/../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = intval($data['userId']);
    $currentSubscriptionId = intval($data['currentSubscriptionId']);
    $newSubscriptionId = intval($data['newSubscriptionId']);

    $subscriptionModel = new Subscription();
    $result = $subscriptionModel->modifySubscription($userId, $currentSubscriptionId, $newSubscriptionId);

    header('Content-Type: application/json');
    echo json_encode($result);
    exit;
}