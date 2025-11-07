<?php
	require("functions.php");
	session_start();

	// ✅ Fetch data from database
	$connection = mysqli_connect("localhost", "root", "");
	$db = mysqli_select_db($connection, "library_db");

	$query = "SELECT b.book_id, b.book_name, b.book_no, b.book_price, b.book_pdf,
	                 a.author_name, c.cat_name 
	          FROM books b
	          LEFT JOIN authors a ON b.author_id = a.author_id
	          LEFT JOIN category c ON b.cat_id = c.cat_id";
	$query_run = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Manage Books | LMS</title>

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
		}

		table td {
			text-align: center;
			background-color: #fff;
			vertical-align: middle;
			padding: 10px;
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
			padding: 5px 10px;
			border-radius: 5px;
			text-decoration: none;
			transition: 0.3s;
		}

		.btn-edit:hover {
			background-color: #43a047;
		}

		.btn-delete {
			background-color: #f44336;
			color: white;
			padding: 5px 10px;
			border-radius: 5px;
			text-decoration: none;
			transition: 0.3s;
		}

		.btn-delete:hover {
			background-color: #d32f2f;
		}

		.btn-download {
			background-color: #007bff;
			color: white;
			padding: 5px 10px;
			border-radius: 5px;
			text-decoration: none;
			transition: 0.3s;
		}

		.btn-download:hover {
			background-color: #0056b3;
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

	<!-- ✅ Notice -->
	<div class="container mt-3">
		<marquee>📢 Library Management System — Manage all available books below.</marquee>
	</div>

	<!-- ✅ Table Section -->
	<div class="container table-container">
		<h4>📘 Manage Books</h4>
		<hr>

		<div class="table-responsive">
			<table class="table table-bordered table-hover align-middle">
				<thead>
					<tr>
						<th>#</th>
						<th>Book Name</th>
						<th>Author</th>
						<th>Category</th>
						<th>ISBN No.</th>
						<th>Price (₹)</th>
						<th>PDF</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count = 1;
						if (mysqli_num_rows($query_run) > 0) {
							while ($row = mysqli_fetch_assoc($query_run)) {
								echo "<tr>
										<td>$count</td>
										<td>{$row['book_name']}</td>
										<td>{$row['author_name']}</td>
										<td>{$row['cat_name']}</td>
										<td>{$row['book_no']}</td>
										<td>{$row['book_price']}</td>";

								// ✅ PDF Column
								if (!empty($row['book_pdf'])) {
									echo "<td><a href='../uploads/books_pdf/{$row['book_pdf']}' class='btn-download' download>Download PDF</a></td>";
								} else {
									echo "<td><span class='text-danger'>No PDF</span></td>";
								}

								echo "<td>
										<a href='edit_book.php?bn={$row['book_no']}' class='btn-edit'>Edit</a>
										<a href='delete_book.php?bn={$row['book_no']}' class='btn-delete'>Delete</a>
									</td>
								</tr>";

								$count++;
							}
						} else {
							echo "<tr><td colspan='8' class='text-center text-muted'>No books found in the database.</td></tr>";
						}
					?>
				</tbody>
			</table>
		</div>
	</div>

</body>
</html>
