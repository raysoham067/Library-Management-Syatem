<?php
session_start();

function get_user_issue_book_count() {
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"library_db");
	$user_issue_book_count = 0;
	$query = "SELECT COUNT(*) AS user_issue_book_count FROM issued_books WHERE student_id = $_SESSION[id]";
	$query_run = mysqli_query($connection, $query);
	while ($row = mysqli_fetch_assoc($query_run)) {
		$user_issue_book_count = $row['user_issue_book_count'];
	}
	return $user_issue_book_count;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LMS | User Dashboard</title>
	<link rel="stylesheet" href="bootstrap-4.4.1/css/bootstrap.min.css">
  	<script src="bootstrap-4.4.1/js/jquery_latest.js"></script>
  	<script src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
	<style>
		/* ===== General Page Styling ===== */
		body {
			background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
			font-family: 'Poppins', sans-serif;
			color: #fff;
			min-height: 100vh;
			padding-bottom: 40px;
		}

		/* ===== Navbar ===== */
		.navbar {
			background: rgba(0, 0, 0, 0.8);
			backdrop-filter: blur(8px);
			box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
		}

		.navbar-brand {
			font-weight: 600;
			color: #00b4d8 !important;
		}

		.navbar span {
			margin-left: 20px;
			font-size: 14px;
			color: #caf0f8;
		}

		.nav-link {
			color: #f1faee !important;
			font-weight: 500;
		}
		.nav-link:hover {
			color: #00b4d8 !important;
		}

		/* ===== Marquee ===== */
		marquee {
			background: rgba(255, 255, 255, 0.1);
			color: #a8dadc;
			padding: 8px;
			border-radius: 8px;
			margin: 20px;
			font-weight: 500;
		}

		/* ===== Dashboard Cards ===== */
		.card {
			border: none;
			border-radius: 15px;
			background: rgba(255, 255, 255, 0.1);
			backdrop-filter: blur(10px);
			color: #fff;
			box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
			transition: all 0.3s ease;
		}
		.card:hover {
			transform: translateY(-5px);
			box-shadow: 0 6px 25px rgba(0, 180, 216, 0.4);
		}

		.card-header {
			background: transparent;
			border-bottom: 1px solid rgba(255, 255, 255, 0.1);
			font-weight: 600;
			font-size: 1.1rem;
			color: #00b4d8;
		}

		.card-body {
			font-size: 1rem;
			color: #caf0f8;
		}

		.btn {
			border-radius: 10px;
			background: linear-gradient(135deg, #0077b6, #00b4d8);
			border: none;
			color: white;
			font-weight: 600;
			transition: 0.3s ease;
		}
		.btn:hover {
			transform: scale(1.05);
			box-shadow: 0 0 12px #00b4d8;
		}

		/* ===== Welcome Section ===== */
		#welcome {
			margin: 40px 0 20px;
			text-align: center;
		}
		#welcome h2 {
			font-weight: 700;
			color: #00b4d8;
		}
		#welcome p {
			color: #caf0f8;
		}

		/* ===== Footer ===== */
		footer {
			margin-top: 50px;
			text-align: center;
			color: #adb5bd;
			font-size: 0.9rem;
		}
	</style>
</head>

<body>

	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="#">📚 Library Management System</a>
			<span><strong>Welcome:</strong> <?php echo isset($_SESSION['name'])?htmlspecialchars($_SESSION['name']):''; ?></span>
			<span><strong>Email:</strong> <?php echo isset($_SESSION['email'])?htmlspecialchars($_SESSION['email']):''; ?></span>

			<ul class="nav navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown">My Profile</a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="view_profile.php">View Profile</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="edit_profile.php">Edit Profile</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="change_password.php">Change Password</a>
					</div>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>

	<!-- Info Bar -->
	<marquee>📘 This is the Library Management System. Open: 8:00 AM | Close: 8:00 PM | Sunday Closed.</marquee>

	<!-- Welcome Section -->
	<section id="welcome">
		<h2>Welcome to Your Dashboard 👋</h2>
		<p>Manage your library account, view issued books, and keep track of your borrowed resources.</p>
	</section>

	<!-- Dashboard Cards -->
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-3 mb-4">
				<div class="card text-center">
					<div class="card-header">📖 Books Issued</div>
					<div class="card-body">
						<p class="card-text">You currently have <strong><?php echo get_user_issue_book_count(); ?></strong> book(s) issued.</p>
						<a href="view_issued_book.php" class="btn btn-info">View Issued Books</a>
					</div>
				</div>
			</div>

			<div class="col-md-3 mb-4">
				<div class="card text-center">
					<div class="card-header">📚 Search Books</div>
					<div class="card-body">
						<p class="card-text">Find your favorite books in our collection.</p>
						<a href="search_book.php" class="btn btn-primary">Search Now</a>
					</div>
				</div>
			</div>

			<!-- New Request Book Card -->
			<div class="col-md-3 mb-4">
				<div class="card text-center">
					<div class="card-header">📩 Request Book</div>
					<div class="card-body">
						<p class="card-text">Request a book that is not available in the library.</p>
						<a href="request_book.php" class="btn btn-warning text-dark">Request Now</a>
					</div>
				</div>
			</div>

			<div class="col-md-3 mb-4">
				<div class="card text-center">
					<div class="card-header">🧾 Account Details</div>
					<div class="card-body">
						<p class="card-text">Check or update your personal details.</p>
						<a href="view_profile.php" class="btn btn-success">View Profile</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<footer>
		© <?php echo date("Y"); ?> Library Management System | All Rights Reserved
	</footer>

</body>
</html>
