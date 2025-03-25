<?php
// Connect to database using PDO
try {
    $db = new PDO('mysql:host=localhost;dbname=gestionhoteliere', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get hotel ID from AJAX request
    if (isset($_GET['hotel_id']) && is_numeric($_GET['hotel_id'])) {
        $hotel_id = intval($_GET['hotel_id']);
        
        // Fetch rooms belonging to the selected hotel
        $stmt = $db->prepare("SELECT room_id FROM chambre WHERE hotel_id = ?");
        $stmt->execute([$hotel_id]);

        // Generate options for the room select dropdown
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<option value='" . $row['room_id'] . "'>" . $row['room_id'] . "</option>";
        }
    }
} catch (PDOException $e) {
    echo "<option value=''>Error loading rooms: " . $e->getMessage() . "</option>";
}
?>
