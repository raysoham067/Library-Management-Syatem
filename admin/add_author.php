<?php
	require("functions.php");
	session_start();
	# Fetch data from database
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"library_db");
	$query = "SELECT * FROM admins WHERE email = '$_SESSION[email]'";
	$query_run = mysqli_query($connection,$query);
	while ($row = mysqli_fetch_assoc($query_run)){
		$name = $row['name'];
		$email = $row['email'];
		$mobile = $row['mobile'];
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add New Author | LMS</title>

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

		.card {
			background: rgba(255,255,255,0.95);
			backdrop-filter: blur(10px);
			border-radius: 15px;
			box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
			padding: 30px;
			margin-top: 50px;
		}

		h4 {
			font-weight: 700;
			color: #333;
			text-align: center;
			margin-bottom: 20px;
		}

		label {
			font-weight: 500;
		}

		.btn-primary {
			background-color: #667eea;
			border: none;
			border-radius: 8px;
			font-weight: 500;
			padding: 10px 18px;
			transition: all 0.3s ease;
			width: 100%;
		}

		.btn-primary:hover {
			background-color: #5563c1;
			transform: translateY(-2px);
		}
	</style>

	<script>
		function alertMsg(){
			alert("Author added successfully!");
			window.location.href = "admin_dashboard.php";
		}
	</script>
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
					<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">My Profile</a>
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

	<!-- ✅ Secondary Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd">
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

	<!-- ✅ Notice -->
	<div class="container mt-3">
		<marquee>📢 Library Management System — Open from 8:00 AM to 8:00 PM</marquee>
	</div>

	<!-- ✅ Form Section -->
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<h4>✍️ Add a New Author</h4>
					<form action="" method="post">
						<div class="mb-3">
							<label for="name">Author Name:</label>
							<input type="text" class="form-control" name="author_name" required>
						</div>
						<button type="submit" name="add_author" class="btn btn-primary">Add Author</button>
					</form>
				</div>
			</div>
		</div>
	</div>

</body>
</html>

<?php
	if(isset($_POST['add_author'])) {
		$connection = mysqli_connect("localhost","root","");
		$db = mysqli_select_db($connection,"library_db");
		$query = "INSERT INTO authors VALUES (NULL, '$_POST[author_name]')";
		$query_run = mysqli_query($connection,$query);

		if ($query_run) {
			echo "<script>alertMsg();</script>";
		} else {
			echo "<script>alert('Error adding author. Please try again.');</script>";
		}
	}
?>
