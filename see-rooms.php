<?php
require_once "assets/php/database.php";
include_once "assets/php/room-select-fillers.php";
$conn = mysqli_connect("localhost", "root", "", "gestionhoteliere");

$hotelChainFiller = getHotelChains();

?>

<head>


	<title>Generic - Phantom by HTML5 UP</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	<link rel="stylesheet" href="assets/css/main.css" />
	<noscript>
		<link rel="stylesheet" href="assets/css/noscript.css" />
	</noscript>
	<!-- IMPORTS FOR INTERACTIVE TABLES -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css" />
	<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
</head>

<body class="is-preload">
	<!-- Wrapper -->
	<div id="wrapper">

		<!-- Header -->
		<header id="header">
			<div class="inner">
				<a href="index.html" class="logo">
					<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">Phantom</span>
				</a>

				<nav>
					<ul>
						<li><a href="#menu">Menu</a></li>
					</ul>
				</nav>
			</div>
		</header>

		<!-- Menu -->
		<nav id="menu">
			<h2>Menu</h2>
			<ul>
				<li><a href="index.html">Home</a></li>
				<li><a href="generic.html">Ipsum veroeros</a></li>
				<li><a href="generic.html">Tempus etiam</a></li>
				<li><a href="generic.html">Consequat dolor</a></li>
				<li><a href="elements.html">Elements</a></li>
			</ul>
		</nav>

		<!-- Main -->
		<div id="main">
			<div class="inner">
				<h1>Room Search</h1>
				<span class="image main"><img src="images/pic13.jpg" alt="" /></span>
				<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis. Praesent rutrum sem diam, vitae egestas enim auctor sit amet. Pellentesque leo mauris, consectetur id ipsum sit amet, fergiat. Pellentesque in mi eu massa lacinia malesuada et a elit. Donec urna ex, lacinia in purus ac, pretium pulvinar mauris. Curabitur sapien risus, commodo eget turpis at, elementum convallis elit. Pellentesque enim turpis, hendrerit tristique</p>
				<h1>Chaines hotelière disponible </h1>
			</div>


			<!-- Table -->
			<div style="max-width: 1200px; margin: 0 auto;">

				<table id="myTable" class="display" stye="width: 100%;">
					<thead>
						<tr>
							<th>Nom</th>
							<th>Adresse Siège</th>
							<th>Nombre D'Hotels</th>
							<th>Contact Email</th>
							<th>Contact Téléphone</th>
						</tr>
					</thead>
					<tbody>
						<!-- Database Connection and Fetching -->
						<?php
						// SQL Query to fetch room data
						$sql = "SELECT nom, adresse_siege, nb_hotels, email_contact, telephone_contact FROM chainehoteliere";
						$result = $conn->query($sql);

						// Handle connection errors
						if ($conn->connect_error) {
							die("Connection failed: " . $conn->connect_error);
						}

						// Display the data in the table
						if ($result->num_rows > 0) {
							while ($row = $result->fetch_assoc()) {
								echo "<tr>
                                <td>" . $row["nom"] . "</td>
                                <td>" . $row["adresse_siege"] . "</td>
                                <td>" . $row["nb_hotels"] . "</td>
                                <td>" . $row["email_contact"] . "</td>
                                <td>" . $row["telephone_contact"] . "</td>
                            </tr>";
							}
						} else {
							echo "<tr><td colspan='6'>No Hotel Chain available</td></tr>";
						}
						?>
					</tbody>
				</table>
				<!-- Table -->

				<br>
				<p style="font-weight: bold;">Select filters to generate a list of rooms according to your needs</p>
				<br>

				<!-- Filters -->
				<select id="chainFilter" style="width: 30%;">
					<option value="">Select Chains</option>
					<!-- Options loaded dynamically from the database -->
					<?php
					foreach ($hotelChainFiller as $hotelChain) {
						echo '<option value="' . $hotelChain['chain_id'] . '">' . $hotelChain['nom'] . '</option>';
					}
					?>
				</select>



				<select id="hotelFilter" style="width: 30%;">
					<option value="">Select Hotels</option>
					<!-- Options will be updated based on chain selection -->

				</select>


				<!-- Table Container -->
				<div id="tableContainer">
					<table id="roomsTable" class="display">
						<thead>
							<tr>
								<th>Room Number</th>
								<th>Prix</th>
								<th>Capacité</th>
								<th>Vue sur la Mer</th>
								<th>Vue sur la Montagne</th>
								<th>Extensible</th>
							</tr>
						</thead>
						<tbody>
							<!-- Room rows go here -->
						</tbody>
					</table>
				</div>

			</div>

		</div>
	</div>

	<script>
		// Initialize the DataTable
		$(document).ready(function() {
			$('#myTable').DataTable();
			$('#roomsTable').DataTable();
		});
	</script>
	<script>
		$(document).ready(function() {

			// When the chainFilter changes...
			$('#chainFilter').on('change', function() {
				// Get the selected chainId
				var chainId = $(this).val();

				// Clear out the "Hotels" dropdown before making the request
				$('#hotelFilter').empty();
				$('#hotelFilter').append('<option value="">Select Hotels</option>');

				// If no chain is selected, we can stop here
				if (!chainId) return;

				// Make an AJAX request to fetch the hotels
				$.ajax({
					url: 'assets/php/fill-hotel-selection.php', // your PHP file
					type: 'POST',
					data: {
						chainId: chainId
					},
					success: function(response) {
						// 'response' is the JSON string returned by get-hotels.php
						var hotels = JSON.parse(response);

						// Populate the hotelFilter dropdown with the returned data
						hotels.forEach(function(hotel) {
							// 'hotel.hotel_id' is the value, 'hotel.adresse' is the display text
							$('#hotelFilter').append(
								'<option value="' + hotel.hotel_id + '">' + hotel.adresse + '</option>'
							);
						});
					},
					error: function(xhr, status, error) {
						console.log('Error fetching hotels:', error);
					}
				});
			});

		});
	</script>
	<script>
		$(document).ready(function() {
			$('#hotelFilter').on('change', function() {
				var hotelId = $(this).val();

				// If no hotel is selected, stop here
				if (!hotelId) return;

				$.ajax({
					url: 'assets/php/fill-room-selection.php',
					type: 'POST',
					data: {
						hotelId: hotelId
					},
					success: function(response) {
						var rooms;
						try {
							rooms = typeof response === 'object' ? response : JSON.parse(response);
						} catch (e) {
							console.error('Error parsing JSON:', e);
							return;
						}

						// Get DataTable instance
						var table = $('#roomsTable').DataTable();

						// Clear any existing rows
						table.clear();

						// Add new rows using DataTables API
						rooms.forEach(function(room) {

							// Convert 0/1 to "oui" or "non"
							var vueMer = room.vue_mer == 1 ? 'oui' : 'non';
							var vueMontagne = room.vue_montagne == 1 ? 'oui' : 'non';
							var extensible = room.extensible == 1 ? 'oui' : 'non';

							table.row.add([
								room.room_id,
								room.prix,
								room.capacite,
								vueMer, // Use converted value
								vueMontagne, // Use converted value
								extensible // Use converted value
							]);
						});

						// Redraw table to display new data
						table.draw();
					},
					error: function(xhr, status, error) {
						console.log('Error fetching rooms:', error);
					}
				});
			});
		});
	</script>

</body>


<!--table-->

<!-- Footer -->
<footer id="footer">
	<div class="inner">
		<section>
			<h2>Get in touch</h2>
			<form method="post" action="#">
				<div class="fields">
					<div class="field half">
						<input type="text" name="name" id="name" placeholder="Name" />
					</div>
					<div class="field half">
						<input type="email" name="email" id="email" placeholder="Email" />
					</div>
					<div class="field">
						<textarea name="message" id="message" placeholder="Message"></textarea>
					</div>
				</div>
				<ul class="actions">
					<li><input type="submit" value="Send" class="primary" /></li>
				</ul>
			</form>
		</section>
		<section>
			<h2>Follow</h2>
			<ul class="icons">
				<li><a href="#" class="icon brands style2 fa-twitter"><span class="label">Twitter</span></a></li>
				<li><a href="#" class="icon brands style2 fa-facebook-f"><span class="label">Facebook</span></a></li>
				<li><a href="#" class="icon brands style2 fa-instagram"><span class="label">Instagram</span></a></li>
				<li><a href="#" class="icon brands style2 fa-dribbble"><span class="label">Dribbble</span></a></li>
				<li><a href="#" class="icon brands style2 fa-github"><span class="label">GitHub</span></a></li>
				<li><a href="#" class="icon brands style2 fa-500px"><span class="label">500px</span></a></li>
				<li><a href="#" class="icon solid style2 fa-phone"><span class="label">Phone</span></a></li>
				<li><a href="#" class="icon solid style2 fa-envelope"><span class="label">Email</span></a></li>
			</ul>
		</section>
		<ul class="copyright">
			<li>&copy; Untitled. All rights reserved</li>
			<li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
		</ul>
	</div>
</footer>

</div>

<!-- Scripts -->
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>

</html>