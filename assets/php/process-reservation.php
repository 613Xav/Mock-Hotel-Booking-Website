<?php
// Connect to database using PDO
try {
    $db = new PDO('mysql:host=localhost;dbname=gestionhoteliere', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get form data
    $name = $_POST['name'];
    $client_address = $_POST['client_address'];
    $nas = $_POST['nas'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $room_id = $_POST['room'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    // Check if the client already exists based on NAS
    $stmt = $db->prepare("SELECT client_id FROM Client WHERE NAS = ?");
    $stmt->execute([$nas]);
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($client) {
        // Client exists, get the client_id
        $client_id = $client['client_id'];
    } else {
        // Insert new client
        $stmt = $db->prepare("INSERT INTO Client (nom_complet, adresse, NAS) VALUES (?, ?, ?)");
        $stmt->execute([$name, $client_address, $nas]);

        // Get the new client ID
        $client_id = $db->lastInsertId();
    }

    // Get room price from Chambre table
    $stmt = $db->prepare("SELECT prix FROM Chambre WHERE room_id = ?");
    $stmt->execute([$room_id]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($room) {
        $prix = $room['prix'];

        // Insert the reservation
        $stmt = $db->prepare("INSERT INTO Reservation (client_id, room_id, starting_date, finishing_date, prix) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$client_id, $room_id, $checkin, $checkout, $prix]);

        echo "<script>alert('Reservation successfully made!'); window.location.href='reservation.php';</script>";
    } else {
        echo "<script>alert('Error: Room not found.'); window.location.href='reservation.php';</script>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
