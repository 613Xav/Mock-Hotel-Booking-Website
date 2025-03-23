<?php
// Include database connection using PDO
include 'assets/php/database.php';

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$hotel_id = $_POST['hotel'];
$room_id = $_POST['room'];
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];

try {
    // Insert reservation into database
    $stmt = $db->prepare("INSERT INTO reservations (name, email, phone, hotel_id, room_id, checkin, checkout)
                          VALUES (:name, :email, :phone, :hotel_id, :room_id, :checkin, :checkout)");
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => $phone,
        ':hotel_id' => $hotel_id,
        ':room_id' => $room_id,
        ':checkin' => $checkin,
        ':checkout' => $checkout
    ]);

    echo "Reservation successful!";
} catch (PDOException $error) {
    echo "Error: " . $error->getMessage();
}
?>
