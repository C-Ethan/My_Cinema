<?php
require __DIR__ . '/../../autoload.php';

if (isset($_GET['userId'])) {
    $userId = intval($_GET['userId']);
    $subscriptionModel = new Subscription();

    $userSubscriptions = $subscriptionModel->getUserSubscription($userId);
    $allSubscriptions = $subscriptionModel->getAllSubscription();

    header('Content-Type: application/json');
    echo json_encode([
        'userSubscriptions' => $userSubscriptions,
        'allSubscriptions' => $allSubscriptions
    ]);
    exit;
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User ID is missing']);
    exit;
}