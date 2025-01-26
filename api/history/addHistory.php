<?php
require __DIR__ . '/../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        $userId = intval($data['userId']);
        $movieId = intval($data['movieId']);
        $roomId = intval($data['roomId']);
        $movieDate = $data['movieDate'];

        if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $movieDate)) {
            echo json_encode(['success' => false, 'message' => 'Invalid date format.']);
            exit;
        }

        $year = intval(substr($movieDate, 0, 4));
        if ($year < 1900 || $year > 2100) {
            echo json_encode(['success' => false, 'message' => 'The year must be between 1900 and 2100.']);
            exit;
        }

        $historyModel = new History();

        if ($historyModel->addUserHistory($userId, $movieId, $roomId, $movieDate)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Adding history failed.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}