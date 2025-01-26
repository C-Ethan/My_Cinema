<?php
require __DIR__ . '/../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);
        $sessionId = intval($data['sessionId']);

        $query = "DELETE FROM movie_schedule WHERE id = :sessionId";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->execute([':sessionId' => $sessionId]);

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}