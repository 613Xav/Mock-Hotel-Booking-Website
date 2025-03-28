<?php
// Connect to database using PDO
try {
    $db = new PDO('mysql:host=localhost;dbname=gestionhoteliere', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get hotel ID from AJAX request
    if (isset($_GET['hotel_id']) && is_numeric($_GET['hotel_id'])) {
        $hotel_id = intval($_GET['hotel_id']);
        
        // Fetch hotel address and rooms belonging to the selected hotel
        $stmt = $db->prepare("SELECT hotel.adresse, chambre.room_id FROM hotel JOIN chambre ON hotel.hotel_id = chambre.hotel_id WHERE hotel.hotel_id = ?");
        $stmt->execute([$hotel_id]);

        // Initialize variables for rooms and address
        $rooms = "<option value=''>Choose a room</option>";
        $address = "";

        // Fetch the data for the hotel and rooms
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Set the address once
            if (empty($address)) {
                $address = $row['adresse'];
            }

            // Add room option
            $rooms .= "<option value='" . $row['room_id'] . "'>" . $row['room_id'] . "</option>";
        }

        // Return the rooms and address as JSON
        echo json_encode(['rooms' => $rooms, 'address' => $address]);


    } else {
            echo json_encode(['rooms' => '', 'address' => 'Hotel not found']);
        }

} catch (PDOException $e) {
echo json_encode(['rooms' => '', 'address' => 'Error loading rooms: ' . $e->getMessage()]);
}

?>

