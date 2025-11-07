<?php
ob_start(); // ✅ Start output buffering (prevents header issues)
session_start();

// ✅ Handle login logic before any HTML output
$error_message = "";

if (isset($_POST['login'])) {
    $connection = mysqli_connect("localhost", "root", "", "library_db");
    if (!$connection) {
        die("<div class='alert-danger text-center'>❌ Database connection failed!</div>");
    }

    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM admins WHERE email = '$email' LIMIT 1";
    $query_run = mysqli_query($connection, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_assoc($query_run);
        if ($row['password'] === $password) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['email'] = $row['email'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error_message = "❌ Wrong Password!";
        }
    } else {
        $error_message = "⚠️ No account found for this email!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LMS | Admin Login</title>
	<link rel="stylesheet" href="../bootstrap-4.4.1/css/bootstrap.min.css">
  	<script src="../bootstrap-4.4.1/js/jquery_latest.js"></script>
  	<script src="../bootstrap-4.4.1/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

	<style>
		/* ===== Background ===== */
		body {
			margin: 0;
			padding: 0;
			min-height: 100vh;
			background: url('https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
			font-family: 'Poppins', sans-serif;
			display: flex;
			flex-direction: column;
			align-items: center;
			position: relative;
			color: #fff;
		}

		/* ===== Overlay ===== */
		.overlay {
			position: absolute;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.6);
			backdrop-filter: blur(10px);
			top: 0;
			left: 0;
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

		/* ===== Notice Bar ===== */
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

		/* ===== Login Container ===== */
		.login-container {
			position: relative;
			z-index: 2;
			width: 90%;
			max-width: 700px;
			background: rgba(255, 255, 255, 0.1);
			backdrop-filter: blur(15px);
			border-radius: 20px;
			box-shadow: 0 8px 32px rgba(0,0,0,0.4);
			margin-top: 50px;
			padding: 50px;
			color: #f8f9fa;
			animation: fadeIn 1.5s ease;
		}

		h3 {
			text-align: center;
			color: #00b4d8;
			font-weight: 600;
			margin-bottom: 25px;
		}

		label {
			color: #caf0f8;
			font-weight: 500;
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

		.btn-primary {
			width: 100%;
			border: none;
			border-radius: 10px;
			background: linear-gradient(135deg, #0077b6, #00b4d8);
			color: #fff;
			font-weight: 600;
			padding: 12px;
			margin-top: 10px;
			transition: 0.3s ease;
		}
		.btn-primary:hover {
			transform: scale(1.05);
			box-shadow: 0 0 20px #00b4d8;
		}

		.alert-danger {
			background: rgba(220,53,69,0.8);
			border: none;
			border-radius: 10px;
			color: #fff;
			padding: 10px;
			font-weight: 500;
			margin-top: 15px;
		}

		footer {
			margin-top: auto;
			color: #adb5bd;
			font-size: 0.9rem;
			text-align: center;
			padding: 20px;
			z-index: 2;
		}

		/* ===== Animation ===== */
		@keyframes fadeIn {
			from { opacity: 0; transform: translateY(30px); }
			to { opacity: 1; transform: translateY(0); }
		}

		@media (max-width: 768px) {
			.login-container {
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
			<a class="navbar-brand" href="../welcome.php">📚 Library Management System</a>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a class="nav-link active" href="index.php">Admin Login</a></li>
				<li class="nav-item"><a class="nav-link" href="../signup.php">Register</a></li>
				<li class="nav-item"><a class="nav-link" href="../index.php">User Login</a></li>
			</ul>
		</div>
	</nav>

	<!-- Notice Bar -->
	<marquee>📢 Library opens at 8:00 AM and closes at 8:00 PM | Sunday Closed</marquee>

	<!-- Main Login Section -->
	<div class="login-container">
		<h3>🔐 Admin Login</h3>
		<form action="" method="post">
			<div class="form-group">
				<label>Email ID:</label>
				<input type="email" name="email" class="form-control" placeholder="Enter admin email" required>
			</div>
			<div class="form-group">
				<label>Password:</label>
				<input type="password" name="password" class="form-control" placeholder="Enter password" required>
			</div>
			<button type="submit" name="login" class="btn btn-primary mt-3">Login</button>	
		</form>

		<?php 
			// ✅ Show error message (if any)
			if (!empty($error_message)) {
				echo "<div class='alert-danger text-center'>$error_message</div>";
			}
		?>
	</div>

	<footer>
		© <?php echo date("Y"); ?> Library Management System | Admin Portal
	</footer>

<?php ob_end_flush(); ?>
</body>
</html>
