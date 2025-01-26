<?php
require __DIR__ . '/../../autoload.php';

$movieModel = new Movie();
$sessions = $movieModel->getMovieSessions();

header('Content-Type: application/json');
echo json_encode($sessions);
exit;