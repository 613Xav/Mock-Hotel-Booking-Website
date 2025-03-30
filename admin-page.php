<?php
require_once "assets/php/database.php";
$conn = mysqli_connect("localhost", "root", "", "GestionHoteliere");

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}

// Gérer les actions Ajouter, Modifier et Supprimer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ajouter un Employé
    if (isset($_POST['addEmployee'])) {
        $hotel_id = $_POST['hotel_id'];
        $nom_complet = $_POST['nom_complet'];
        $adresse = $_POST['adresse'];
        $NAS = $_POST['NAS'];
        $poste = $_POST['poste'];
        $sql = "INSERT INTO Employe (hotel_id, nom_complet, adresse, NAS, poste) 
                VALUES ('$hotel_id', '$nom_complet', '$adresse', '$NAS', '$poste')";
        $conn->query($sql);
    }

    // Ajouter un Client
    if (isset($_POST['addClient'])) {
        $nom_complet = $_POST['nom_complet'];
        $adresse = $_POST['adresse'];
        $NAS = $_POST['NAS'];
        $sql = "INSERT INTO Client (nom_complet, adresse, NAS) 
                VALUES ('$nom_complet', '$adresse', '$NAS')";
        $conn->query($sql);
    }

    // Ajouter une Chambre
    if (isset($_POST['addRoom'])) {
        $hotel_id = $_POST['hotel_id'];
        $prix = $_POST['prix'];
        $capacite = $_POST['capacite'];
        $vue_mer = isset($_POST['vue_mer']) ? 1 : 0;
        $vue_montagne = isset($_POST['vue_montagne']) ? 1 : 0;
        $extensible = isset($_POST['extensible']) ? 1 : 0;
        $sql = "INSERT INTO Chambre (hotel_id, prix, capacite, vue_mer, vue_montagne, extensible) 
                VALUES ('$hotel_id', '$prix', '$capacite', '$vue_mer', '$vue_montagne', '$extensible')";
        $conn->query($sql);
    }

    // Ajouter un Hôtel
    if (isset($_POST['addHotel'])) {
        $chain_id = $_POST['chain_id'];
        $adresse = $_POST['adresse'];
        $nb_chambres = $_POST['nb_chambres'];
        $classement = $_POST['classement'];
        $email_contact = $_POST['email_contact'];
        $telephone_contact = $_POST['telephone_contact'];
        $sql = "INSERT INTO Hotel (chain_id, adresse, nb_chambres, classement, email_contact, telephone_contact) 
                VALUES ('$chain_id', '$adresse', '$nb_chambres', '$classement', '$email_contact', '$telephone_contact')";
        $conn->query($sql);
    }

    // Supprimer un Employé
    if (isset($_POST['deleteEmployee'])) {
        $employee_id = $_POST['employee_id'];
        $sql = "DELETE FROM Employe WHERE employee_id='$employee_id'";
        $conn->query($sql);
    }

    // Supprimer un Client
    if (isset($_POST['deleteClient'])) {
        $client_id = $_POST['client_id'];
        $sql = "DELETE FROM Client WHERE client_id='$client_id'";
        $conn->query($sql);
    }

    // Supprimer une Chambre
    if (isset($_POST['deleteRoom'])) {
        $room_id = $_POST['room_id'];
        $sql = "DELETE FROM Chambre WHERE room_id='$room_id'";
        $conn->query($sql);
    }

    // Supprimer un Hôtel
    if (isset($_POST['deleteHotel'])) {
        $hotel_id = $_POST['hotel_id'];
        $sql = "DELETE FROM Hotel WHERE hotel_id='$hotel_id'";
        $conn->query($sql);
    }

    // Modifier un Employé
    if (isset($_POST['modifyEmployee'])) {
        $employee_id = $_POST['employee_id'];
        $hotel_id = $_POST['hotel_id'];
        $nom_complet = $_POST['nom_complet'];
        $adresse = $_POST['adresse'];
        $NAS = $_POST['NAS'];
        $poste = $_POST['poste'];
        $sql = "UPDATE Employe SET hotel_id='$hotel_id', nom_complet='$nom_complet', adresse='$adresse', NAS='$NAS', poste='$poste' WHERE employee_id='$employee_id'";
        $conn->query($sql);
    }

    // Modifier un Client
    if (isset($_POST['modifyClient'])) {
        $client_id = $_POST['client_id'];
        $nom_complet = $_POST['nom_complet'];
        $adresse = $_POST['adresse'];
        $NAS = $_POST['NAS'];
        $sql = "UPDATE Client SET nom_complet='$nom_complet', adresse='$adresse', NAS='$NAS' WHERE client_id='$client_id'";
        $conn->query($sql);
    }

    // Modifier une Chambre
    if (isset($_POST['modifyRoom'])) {
        $room_id = $_POST['room_id'];
        $hotel_id = $_POST['hotel_id'];
        $prix = $_POST['prix'];
        $capacite = $_POST['capacite'];
        $vue_mer = isset($_POST['vue_mer']) ? 1 : 0;
        $vue_montagne = isset($_POST['vue_montagne']) ? 1 : 0;
        $extensible = isset($_POST['extensible']) ? 1 : 0;
        $sql = "UPDATE Chambre SET hotel_id='$hotel_id', prix='$prix', capacite='$capacite', vue_mer='$vue_mer', vue_montagne='$vue_montagne', extensible='$extensible' WHERE room_id='$room_id'";
        $conn->query($sql);
    }

    // Modifier un Hôtel
    if (isset($_POST['modifyHotel'])) {
        $hotel_id = $_POST['hotel_id'];
        $chain_id = $_POST['chain_id'];
        $adresse = $_POST['adresse'];
        $nb_chambres = $_POST['nb_chambres'];
        $classement = $_POST['classement'];
        $email_contact = $_POST['email_contact'];
        $telephone_contact = $_POST['telephone_contact'];
        $sql = "UPDATE Hotel SET chain_id='$chain_id', adresse='$adresse', nb_chambres='$nb_chambres', classement='$classement', email_contact='$email_contact', telephone_contact='$telephone_contact' WHERE hotel_id='$hotel_id'";
        $conn->query($sql);
    }
}

// Récupérer les tables pour affichage
$employees_sql = "SELECT * FROM Employe";
$employees_result = $conn->query($employees_sql);

$clients_sql = "SELECT * FROM Client";
$clients_result = $conn->query($clients_sql);

$rooms_sql = "SELECT * FROM Chambre";
$rooms_result = $conn->query($rooms_sql);

$hotels_sql = "SELECT * FROM Hotel";
$hotels_result = $conn->query($hotels_sql);

$chains_sql = "SELECT * FROM ChaineHoteliere";
$chains_result = $conn->query($chains_sql);
?>

<head>
    <title>Page Admin</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css" />
    </noscript>
    <!-- CSS et JS de DataTable -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
</head>

<body class="is-preload">
    <div id="wrapper">
        <!-- En-tête -->
        <header id="header">
            <div class="inner">
                <a href="index.html" class="logo">
                    <span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Phantom</span>
                </a>
            </div>
        </header>

        <!-- Principal -->
        <div id="main">
            <div class="inner">
                <h1>Page Admin</h1>

                <!-- Add Form for Employee -->
                <h2>Ajouter un Employé</h2>
                <form method="POST">
                    <label for="hotel_id">ID de l'Hôtel :</label>
                    <input type="number" name="hotel_id" required><br>
                    <label for="nom_complet">Nom Complet :</label>
                    <input type="text" name="nom_complet" required><br>
                    <label for="adresse">Adresse :</label>
                    <input type="text" name="adresse" required><br>
                    <label for="NAS">NAS :</label>
                    <input type="text" name="NAS" required><br>
                    <label for="poste">Poste :</label>
                    <select name="poste" required>
                        <option value="gestionnaire">Gestionnaire</option>
                        <option value="receptionniste">Réceptionniste</option>
                        <option value="femme de ménage">Femme de Ménage</option>
                        <option value="autre">Autre</option>
                    </select><br>
                    <button type="submit" name="addEmployee">Ajouter l'Employé</button>
                </form>

                <!-- Add Form for Client -->
                <h2>Ajouter un Client</h2>
                <form method="POST">
                    <label for="nom_complet">Nom Complet :</label>
                    <input type="text" name="nom_complet" required><br>
                    <label for="adresse">Adresse :</label>
                    <input type="text" name="adresse" required><br>
                    <label for="NAS">NAS :</label>
                    <input type="text" name="NAS" required><br>
                    <button type="submit" name="addClient">Ajouter le Client</button>
                </form>

                <!-- Add Form for Room -->
                <h2>Ajouter une Chambre</h2>
                <form method="POST">
                    <label for="hotel_id">ID de l'Hôtel :</label>
                    <input type="number" name="hotel_id" required><br>
                    <label for="prix">Prix :</label>
                    <input type="number" name="prix" required><br>
                    <label for="capacite">Capacité :</label>
                    <input type="number" name="capacite" required><br>
                    <label for="vue_mer">Vue Mer :</label>
                    <input type="checkbox" name="vue_mer"><br>
                    <label for="vue_montagne">Vue Montagne :</label>
                    <input type="checkbox" name="vue_montagne"><br>
                    <label for="extensible">Extensible :</label>
                    <input type="checkbox" name="extensible"><br>
                    <button type="submit" name="addRoom">Ajouter la Chambre</button>
                </form>

                <!-- Add Form for Hotel -->
                <h2>Ajouter un Hôtel</h2>
                <form method="POST">
                    <label for="chain_id">Chaîne :</label>
                    <select name="chain_id" required>
                        <?php while ($chain_row = $chains_result->fetch_assoc()) { ?>
                            <option value="<?= $chain_row['chain_id'] ?>"><?= $chain_row['nom'] ?></option>
                        <?php } ?>
                    </select><br>
                    <label for="adresse">Adresse :</label>
                    <input type="text" name="adresse" required><br>
                    <label for="nb_chambres">Nombre de Chambres :</label>
                    <input type="number" name="nb_chambres" required><br>
                    <label for="classement">Classement :</label>
                    <input type="number" name="classement" required><br>
                    <label for="email_contact">Email Contact :</label>
                    <input type="email" name="email_contact" required><br>
                    <label for="telephone_contact">Téléphone Contact :</label>
                    <input type="tel" name="telephone_contact" required><br>
                    <button type="submit" name="addHotel">Ajouter l'Hôtel</button>
                </form>

                <!-- Tables (Same as before for Employee, Client, Room, Hotel) -->
                <h2>Liste des Employés</h2>
                <table id="employeeTable" class="display">
                    <thead>
                        <tr>
                            <th>Nom Complet</th>
                            <th>Adresse</th>
                            <th>NAS</th>
                            <th>Poste</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($employee_row = $employees_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $employee_row['nom_complet'] ?></td>
                                <td><?= $employee_row['adresse'] ?></td>
                                <td><?= $employee_row['NAS'] ?></td>
                                <td><?= $employee_row['poste'] ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="employee_id" value="<?= $employee_row['employee_id'] ?>" />
                                        <button type="submit" name="deleteEmployee">Supprimer</button>
                                    </form>
                                    <button data-toggle="modal" data-target="#modifyEmployeeModal<?= $employee_row['employee_id'] ?>">Modifier</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h2>Liste des Clients</h2>
                <table id="clientTable" class="display">
                    <thead>
                        <tr>
                            <th>Nom Complet</th>
                            <th>Adresse</th>
                            <th>NAS</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($client_row = $clients_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $client_row['nom_complet'] ?></td>
                                <td><?= $client_row['adresse'] ?></td>
                                <td><?= $client_row['NAS'] ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="client_id" value="<?= $client_row['client_id'] ?>" />
                                        <button type="submit" name="deleteClient">Supprimer</button>
                                    </form>
                                    <button data-toggle="modal" data-target="#modifyClientModal<?= $client_row['client_id'] ?>">Modifier</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h2>Liste des Chambres</h2>
                <table id="roomTable" class="display">
                    <thead>
                        <tr>
                            <th>Prix</th>
                            <th>Capacité</th>
                            <th>Vue Mer</th>
                            <th>Vue Montagne</th>
                            <th>Extensible</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($room_row = $rooms_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $room_row['prix'] ?></td>
                                <td><?= $room_row['capacite'] ?></td>
                                <td><?= $room_row['vue_mer'] ? 'Oui' : 'Non' ?></td>
                                <td><?= $room_row['vue_montagne'] ? 'Oui' : 'Non' ?></td>
                                <td><?= $room_row['extensible'] ? 'Oui' : 'Non' ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="room_id" value="<?= $room_row['room_id'] ?>" />
                                        <button type="submit" name="deleteRoom">Supprimer</button>
                                    </form>
                                    <button data-toggle="modal" data-target="#modifyRoomModal<?= $room_row['room_id'] ?>">Modifier</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <h2>Liste des Hôtels</h2>
                <table id="hotelTable" class="display">
                    <thead>
                        <tr>
                            <th>Chaîne</th>
                            <th>Adresse</th>
                            <th>Classement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($hotel_row = $hotels_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $hotel_row['chain_id'] ?></td>
                                <td><?= $hotel_row['adresse'] ?></td>
                                <td><?= $hotel_row['classement'] ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="hotel_id" value="<?= $hotel_row['hotel_id'] ?>" />
                                        <button type="submit" name="deleteHotel">Supprimer</button>
                                    </form>
                                    <button data-toggle="modal" data-target="#modifyHotelModal<?= $hotel_row['hotel_id'] ?>">Modifier</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#employeeTable').DataTable();
            $('#clientTable').DataTable();
            $('#roomTable').DataTable();
            $('#hotelTable').DataTable();
        });
    </script>
</body>
</html>
