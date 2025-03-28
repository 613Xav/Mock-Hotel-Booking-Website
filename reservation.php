<!DOCTYPE html>
<html>
<head>
    <title>Make a Reservation</title>
    <link rel="stylesheet" href="assets/css/main.css"> <!-- Correct path based on your template -->
    <link rel="stylesheet" href="assets/css/noscript.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <style>
        /* Add this to center the wrapper */
#wrapper {
    width: 80%; /* Or any width percentage you prefer */
    max-width: 1200px; /* Maximum width for large screens */
    margin: 0 auto; /* This centers the content */
    padding: 20px; /* Optional padding to add some space */
}

/* Optional: Center the header */
#header {
    text-align: center;
}

/* Optional: Center the form */
form {
    margin: 0 auto;
    width: 100%; /* Or a specific width like 500px */
}
    </style>
</head>
<body>

    <div id="wrapper">
        <header id="header">
            <h1>Make a Reservation</h1>
        </header>

        <div id="main">
            <section>

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
                        // Connect to database using PDO
                        try {
                            $db = new PDO('mysql:host=localhost;dbname=gestionhoteliere', 'root', '');
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            // Fetch hotels from the database
                            $query = $db->query("SELECT hotel.hotel_id, chainehoteliere.nom AS hotel_name FROM hotel JOIN chainehoteliere ON hotel.chain_id = chainehoteliere.chain_id");
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row['hotel_id'] . "'>" . $row['hotel_name'] . "</option>";
                            }
                        } catch (PDOException $e) {
                            echo "<option value=''>Database error: " . $e->getMessage() . "</option>";
                        }
                        ?>
                    </select>

                    <label for="address">Hotel Address:</label>
                    <input type="text" id="address" name="address" readonly>


                    <label for="room">Select Room:</label>
                    <select id="room" name="room" required>
                        <option value="">Choose a room</option>
                    </select>

                    <label for="checkin">Check-in Date:</label>
                    <input type="date" id="checkin" name="checkin" required>

                    <label for="checkout">Check-out Date:</label>
                    <input type="date" id="checkout" name="checkout" required>
                    <br>
                    <br>
                    <button type="submit" style="display: block; margin: 0 auto; text-align: center;">Confirm Reservation</button>
                </form>
            </section>
        </div>

        <footer id="footer">
            <p>&copy; 2025. All rights reserved.</p>
        </footer>
    </div>

    <!-- AJAX to dynamically load rooms based on selected hotel -->
    <script>
        document.getElementById('hotel').addEventListener('change', function () {
            var hotelId = this.value;
            if (hotelId) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'get-rooms.php?hotel_id=' + hotelId, true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        document.getElementById('room').innerHTML = response.rooms;
                        document.getElementById('address').value = response.address; // Set the address dynamically
                    }
                };
                xhr.send();
            } else {
                document.getElementById('room').innerHTML = '<option value="">Choose a room</option>';
                document.getElementById('address').value = ''; // Clear the address field
            }
        });
    </script>
</body>
</html>
