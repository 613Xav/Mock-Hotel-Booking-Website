<?php
require_once 'database.php';
include_once 'room-select-fillers.php';

// Get inputs and convert to numbers if possible
$hotelId = isset($_POST['hotelId']) ? $_POST['hotelId'] : null;
$minPrice = (isset($_POST['minPrice']) && $_POST['minPrice'] !== '') ? floatval($_POST['minPrice']) : null;
$maxPrice = (isset($_POST['maxPrice']) && $_POST['maxPrice'] !== '') ? floatval($_POST['maxPrice']) : null;

// Build SQL query conditionally
$sql = "SELECT room_id, prix, capacite, vue_mer, vue_montagne, extensible FROM chambre WHERE 1=1";
$params = [];

if ($hotelId) {
    $sql .= " AND hotel_id = :hotelId";
    $params['hotelId'] = $hotelId;
}

if ($minPrice !== null && $maxPrice !== null) {
    $sql .= " AND prix BETWEEN :minPrice AND :maxPrice";
    $params['minPrice'] = $minPrice;
    $params['maxPrice'] = $maxPrice;
} elseif ($minPrice !== null) {
    $sql .= " AND prix >= :minPrice";
    $params['minPrice'] = $minPrice;
} elseif ($maxPrice !== null) {
    $sql .= " AND prix <= :maxPrice";
    $params['maxPrice'] = $maxPrice;
}

$stmt = $db->prepare($sql);
$stmt->execute($params);
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($rooms);
?>
