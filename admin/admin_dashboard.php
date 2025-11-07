<?php
	require("functions.php");
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Dashboard | LMS</title>

	<!-- ✅ Bootstrap 5 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

	<!-- ✅ Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

	<style>
		body {
			margin: 0;
			min-height: 100vh;
			background: linear-gradient(135deg, #667eea, #764ba2);
			font-family: 'Poppins', sans-serif;
			color: #212529;
			overflow-x: hidden;
		}

		.navbar {
			backdrop-filter: blur(10px);
			box-shadow: 0 4px 20px rgba(0,0,0,0.1);
		}

		.navbar-brand {
			font-weight: 600;
			letter-spacing: 0.5px;
		}

		marquee {
			color: #fff;
			font-weight: 500;
			background: rgba(0,0,0,0.2);
			padding: 8px 0;
			border-radius: 6px;
			margin-top: 8px;
		}

		h4 {
			font-weight: 600;
			color: #333;
		}

		.dashboard-container {
			margin-top: 40px;
			padding: 0 50px;
		}

		.card {
			border: none;
			border-radius: 20px;
			box-shadow: 0 8px 20px rgba(0,0,0,0.08);
			transition: all 0.3s ease-in-out;
		}

		.card:hover {
			transform: translateY(-6px);
			box-shadow: 0 10px 25px rgba(0,0,0,0.15);
		}

		.card-header {
			border-radius: 20px 20px 0 0;
			font-weight: 600;
			font-size: 1.1rem;
		}

		.btn {
			border-radius: 10px;
			font-weight: 500;
			transition: all 0.3s ease;
		}

		.btn:hover {
			transform: translateY(-2px);
			box-shadow: 0 4px 10px rgba(0,0,0,0.1);
		}

		footer {
			margin-top: 60px;
			text-align: center;
			color: white;
			opacity: 0.8;
			font-size: 14px;
		}
	</style>
</head>

<body>
	<!-- ✅ Top Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
		<div class="container-fluid px-4">
			<a class="navbar-brand" href="admin_dashboard.php">📚 Library Management System</a>
			<div class="text-white d-flex flex-column align-items-end">
				<span><strong>Welcome:</strong> <?php echo isset($_SESSION['name'])?htmlspecialchars($_SESSION['name']):''; ?></span>
				<span><strong>Email:</strong> <?php echo isset($_SESSION['email'])?htmlspecialchars($_SESSION['email']):''; ?></span>
			</div>
			<ul class="navbar-nav ms-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">My Profile</a>
					<ul class="dropdown-menu dropdown-menu-end">
						<li><a class="dropdown-item" href="view_profile.php">View Profile</a></li>
						<li><a class="dropdown-item" href="edit_profile.php">Edit Profile</a></li>
						<li><a class="dropdown-item" href="change_password.php">Change Password</a></li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link text-danger fw-bold" href="../logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>

	<!-- ✅ Secondary Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
		<div class="container-fluid justify-content-center">
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a></li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Books</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="add_book.php">Add New Book</a></li>
						<li><a class="dropdown-item" href="manage_book.php">Manage Books</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Category</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="add_cat.php">Add New Category</a></li>
						<li><a class="dropdown-item" href="manage_cat.php">Manage Category</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Authors</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="add_author.php">Add New Author</a></li>
						<li><a class="dropdown-item" href="manage_author.php">Manage Author</a></li>
					</ul>
				</li>
				<li class="nav-item"><a class="nav-link" href="issue_book.php">Issue Book</a></li>
			</ul>
		</div>
	</nav>

	<!-- ✅ Notice Bar -->
	<div class="container mt-3">
		<marquee>📢 Library Management System — Open from 8:00 AM to 8:00 PM. Manage your library efficiently!</marquee>
	</div>

	<!-- ✅ Dashboard Content -->
	<div class="container dashboard-container">
		<div class="row g-4">
			<!-- Registered Users -->
			<div class="col-md-4">
				<div class="card bg-light">
					<div class="card-header bg-primary text-white text-center">👥 Registered Users</div>
					<div class="card-body text-center">
						<p class="card-text fs-5">Total Users: <strong><?php echo get_user_count(); ?></strong></p>
						<a class="btn btn-primary" href="Regusers.php" target="_blank">View Users</a>
					</div>
				</div>
			</div>

			<!-- Total Books -->
			<div class="col-md-4">
				<div class="card bg-light">
					<div class="card-header bg-success text-white text-center">📚 Total Books</div>
					<div class="card-body text-center">
						<p class="card-text fs-5">Available Books: <strong><?php echo get_book_count(); ?></strong></p>
						<a class="btn btn-success" href="Regbooks.php" target="_blank">View Books</a>
					</div>
				</div>
			</div>

			<!-- Categories -->
			<div class="col-md-4">
				<div class="card bg-light">
					<div class="card-header bg-warning text-white text-center">🗂️ Book Categories</div>
					<div class="card-body text-center">
						<p class="card-text fs-5">Categories: <strong><?php echo get_category_count(); ?></strong></p>
						<a class="btn btn-warning text-white" href="Regcat.php" target="_blank">View Categories</a>
					</div>
				</div>
			</div>

			<!-- Authors -->
			<div class="col-md-4">
				<div class="card bg-light">
					<div class="card-header bg-info text-white text-center">✍️ Authors</div>
					<div class="card-body text-center">
						<p class="card-text fs-5">Total Authors: <strong><?php echo get_author_count(); ?></strong></p>
						<a class="btn btn-info text-white" href="Regauthor.php" target="_blank">View Authors</a>
					</div>
				</div>
			</div>

			<!-- Issued Books -->
			<div class="col-md-4">
				<div class="card bg-light">
					<div class="card-header bg-danger text-white text-center">📖 Issued Books</div>
					<div class="card-body text-center">
						<p class="card-text fs-5">Issued: <strong><?php echo get_issue_book_count(); ?></strong></p>
						<a class="btn btn-danger" href="view_issued_book.php" target="_blank">View Issued Books</a>
					</div>
				</div>
			</div>

            <!-- Book Requests -->
			<div class="col-md-4">
				<div class="card bg-light">
					<div class="card-header bg-secondary text-white text-center">📩 Book Requests</div>
					<div class="card-body text-center">
						<p class="card-text fs-5">Manage user book requests.</p>
						<a class="btn btn-secondary" href="manage_requests.php" target="_blank">View Requests</a>
					</div>
				</div>
			</div>

		</div>
	</div>

	<!-- ✅ Footer -->
	<footer class="mt-5 py-3">
		<p>© <?php echo date("Y"); ?> Library Management System — Admin Dashboard</p>
	</footer>
</body>
</html>
