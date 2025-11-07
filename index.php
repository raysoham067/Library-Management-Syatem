<?php
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LMS | User Login</title>
	<link rel="stylesheet" href="bootstrap-4.4.1/css/bootstrap.min.css">
  	<script src="bootstrap-4.4.1/js/jquery_latest.js"></script>
  	<script src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

	<style>
		/* ===== Background & Overlay ===== */
		body {
			margin: 0;
			padding: 0;
			min-height: 100vh;
			background: url('https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
			font-family: 'Poppins', sans-serif;
			display: flex;
			flex-direction: column;
			align-items: center;
			color: #fff;
			position: relative;
		}

		.overlay {
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.6);
			backdrop-filter: blur(10px);
			z-index: 1;
		}

		/* ===== Navbar ===== */
		.navbar {
			background: rgba(0, 0, 0, 0.7);
			backdrop-filter: blur(8px);
			box-shadow: 0 2px 20px rgba(0, 0, 0, 0.4);
			z-index: 2;
		}
		.navbar-brand {
			color: #00b4d8 !important;
			font-weight: 600;
		}
		.nav-link {
			color: #f1faee !important;
			transition: 0.3s;
			font-weight: 500;
		}
		.nav-link:hover {
			color: #00b4d8 !important;
		}

		/* ===== Marquee ===== */
		marquee {
			z-index: 2;
			width: 90%;
			background: rgba(255,255,255,0.1);
			color: #caf0f8;
			padding: 8px;
			border-radius: 8px;
			margin-top: 20px;
			font-weight: 500;
			box-shadow: 0 4px 20px rgba(0,0,0,0.3);
		}

		/* ===== Main Container ===== */
		.main-container {
			position: relative;
			z-index: 2;
			width: 90%;
			max-width: 900px;
			display: flex;
			flex-wrap: wrap;
			margin-top: 40px;
			background: rgba(255, 255, 255, 0.1);
			backdrop-filter: blur(15px);
			border-radius: 20px;
			box-shadow: 0 8px 30px rgba(0,0,0,0.5);
			overflow: hidden;
			color: #f1faee;
		}

		/* ===== Sidebar ===== */
		.sidebar {
			flex: 1 1 35%;
			padding: 40px 25px;
			background: rgba(0, 0, 0, 0.4);
			border-right: 1px solid rgba(255, 255, 255, 0.1);
		}
		.sidebar h5 {
			color: #00b4d8;
			font-weight: 600;
		}
		.sidebar ul {
			list-style: none;
			padding-left: 0;
			line-height: 1.8;
		}
		.sidebar hr {
			border-color: rgba(255, 255, 255, 0.2);
		}

		/* ===== Login Form Section ===== */
		.login-section {
			flex: 1 1 65%;
			padding: 50px;
		}
		.login-section h3 {
			text-align: center;
			color: #00b4d8;
			font-weight: 600;
			margin-bottom: 25px;
		}
		.form-control {
			background: rgba(255,255,255,0.15);
			border: none;
			border-radius: 10px;
			color: #fff;
			padding: 12px;
		}
		.form-control:focus {
			background: rgba(255,255,255,0.25);
			box-shadow: 0 0 10px #00b4d8;
			color: #fff;
		}
		label {
			color: #caf0f8;
			font-weight: 500;
		}
		button {
			width: 100%;
			background: linear-gradient(135deg, #0077b6, #00b4d8);
			border: none;
			border-radius: 10px;
			color: #fff;
			font-weight: 600;
			padding: 12px;
			margin-top: 10px;
			transition: 0.3s ease;
		}
		button:hover {
			transform: scale(1.05);
			box-shadow: 0 0 20px #00b4d8;
		}

		a {
			color: #90e0ef;
			transition: 0.3s;
		}
		a:hover {
			color: #00b4d8;
			text-decoration: underline;
		}
		.alert {
			border-radius: 10px;
			margin-top: 15px;
		}

		@media (max-width: 768px) {
			.main-container {
				flex-direction: column;
			}
			.sidebar {
				text-align: center;
				border-right: none;
				border-bottom: 1px solid rgba(255, 255, 255, 0.1);
			}
			.login-section {
				padding: 30px;
			}
		}
	</style>
</head>

<body>
	<div class="overlay"></div>

	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark w-100">
		<div class="container">
			<a class="navbar-brand" href="#">📚 Library Management System</a>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a class="nav-link" href="admin/index.php">Admin</a></li>
				<li class="nav-item"><a class="nav-link" href="signup.php">Register</a></li>
				<li class="nav-item"><a class="nav-link active" href="index.php">Login</a></li>
			</ul>
		</div>
	</nav>

	<!-- Marquee -->
	<marquee>📘 Welcome to the LMS | Library Hours: 8:00 AM - 8:00 PM | Closed on Sundays</marquee>

	<!-- Main Content -->
	<div class="main-container">
		<!-- Sidebar -->
		<div class="sidebar">
			<h5>🕒 Library Hours</h5>
			<ul>
				<li>Open: 8:00 AM</li>
				<li>Close: 8:00 PM</li>
				<li>Sunday: Closed</li>
			</ul>
			<hr>
			<h5>✨ Facilities</h5>
			<ul>
				<li>🪑 Comfortable Seating</li>
				<li>📶 Free Wi-Fi</li>
				<li>📰 Daily Newspapers</li>
				<li>💬 Group Study Rooms</li>
				<li>💧 RO Water</li>
				<li>🌿 Calm Environment</li>
			</ul>
		</div>

		<!-- Login Section -->
		<div class="login-section">
			<h3>🔐 User Login</h3>
			<form method="POST">
				<div class="form-group">
					<label>Email Address:</label>
					<input type="email" name="email" class="form-control" placeholder="Enter your email" required>
				</div>
				<div class="form-group">
					<label>Password:</label>
					<input type="password" name="password" class="form-control" placeholder="Enter your password" required>
				</div>
				<button type="submit" name="login">Login</button>
				<div class="text-center mt-3">
					<a href="signup.php">Not registered yet? Sign up</a>
				</div>
			</form>

			<?php
			if (isset($_POST['login'])) {
				$connection = mysqli_connect("localhost", "root", "", "library_db");
				if (!$connection) {
					die('<div class="alert alert-danger text-center">❌ Database connection failed!</div>');
				}

				$email = mysqli_real_escape_string($connection, $_POST['email']);
				$password = $_POST['password'];

				$query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
				$query_run = mysqli_query($connection, $query);

				if (mysqli_num_rows($query_run) > 0) {
					$row = mysqli_fetch_assoc($query_run);

					if (password_verify($password, $row['password']) || $row['password'] == $password) {
						$_SESSION['id'] = $row['id'];
						$_SESSION['name'] = $row['name'];
						$_SESSION['email'] = $row['email'];
						ob_end_clean();
						header("Location: user_dashboard.php");
						exit();
					} else {
						echo '<div class="alert alert-danger text-center">❌ Incorrect Password!</div>';
					}
				} else {
					echo '<div class="alert alert-warning text-center">⚠️ No account found with this email!</div>';
				}
			}
			?>
		</div>
	</div>
</body>
</html>
