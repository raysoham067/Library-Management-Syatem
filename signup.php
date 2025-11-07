<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>LMS | User Registration</title>
	<link rel="stylesheet" href="bootstrap-4.4.1/css/bootstrap.min.css">
  	<script src="bootstrap-4.4.1/js/jquery_latest.js"></script>
  	<script src="bootstrap-4.4.1/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

	<style>
		/* ===== Background ===== */
		body {
			margin: 0;
			padding: 0;
			min-height: 100vh;
			font-family: 'Poppins', sans-serif;
			background: url('https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&w=1920&q=80') no-repeat center center/cover;
			display: flex;
			flex-direction: column;
			justify-content: center;
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

		/* ===== Container ===== */
		.register-container {
			position: relative;
			z-index: 2;
			width: 90%;
			max-width: 900px;
			display: flex;
			flex-wrap: wrap;
			background: rgba(255, 255, 255, 0.1);
			backdrop-filter: blur(15px);
			box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
			border-radius: 20px;
			overflow: hidden;
			animation: fadeIn 1.5s ease;
		}

		/* ===== Sidebar ===== */
		.sidebar {
			flex: 1 1 35%;
			background: rgba(0, 0, 0, 0.5);
			padding: 40px 25px;
			color: #f8f9fa;
			display: flex;
			flex-direction: column;
			justify-content: center;
		}
		.sidebar h4 {
			color: #00b4d8;
			font-weight: 600;
			margin-bottom: 15px;
		}
		.sidebar ul {
			list-style: none;
			padding-left: 0;
			line-height: 1.8;
		}

		/* ===== Form Section ===== */
		.form-section {
			flex: 1 1 65%;
			padding: 50px;
			color: #fff;
		}
		.form-section h3 {
			text-align: center;
			font-weight: 600;
			color: #00b4d8;
			margin-bottom: 25px;
		}

		.form-group {
			position: relative;
			margin-bottom: 25px;
		}

		.form-control {
			background: rgba(255, 255, 255, 0.15);
			border: none;
			border-radius: 10px;
			color: #fff;
			padding: 12px;
			width: 100%;
			font-size: 1rem;
			transition: all 0.3s ease;
		}
		.form-control:focus {
			background: rgba(255, 255, 255, 0.25);
			box-shadow: 0 0 10px #00b4d8;
		}
		label {
			position: absolute;
			top: 12px;
			left: 15px;
			color: #ccc;
			pointer-events: none;
			transition: 0.3s ease;
		}
		.form-control:focus + label,
		.form-control:not(:placeholder-shown) + label {
			top: -10px;
			left: 10px;
			font-size: 0.85rem;
			color: #00b4d8;
			background: rgba(0, 0, 0, 0.5);
			padding: 0 5px;
			border-radius: 5px;
		}

		textarea {
			resize: none;
		}

		.btn-register {
			width: 100%;
			background: linear-gradient(135deg, #0077b6, #00b4d8);
			border: none;
			border-radius: 10px;
			color: #fff;
			font-weight: 600;
			padding: 12px;
			margin-top: 10px;
			transition: 0.3s ease;
		}
		.btn-register:hover {
			transform: scale(1.05);
			box-shadow: 0 0 20px #00b4d8;
		}

		/* ===== Animation ===== */
		@keyframes fadeIn {
			from { opacity: 0; transform: translateY(30px); }
			to { opacity: 1; transform: translateY(0); }
		}

		/* ===== Responsive ===== */
		@media (max-width: 768px) {
			.register-container {
				flex-direction: column;
			}
			.sidebar {
				text-align: center;
			}
			.form-section {
				padding: 30px;
			}
		}
	</style>
</head>

<body>
	<div class="overlay"></div>

	<div class="register-container">
		<!-- Sidebar -->
		<div class="sidebar">
			<h4>📚 Library Information</h4>
			<ul>
				<li>⏰ Open: 8:00 AM - 8:00 PM</li>
				<li>📅 Sunday Closed</li>
				<li>💺 Comfortable Reading Area</li>
				<li>🌐 Free Wi-Fi Access</li>
				<li>📰 Daily Newspapers</li>
				<li>💧 RO Water Facility</li>
				<li>☮️ Peaceful Environment</li>
			</ul>
		</div>

		<!-- Registration Form -->
		<div class="form-section">
			<h3>📝 User Registration</h3>
			<form action="register.php" method="post">
				<div class="form-group">
					<input type="text" name="name" class="form-control" placeholder=" " required>
					<label>Full Name</label>
				</div>

				<div class="form-group">
					<input type="email" name="email" class="form-control" placeholder=" " required>
					<label>Email Address</label>
				</div>

				<div class="form-group">
					<input type="password" name="password" class="form-control" placeholder=" " required>
					<label>Password</label>
				</div>

				<div class="form-group">
					<input type="text" name="mobile" class="form-control" placeholder=" " required>
					<label>Mobile Number</label>
				</div>

				<div class="form-group">
					<textarea name="address" class="form-control" placeholder=" " required></textarea>
					<label>Address</label>
				</div>

				<button type="submit" class="btn-register">Register Now</button>
			</form>
		</div>
	</div>
</body>
</html>
