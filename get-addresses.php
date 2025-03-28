<?php
// Connect to database using PDO
try {
    $db = new PDO('mysql:host=localhost;dbname=gestionhoteliere', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get chain ID from AJAX request
    if (isset($_GET['chain_id']) && is_numeric($_GET['chain_id'])) {
        $chain_id = intval($_GET['chain_id']);

        // Fetch addresses for the selected chain
        $stmt = $db->prepare("SELECT hotel_id, adresse FROM hotel WHERE chain_id = ?");
        $stmt->execute([$chain_id]);

        // Populate address dropdown
        $options = "<option value=''>Choose an address</option>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $options .= "<option value='" . $row['hotel_id'] . "'>" . $row['adresse'] . "</option>";
        }
        echo $options;
    } else {
        echo "<option value=''>No addresses found</option>";
    }
} catch (PDOException $e) {
    echo "<option value=''>Error: " . $e->getMessage() . "</option>";
}
?>
