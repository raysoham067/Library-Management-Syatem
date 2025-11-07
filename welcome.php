<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome | Library Management System</title>
	<link rel="stylesheet" href="bootstrap-4.4.1/css/bootstrap.min.css">
	<script src="bootstrap-4.4.1/js/jquery_latest.js"></script>
	<script src="bootstrap-4.4.1/js/bootstrap.min.js"></script>

	<style>
		/* ===== Background Style ===== */
		body {
			margin: 0;
			padding: 0;
			background: url('https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=1920&q=80') 
			no-repeat center center/cover;
			height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			font-family: 'Poppins', sans-serif;
			color: #fff;
			overflow: hidden;
		}

		/* ===== Overlay ===== */
		.overlay {
			position: absolute;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.6);
			backdrop-filter: blur(5px);
			top: 0;
			left: 0;
			z-index: 1;
		}

		/* ===== Glass Container ===== */
		.welcome-container {
			position: relative;
			z-index: 2;
			background: rgba(255, 255, 255, 0.1);
			backdrop-filter: blur(15px);
			padding: 50px;
			border-radius: 20px;
			box-shadow: 0 8px 32px rgba(0,0,0,0.3);
			text-align: center;
			width: 80%;
			max-width: 700px;
			color: #f8f9fa;
			animation: fadeIn 1.5s ease;
		}

		h1 {
			font-size: 2.5rem;
			font-weight: 700;
			color: #00b4d8;
			margin-bottom: 15px;
		}

		p {
			font-size: 1.1rem;
			margin-bottom: 40px;
			color: #caf0f8;
		}

		.btn-custom {
			background: linear-gradient(135deg, #0077b6, #00b4d8);
			border: none;
			color: white;
			font-weight: 600;
			border-radius: 10px;
			padding: 12px 30px;
			margin: 10px;
			transition: all 0.3s ease;
			box-shadow: 0 0 15px rgba(0, 180, 216, 0.4);
		}

		.btn-custom:hover {
			transform: scale(1.05);
			box-shadow: 0 0 25px rgba(0, 180, 216, 0.8);
		}

		footer {
			position: absolute;
			bottom: 15px;
			width: 100%;
			text-align: center;
			color: #adb5bd;
			font-size: 0.9rem;
			z-index: 2;
		}

		@keyframes fadeIn {
			from { opacity: 0; transform: translateY(30px); }
			to { opacity: 1; transform: translateY(0); }
		}

		@media (max-width: 768px) {
			h1 { font-size: 2rem; }
			p { font-size: 1rem; }
			.welcome-container { padding: 30px; }
		}
	</style>
</head>

<body>
	<div class="overlay"></div>

	<div class="welcome-container">
		<h1>📚 Welcome to Kitab Ghar</h1>
		<p>Manage your books, members, and borrowing records efficiently — anytime, anywhere.</p>
		
		<div>
			<a href="index.php" class="btn btn-custom">👤 User Login</a>
			<a href="admin/index.php" class="btn btn-custom">🧑‍💼 Admin Login</a>
			<a href="signup.php" class="btn btn-custom">📝 Register</a>
		</div>
	</div>

	<footer>
		© <?php echo date("Y"); ?> Library Management System | @soham
	</footer>
</body>
</html>
