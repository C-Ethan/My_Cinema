<?php
require __DIR__ . '/../../autoload.php';

$roomModel = new Room();
$rooms = $roomModel->getAllRooms();

header('Content-Type: application/json');
echo json_encode($rooms);
exit;