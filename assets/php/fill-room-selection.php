<?php
require_once 'database.php';
include_once 'room-select-fillers.php';

// Assume we expect a hotel ID to filter rooms
if (isset($_POST['hotelId'])) {
    $hotelId = $_POST['hotelId'];
    // You might have a function that gets rooms by hotel; if not, create one.
    $rooms = getRoomsByHotel($hotelId);
    header('Content-Type: application/json');
    echo json_encode($rooms);
    exit;
} else {
    echo json_encode([]);
    exit;
}
?>
