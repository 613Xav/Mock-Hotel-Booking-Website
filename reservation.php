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
                <form action="assets/php/process-reservation.php" method="POST">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="client_address">Address:</label>
                    <input type="text" id="client_address" name="client_address" required>

                    <label for="nas">SIN (NAS):</label>
                    <input type="text" id="nas" name="nas" required>


                    <label for="phone">Phone Number:</label>
                    <input type="tel" id="phone" name="phone" required>

                    <label for="chain">Select Hotel:</label>
                    <select id="chain" name="chain" required>
                        <option value="">Choose a hotel</option>
                        <?php
                        // Connect to database using PDO
                        try {
                            $db = new PDO('mysql:host=localhost;dbname=gestionhoteliere', 'root', '');
                            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                            // Fetch hotels from the database
                            $query = $db->query("SELECT DISTINCT chain_id, nom FROM chainehoteliere");
                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row['chain_id'] . "'>" . $row['nom'] . "</option>";
                            }
                        } catch (PDOException $e) {
                            echo "<option value=''>Database error: " . $e->getMessage() . "</option>";
                        }
                        ?>
                    </select>

                    <label for="address">Select Hotel Address:</label>
                    <select id="address" name="address" required>
                        <option value="">Choose an address</option>
                    </select>


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

    <!-- AJAX to dynamically load rooms and addresses based on selected hotel -->
    <script>

        // Load addresses when chain is selected
        document.getElementById('chain').addEventListener('change', function () {
            var chainId = this.value;
            if (chainId) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'assets/php/get-addresses.php?chain_id=' + chainId, true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        document.getElementById('address').innerHTML = xhr.responseText;
                        document.getElementById('room').innerHTML = '<option value="">Choose a room</option>';
                    }
                };
                xhr.send();
            } else {
                document.getElementById('address').innerHTML = '<option value="">Choose an address</option>';
                document.getElementById('room').innerHTML = '<option value="">Choose a room</option>';
            }
        });

        //Load rooms when address is selected
        document.getElementById('address').addEventListener('change', function () {
            var hotelId = this.value;
            if (hotelId) {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'assets/php/get-rooms.php?hotel_id=' + hotelId, true);
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        document.getElementById('room').innerHTML = response.rooms;
                    }
                };
                xhr.send();
            } else {
                document.getElementById('room').innerHTML = '<option value="">Choose a room</option>';
            }
        });
    </script>
</body>
</html>
