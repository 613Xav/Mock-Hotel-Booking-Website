<?php
require_once 'database.php';
include_once 'room-select-fillers.php';

if (isset($_POST['chainId'])) {
    $chainId = $_POST['chainId'];
    $hotelFiller = getHotels($chainId);
    echo json_encode($hotelFiller);
}
?>
