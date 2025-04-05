<?php
require_once "assets/php/database.php";
?>

<!DOCTYPE HTML>
<html>
	<head>
		<title>E-Hotels - Client View</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">
		<div id="wrapper">
			<header id="header">
				<div class="inner">
					<a href="index.html" class="logo">
						<span class="symbol"><img src="images/logo.svg" alt="" /></span><span class="title">E-Hotels</span>
					</a>
					<nav>
						<ul>
							<li><a href="#menu">Menu</a></li>
						</ul>
					</nav>
				</div>
			</header>

			<nav id="menu">
				<h2>Menu</h2>
				<ul>
					<li><a href="index.html">Home</a></li>
					<li><a href="reservation.php">Make Reservation</a></li>
				</ul>
			</nav>

			<div id="main">
				<div class="inner">
					<header>
						<h1>Welcome to E-Hotels<br />
						<a href="employee-view.php">Employee Login</a></h1>
					</header>
					<section class="tiles">
						<article class="style1">
							<span class="image">
								<img src="images/pic01.jpg" alt="" />
							</span>
							<a href="reservation.php">
								<h2>Make A Reservation</h2>
								<div class="content">
									<p>Book your room today</p>
								</div>
							</a>
						</article>
						<article class="style2">
							<span class="image">
								<img src="images/pic02.jpg" alt="" />
							</span>
							<a href="see-rooms.php">
								<h2>See rooms</h2>
								<div class="content">
									<p>View our available rooms</p>
								</div>
							</a>
						</article>
					</section>
				</div>
			</div>

			<footer id="footer">
				<div class="inner">
					<section>
						<h2>Contact Us</h2>
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
					<ul class="copyright">
						<li>&copy; E-Hotels. All rights reserved</li>
					</ul>
				</div>
			</footer>
		</div>

		<script src="assets/js/jquery.min.js"></script>
		<script src="assets/js/browser.min.js"></script>
		<script src="assets/js/breakpoints.min.js"></script>
		<script src="assets/js/util.js"></script>
		<script src="assets/js/main.js"></script>
	</body>
</html>