<?php
require __DIR__ . '/autoload.php';

if (isset($_GET['userId'])) {
    $userId = intval($_GET['userId']);
    $subscriptionModel = new Subscription();
    $subscriptions = $subscriptionModel->getUserSubscriptions($userId);

    header('Content-Type: application/json');
    echo json_encode($subscriptions);
    exit;
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User ID is missing']);
    exit;
}