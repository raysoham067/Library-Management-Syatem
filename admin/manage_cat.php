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
	<title>Manage Categories | LMS</title>

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

		.btn-edit {
			background-color: #4CAF50;
			color: white;
			padding: 5px 12px;
			border-radius: 6px;
			text-decoration: none;
			font-size: 14px;
			transition: 0.3s;
		}

		.btn-edit:hover {
			background-color: #43a047;
		}

		.btn-delete {
			background-color: #f44336;
			color: white;
			padding: 5px 12px;
			border-radius: 6px;
			text-decoration: none;
			font-size: 14px;
			transition: 0.3s;
		}

		.btn-delete:hover {
			background-color: #d32f2f;
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
		<marquee>📢 Library Management System — Manage all categories below.</marquee>
	</div>

	<!-- ✅ Table Section -->
	<div class="container table-container">
		<h4>🗂️ Manage Categories</h4>
		<hr>

		<div class="table-responsive">
			<table class="table table-bordered table-hover align-middle">
				<thead>
					<tr>
						<th>#</th>
						<th>Category Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$query = "SELECT * FROM category";
						$query_run = mysqli_query($connection,$query);
						$count = 1;
						if (mysqli_num_rows($query_run) > 0) {
							while ($row = mysqli_fetch_assoc($query_run)) {
								echo "<tr>
										<td>$count</td>
										<td>{$row['cat_name']}</td>
										<td>
											<a href='edit_cat.php?cid={$row['cat_id']}' class='btn-edit'>Edit</a>
											<a href='delete_cat.php?cid={$row['cat_id']}' class='btn-delete'>Delete</a>
										</td>
									</tr>";
								$count++;
							}
						} else {
							echo "<tr><td colspan='3' class='text-center text-muted'>No categories found in the database.</td></tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

</body>
</html>
