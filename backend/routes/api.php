<?php

require_once __DIR__ . '/../config/database.php';
require_once  __DIR__ . '/../controllers/SeatControllers.php';

$db = new Database();
$conn = $db->connect();

$controller = new SeatController($conn);

$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'GET') {
    $controller -> getSeats();
}

if ($method == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $controller -> toggleSeat($data);
}

?>