<?php
require __DIR__ . '/../../autoload.php';

if (isset($_GET['userId'])) {
    $userId = intval($_GET['userId']);

    $historyModel = new History();
    $userHistory = $historyModel->getUserHistory($userId);

    header('Content-Type: application/json');
    echo json_encode($userHistory);
    exit;
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'User ID is missing']);
    exit;
}