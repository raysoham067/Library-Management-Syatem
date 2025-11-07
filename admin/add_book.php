<?php
session_start();
require_once "../config.php";

// ✅ Ensure admin logged in
if (!isset($_SESSION['email'])) {
	header("Location: ../index.php");
	exit;
}

// ✅ Fetch admin info
$admin_query = "SELECT * FROM admins WHERE email = '{$_SESSION['email']}' LIMIT 1";
$admin_result = mysqli_query($conn, $admin_query);
$admin_data = mysqli_fetch_assoc($admin_result);

// ✅ Fetch authors & categories
$authors = mysqli_query($conn, "SELECT author_id, author_name FROM authors");
$categories = mysqli_query($conn, "SELECT cat_id, cat_name FROM category");

function clean_filename($name) {
	return preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $name);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add New Book | LMS</title>

	<!-- ✅ Bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- ✅ Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

	<style>
		body {
			margin: 0;
			min-height: 100vh;
			background: linear-gradient(135deg, #667eea, #764ba2);
			font-family: 'Poppins', sans-serif;
			color: #212529;
		}
		.card {
			background: rgba(255,255,255,0.95);
			backdrop-filter: blur(10px);
			border-radius: 15px;
			box-shadow: 0 8px 25px rgba(0,0,0,0.15);
			padding: 30px;
			margin-top: 40px;
		}
		h4 {
			font-weight: 700;
			color: #333;
			text-align: center;
			margin-bottom: 20px;
		}
		.btn-primary {
			background-color: #667eea;
			border: none;
			border-radius: 8px;
			font-weight: 500;
			padding: 10px 18px;
			transition: all 0.3s ease;
		}
		.btn-primary:hover {
			background-color: #5563c1;
			transform: translateY(-2px);
		}
	</style>

	<script>
		function successMsg(){
			alert("✅ Book added successfully!");
			window.location.href = "manage_book.php";
		}
	</script>
</head>
<body>

	<!-- ✅ Navbar -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand fw-semibold" href="admin_dashboard.php">📚 Library Management System</a>
			<div class="text-white d-flex flex-column align-items-end">
				<span><strong>Welcome:</strong> <?php echo htmlspecialchars($admin_data['name']); ?></span>
				<span><strong>Email:</strong> <?php echo htmlspecialchars($admin_data['email']); ?></span>
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

	<!-- ✅ Notice -->
	<div class="container mt-3">
		<marquee>📢 Library Management System — Open from 8:00 AM to 8:00 PM</marquee>
	</div>

	<!-- ✅ Add Book Form -->
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<h4>📘 Add a New Book</h4>

					<form method="post" enctype="multipart/form-data">
						<div class="mb-3">
							<label>Book Name:</label>
							<input type="text" name="book_name" class="form-control" required>
						</div>

						<div class="mb-3">
							<label>Select Author:</label>
							<select name="book_author" class="form-select" required>
								<option value="">-- Select Author --</option>
								<?php while ($author = mysqli_fetch_assoc($authors)) { ?>
									<option value="<?= $author['author_id'] ?>"><?= htmlspecialchars($author['author_name']) ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="mb-3">
							<label>Select Category:</label>
							<select name="book_category" class="form-select" required>
								<option value="">-- Select Category --</option>
								<?php while ($cat = mysqli_fetch_assoc($categories)) { ?>
									<option value="<?= $cat['cat_id'] ?>"><?= htmlspecialchars($cat['cat_name']) ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="mb-3">
							<label>Book Number:</label>
							<input type="text" name="book_no" class="form-control" required>
						</div>

						<div class="mb-3">
							<label>Book Price (₹):</label>
							<input type="number" name="book_price" class="form-control" required>
						</div>

						<div class="mb-3">
							<label>Upload Book PDF:</label>
							<input type="file" name="book_pdf" accept="application/pdf" class="form-control" required>
						</div>

						<button type="submit" name="add_book" class="btn btn-primary w-100">Add Book</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
if (isset($_POST['add_book'])) {
	$book_name = mysqli_real_escape_string($conn, $_POST['book_name']);
	$book_author = (int)$_POST['book_author'];
	$book_category = (int)$_POST['book_category'];
	$book_no = mysqli_real_escape_string($conn, $_POST['book_no']);
	$book_price = (float)$_POST['book_price'];

	// ✅ Handle PDF upload
	$pdf_file = $_FILES['book_pdf'];
	if ($pdf_file['error'] === UPLOAD_ERR_OK) {
		$ext = strtolower(pathinfo($pdf_file['name'], PATHINFO_EXTENSION));
		if ($ext !== 'pdf') {
			echo "<script>alert('❌ Only PDF files allowed.');</script>";
			exit;
		}

		$upload_dir = "../uploads/books_pdf/";
		if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

		$new_filename = time() . "_" . clean_filename($pdf_file['name']);
		$destination = $upload_dir . $new_filename;

		if (move_uploaded_file($pdf_file['tmp_name'], $destination)) {
			$query = "INSERT INTO books (book_name, author_id, cat_id, book_no, book_price, book_pdf)
					  VALUES ('$book_name', '$book_author', '$book_category', '$book_no', '$book_price', '$new_filename')";
			if (mysqli_query($conn, $query)) {
				echo "<script>successMsg();</script>";
			} else {
				echo "<script>alert('❌ Database error: " . mysqli_error($conn) . "');</script>";
			}
		} else {
			echo "<script>alert('❌ Failed to move uploaded PDF.');</script>";
		}
	} else {
		echo "<script>alert('❌ File upload error.');</script>";
	}
}
?>
