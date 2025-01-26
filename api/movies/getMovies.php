<?php
require __DIR__ . '/../../autoload.php';

$movieModel = new Movie();
$movies = $movieModel->getAllMovies();

header('Content-Type: application/json');
echo json_encode($movies);
exit;