<!DOCTYPE html>
<html>
<head>
    <title>Make a Reservation</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css"> <!-- Link to CSS for styling -->
</head>
<body>

    <h2>Make a Reservation</h2>

    <!-- Reservation Form -->
    <form action="process-reservation.php" method="POST">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required>

        <label for="hotel">Select Hotel:</label>
        <select id="hotel" name="hotel" required>
            <option value="">Choose a hotel</option>
            <?php
            // Include the database connection using PDO
            include 'assets/php/database.php';
            
            // Fetch hotels from the database
            $query = $db->query("SELECT hotel_id, name FROM hotel");
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select>

        <label for="room">Select Room:</label>
        <select id="room" name="room" required>
            <option value="">Choose a room</option>
        </select>

        <label for="checkin">Check-in Date:</label>
        <input type="date" id="checkin" name="checkin" required>

        <label for="checkout">Check-out Date:</label>
        <input type="date" id="checkout" name="checkout" required>

        <button type="submit">Confirm Reservation</button>
    </form>

    <script>
        // AJAX to dynamically load rooms based on selected hotel
        document.getElementById('hotel').addEventListener('change', function() {
            var hotelId = this.value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'get-rooms.php?hotel_id=' + hotelId, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    document.getElementById('room').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        });
    </script>
</body>
</html>
