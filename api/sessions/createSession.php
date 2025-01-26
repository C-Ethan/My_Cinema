<?php
require __DIR__ . '/../../autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $data = json_decode(file_get_contents('php://input'), true);

        $movieId = intval($data['movieId']);
        $roomId = intval($data['roomId']);
        $sessionDate = $data['sessionDate'];

        if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $sessionDate)) {
            echo json_encode(['success' => false, 'message' => 'Invalid date format.']);
            exit;
        }

        $formattedDate = date('Y-m-d H:i:s', strtotime($sessionDate));

        $query = "INSERT INTO movie_schedule (id_movie, id_room, date_begin) VALUES (:movieId, :roomId, :sessionDate)";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->execute([
            ':movieId' => $movieId,
            ':roomId' => $roomId,
            ':sessionDate' => $formattedDate
        ]);

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}