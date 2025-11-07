<?php
	session_start();
	# Fetch data from database
	$connection = mysqli_connect("localhost", "root", "");
	$db = mysqli_select_db($connection, "library_db");
	$query = "SELECT * FROM category";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Book Categories | LMS</title>

	<!-- ✅ Bootstrap 5 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

	<!-- ✅ Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

	<style>
		body {
			margin: 0;
			min-height: 100vh;
			background: linear-gradient(135deg, #667eea, #764ba2);
			background-attachment: fixed;
			font-family: 'Poppins', sans-serif;
			color: #212529;
		}

		.navbar {
			backdrop-filter: blur(8px);
			box-shadow: 0 2px 15px rgba(0,0,0,0.2);
		}

		marquee {
			color: #fff;
			font-weight: 500;
			background: rgba(0,0,0,0.2);
			padding: 8px 0;
			border-radius: 6px;
			margin-top: 10px;
		}

		.table-container {
			background: rgba(255, 255, 255, 0.9);
			backdrop-filter: blur(10px);
			border-radius: 15px;
			box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
			padding: 30px;
			margin-top: 50px;
		}

		table {
			width: 100%;
			border-radius: 8px;
			overflow: hidden;
		}

		table th {
			background-color: #667eea;
			color: white;
			text-align: center;
			font-weight: 600;
			font-size: 16px;
		}

		table td {
			text-align: center;
			background-color: #fff;
			vertical-align: middle;
			padding: 10px;
			font-size: 15px;
		}

		tr:hover td {
			background-color: #f1f3ff;
		}

		h4 {
			font-weight: 700;
			color: #333;
			text-align: center;
		}

		hr {
			border: 2px solid #667eea;
			width: 80px;
			margin: 0 auto 20px;
		}
	</style>
</head>
<body>

	<!-- ✅ Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand fw-semibold" href="admin_dashboard.php">📚 Library Management System</a>
			<div class="text-white d-flex flex-column align-items-end">
				<span><strong>Welcome:</strong> <?php echo $_SESSION['name']; ?></span>
				<span><strong>Email:</strong> <?php echo $_SESSION['email']; ?></span>
			</div>
			<ul class="navbar-nav ms-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" data-bs-toggle="dropdown">
						My Profile
					</a>
					<ul class="dropdown-menu dropdown-menu-end">
						<li><a class="dropdown-item" href="#">View Profile</a></li>
						<li><a class="dropdown-item" href="#">Edit Profile</a></li>
						<li><a class="dropdown-item" href="change_password.php">Change Password</a></li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link text-danger fw-bold" href="../logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>

	<!-- ✅ Notice -->
	<div class="container mt-3">
		<marquee>📢 Library Management System — Open from 8:00 AM to 8:00 PM | View All Registered Book Categories Below</marquee>
	</div>

	<!-- ✅ Table Section -->
	<div class="container table-container">
		<h4>🗂️ Registered Book Categories</h4>
		<hr>

		<div class="table-responsive">
			<table class="table table-bordered table-hover align-middle">
				<thead>
					<tr>
						<th>#</th>
						<th>Category Name</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$query_run = mysqli_query($connection, $query);
						$count = 1;
						if (mysqli_num_rows($query_run) > 0) {
							while ($row = mysqli_fetch_assoc($query_run)) {
								echo "<tr>
										<td>$count</td>
										<td>{$row['cat_name']}</td>
									</tr>";
								$count++;
							}
						} else {
							echo "<tr><td colspan='2' class='text-center text-muted'>No categories found.</td></tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

</body>
</html>
