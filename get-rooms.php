<?php
// Connect to database using PDO
try {
    $db = new PDO('mysql:host=localhost;dbname=gestionhoteliere', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get hotel ID from AJAX request
    if (isset($_GET['hotel_id']) && is_numeric($_GET['hotel_id'])) {
        $hotel_id = intval($_GET['hotel_id']);
        
        // Fetch hotel address and rooms belonging to the selected hotel
        $stmt = $db->prepare("SELECT room_id FROM chambre WHERE hotel_id = ?");
        $stmt->execute([$hotel_id]);

        // Initialize variables for rooms
        $rooms = "<option value=''>Choose a room</option>";

        // Fetch rooms and add them as options
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Add room option
            $rooms .= "<option value='" . $row['room_id'] . "'>Room " . $row['room_id'] . "</option>";
        }

        // Return the rooms as JSON
        echo json_encode(['rooms' => $rooms]);

    } else {
            echo json_encode(['rooms' => '<option value="">No rooms found</option>']);
        }

} catch (PDOException $e) {
echo json_encode(['rooms' => '<option value="">Error loading rooms: ' . $e->getMessage() . '</option>']);
}

?>

