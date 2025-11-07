<?php
	session_start();
	# Fetch data from database
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"library_db");
	$name = "";
	$email = "";
	$mobile = "";
	$query = "SELECT * FROM users WHERE email = '$_SESSION[email]'";
	$query_run = mysqli_query($connection,$query);
	while ($row = mysqli_fetch_assoc($query_run)){
		$name = $row['name'];
		$email = $row['email'];
		$mobile = $row['mobile'];
		$address = $row['address'];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Student Dashboard | LMS</title>

	<!-- ✅ Modern Bootstrap 5 -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

	<style>
		/* 🌈 Background Gradient */
		body {
			margin: 0;
			min-height: 100vh;
			background: linear-gradient(135deg, #667eea, #764ba2);
			background-attachment: fixed;
			font-family: 'Poppins', sans-serif;
			color: #212529;
		}

		.navbar {
			background-color: rgba(0, 0, 0, 0.85) !important;
			backdrop-filter: blur(8px);
			box-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
		}

		.navbar-brand {
			font-weight: 600;
			letter-spacing: 0.5px;
		}

		marquee {
			color: #fff;
			font-weight: 500;
			background: rgba(0,0,0,0.3);
			padding: 8px 0;
			border-radius: 5px;
			margin-top: 10px;
		}

		.profile-card {
			background: rgba(255, 255, 255, 0.9);
			backdrop-filter: blur(12px);
			border-radius: 15px;
			box-shadow: 0 10px 25px rgba(0,0,0,0.1);
			padding: 40px;
			margin-top: 50px;
			transition: transform 0.3s ease, box-shadow 0.3s ease;
		}

		.profile-card:hover {
			transform: translateY(-5px);
			box-shadow: 0 12px 30px rgba(0,0,0,0.15);
		}

		h4 {
			font-weight: 700;
			color: #333;
			text-shadow: 0 1px 2px rgba(0,0,0,0.1);
		}

		label {
			font-weight: 600;
			color: #444;
		}

		input.form-control {
			border: none;
			background: #f1f3f5;
			border-radius: 8px;
			padding: 10px 12px;
			font-size: 15px;
			box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
		}
		
	</style>
</head>
<body>
	<!-- ✅ Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark">
		<div class="container-fluid">
			<a class="navbar-brand" href="admin_dashboard.php">📚 Library Management System</a>
			<div class="d-flex align-items-center text-white me-3">
				<span class="me-3"><strong>Welcome:</strong> <?php echo $_SESSION['name']; ?></span>
				<span><strong>Email:</strong> <?php echo $_SESSION['email']; ?></span>
			</div>
			<ul class="navbar-nav ms-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
						My Profile
					</a>
					<ul class="dropdown-menu dropdown-menu-end">
						<li><a class="dropdown-item" href="view_profile.php">View Profile</a></li>
						<li><a class="dropdown-item" href="edit_profile.php">Edit Profile</a></li>
						<li><a class="dropdown-item" href="change_password.php">Change Password</a></li>
					</ul>
				</li>
				<li class="nav-item">
					<a class="nav-link text-danger fw-bold" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>

	<!-- ✅ Notice -->
	<div class="container">
		<marquee>📢 This is the Library Management System. Library opens at 8:00 AM and closes at 8:00 PM.</marquee>
	</div>

	<!-- ✅ Profile Section -->
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="profile-card">
					<div class="text-center mb-4">
						<h4>👤 Student Profile Details</h4>
						<hr class="w-25 mx-auto" style="border: 2px solid #667eea;">
					</div>
					<form>
						<div class="mb-3">
							<label for="name">Name:</label>
							<input type="text" class="form-control" value="<?php echo $name; ?>" disabled>
						</div>
						<div class="mb-3">
							<label for="email">Email:</label>
							<input type="text" class="form-control" value="<?php echo $email; ?>" disabled>
						</div>
						<div class="mb-3">
							<label for="mobile">Mobile:</label>
							<input type="text" class="form-control" value="<?php echo $mobile; ?>" disabled>
						</div>
						<div class="mb-3">
							<label for="address">Address:</label>
							<input type="text" class="form-control" value="<?php echo $address; ?>" disabled>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
