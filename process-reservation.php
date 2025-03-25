<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $hotel_id = intval($_POST['hotel']);
    $room_id = intval($_POST['room']);
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    // Database connection using PDO
    try {
        $db = new PDO('mysql:host=localhost;dbname=gestionhoteliere', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch the price for the selected room
        $stmt = $db->prepare("SELECT prix FROM chambre WHERE room_id = ?");
        $stmt->execute([$room_id]);
        $room = $stmt->fetch(PDO::FETCH_ASSOC);

        // If room doesn't exist, throw an error
        if (!$room) {
            echo "Error: Room not found.";
            exit;
        }
        
        $prix = $room['prix'];
        
        // Set the current date as the date created
        $date_created = date('Y-m-d H:i:s');

        // Insert reservation into the reservation table
        $stmt = $db->prepare("INSERT INTO reservation (client_id, room_id, starting_date, finishing_date, date_created, prix) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$client_id, $room_id, $checkin, $checkout, $date_created, $prix]);

        echo "Reservation successful!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
