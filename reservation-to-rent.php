<?php
// Database connection
$db = new PDO('mysql:host=localhost;dbname=gestionhoteliere', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Handle form submission to convert reservation to rental
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['convert_to_rental'])) {
    $reservation_id = intval($_POST['reservation_id']);
    
    try {
        $db->beginTransaction();
        
        // Get reservation details
        $stmt = $db->prepare("
            SELECT r.*, c.client_id, ch.room_id, r.starting_date, r.finishing_date
            FROM reservation r
            JOIN client c ON r.client_id = c.client_id
            JOIN chambre ch ON r.room_id = ch.room_id
            WHERE r.reservation_id = ?
        ");
        $stmt->execute([$reservation_id]);
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$reservation) {
            throw new Exception("Reservation not found");
        }

        // Get first employee (system user)
        $employee = $db->query("
            SELECT employee_id 
            FROM employe 
            LIMIT 1
        ")->fetch(PDO::FETCH_ASSOC);

        if (!$employee) {
            throw new Exception("System requires at least one employee account");
        }

        // Create rental record with system employee
        $stmt = $db->prepare("
            INSERT INTO location (
                reservation_id, client_id, room_id, employee_id,
                starting_date, finishing_date
            ) VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $reservation_id,
            $reservation['client_id'],
            $reservation['room_id'],
            $employee['employee_id'],
            $reservation['starting_date'],
            $reservation['finishing_date']
        ]);
        
        $db->commit();
        $success_message = "Reservation #$reservation_id converted to rental!";
    } catch (Exception $e) {
        $db->rollBack();
        $error_message = "Error converting reservation: " . $e->getMessage();
    }
}

// Fetch data for the page
try {
    // Get all active reservations that haven't been converted yet
    $reservations = $db->query("
        SELECT r.reservation_id, r.starting_date, r.finishing_date, r.prix,
            c.nom_complet AS client_name,
            ch.room_id, ch.capacite AS room_type,
            chain.nom AS chain_name
        FROM reservation r
        JOIN client c ON r.client_id = c.client_id
        JOIN chambre ch ON r.room_id = ch.room_id
        JOIN hotel h ON ch.hotel_id = h.hotel_id
        JOIN chainehoteliere chain ON h.chain_id = chain.chain_id
        WHERE (r.starting_date >= CURDATE() OR r.finishing_date >= CURDATE())
        AND NOT EXISTS (
            SELECT 1 FROM location l 
            WHERE l.reservation_id = r.reservation_id
        )
        ORDER BY r.starting_date ASC
    ")->fetchAll(PDO::FETCH_ASSOC);
    
    // Get all active rentals
    $rentals = $db->query("
        SELECT l.rental_id, l.starting_date, l.finishing_date,
            c.nom_complet AS client_name,
            l.room_id
        FROM location l
        JOIN client c ON l.client_id = c.client_id
        WHERE l.finishing_date >= CURDATE()
        ORDER BY l.starting_date ASC
    ")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Convert Reservations to Rentals</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/noscript.css">
    <link rel="stylesheet" href="assets/css/fontawesome-all.min.css">
    <style>
        #wrapper { width: 80%; max-width: 1200px; margin: 0 auto; padding: 20px; }
        #header { text-align: center; }
        form { margin: 0 auto; width: 100%; }
        .reservation-card, .rental-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; }
        .reservation-card.active { border-left: 4px solid #28a745; }
        .reservation-card.future { border-left: 4px solid #ffc107; }
        .reservation-card.past { border-left: 4px solid #6c757d; opacity: 0.7; }
        .badge { font-size: 0.8em; padding: 3px 6px; border-radius: 3px; }
        .badge-active { background-color: #28a745; color: white; }
        .badge-future { background-color: #ffc107; color: black; }
        .badge-past { background-color: #6c757d; color: white; }
        .section { margin-bottom: 30px; }
        .alert { padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; }
        .alert-success { color: #3c763d; background-color: #dff0d8; border-color: #d6e9c6; }
        .alert-danger { color: #a94442; background-color: #f2dede; border-color: #ebccd1; }
    </style>
</head>
<body>
    <div id="wrapper">
        <header id="header">
            <h1>Reservation to Rental Conversion</h1>
        </header>

        <div id="main">
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success_message) ?></div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>
            
            <div class="section">
                <h2>Active Reservations</h2>
                
                <?php if (empty($reservations)): ?>
                    <p>No active reservations found.</p>
                <?php else: ?>
                    <?php foreach ($reservations as $reservation): ?>
                        <?php
                        $startDate = new DateTime($reservation['starting_date']);
                        $endDate = new DateTime($reservation['finishing_date']);
                        $now = new DateTime();
                        
                        $statusClass = 'future';
                        $statusText = 'Upcoming';
                        
                        if ($now >= $startDate && $now <= $endDate) {
                            $statusClass = 'active';
                            $statusText = 'Active';
                        } elseif ($now > $endDate) {
                            $statusClass = 'past';
                            $statusText = 'Completed';
                        }
                        ?>
                        
                        <div class="reservation-card <?= $statusClass ?>">
                            <div class="d-flex justify-content-between">
                                <h3>Reservation #<?= htmlspecialchars($reservation['reservation_id']) ?></h3>
                                <span class="badge badge-<?= $statusClass ?>"><?= $statusText ?></span>
                            </div>
                            
                            <p>
                                <strong>Client:</strong> <?= htmlspecialchars($reservation['client_name']) ?><br>
                                <strong>Hotel Chain:</strong> <?= htmlspecialchars($reservation['chain_name'] ?? 'Not specified') ?><br>
                                <strong>Room:</strong> <?= htmlspecialchars($reservation['room_type']) ?> (ID: <?= htmlspecialchars($reservation['room_id']) ?>)<br>
                                <strong>Dates:</strong> <?= $startDate->format('Y-m-d') ?> to <?= $endDate->format('Y-m-d') ?><br>
                                <strong>Price:</strong> <?= htmlspecialchars($reservation['prix']) ?> €
                            </p>
                            
                            <?php if ($statusClass !== 'past'): ?>
                                <form method="POST" action="">
                                    <input type="hidden" name="reservation_id" value="<?= $reservation['reservation_id'] ?>">
                                    <button type="submit" name="convert_to_rental" class="btn btn-primary">
                                        Convert to Rental
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="section">
                <h2>Current Rentals</h2>
                
                <?php if (empty($rentals)): ?>
                    <p>No active rentals found.</p>
                <?php else: ?>
                    <?php foreach ($rentals as $rental): ?>
                        <div class="rental-card">
                            <h3>Rental #<?= htmlspecialchars($rental['rental_id']) ?></h3>
                            <p>
                                <strong>Client:</strong> <?= htmlspecialchars($rental['client_name']) ?><br>
                                <strong>Room ID:</strong> <?= htmlspecialchars($rental['room_id']) ?><br>
                                <strong>Dates:</strong> <?= (new DateTime($rental['starting_date']))->format('Y-m-d') ?> to <?= (new DateTime($rental['finishing_date']))->format('Y-m-d') ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <footer id="footer">
            <p>&copy; <?= date('Y') ?>. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>