<?php
// Include database connection
include 'assets/php/database.php';

// Get the selected hotel ID
$hotel_id = $_GET['hotel_id'];

try {
    // Fetch rooms for the selected hotel
    $stmt = $db->prepare("SELECT room_id, room_name FROM chambre WHERE hotel_id = :hotel_id");
    $stmt->execute([':hotel_id' => $hotel_id]);

    $output = "<option value=''>Choose a room</option>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $output .= "<option value='" . $row['room_id'] . "'>" . $row['room_name'] . "</option>";
    }
    echo $output;
} catch (PDOException $error) {
    echo "Error fetching rooms.";
}
?>
