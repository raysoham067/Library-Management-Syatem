<?php
session_start();

# Database connection
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, "library_db");

$search_query = "";
$search_result = [];

if (isset($_POST['search'])) {
    $search_query = trim($_POST['search_text']);
    // ✅ Updated query with JOIN between books and authors
    $query = "
        SELECT b.book_no, b.book_name, b.book_price, a.author_name
        FROM books b
        LEFT JOIN authors a ON b.author_id = a.author_id
        WHERE b.book_name LIKE '%$search_query%'
           OR a.author_name LIKE '%$search_query%'
           OR b.book_no LIKE '%$search_query%'
    ";
    $search_result = mysqli_query($connection, $query);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Book | LMS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            background-attachment: fixed;
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background-color: rgba(0,0,0,0.85) !important;
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.3);
        }
        .search-card {
            background: rgba(255,255,255,0.9);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        .btn-primary {
            background-color: #667eea;
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #5563c1;
            transform: translateY(-2px);
        }
        table th {
            background-color: #667eea;
            color: white;
            text-align: center;
        }
        table td {
            text-align: center;
            background: #ffffff;
        }
        marquee {
            color: #fff;
            font-weight: 500;
            background: rgba(0,0,0,0.3);
            padding: 8px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="user_dashboard.php">📚 Library Management System</a>
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

    <div class="container mt-3">
        <marquee>📢 Search for books by title, author, or book number.</marquee>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="search-card">
                    <h4 class="text-center mb-4">🔍 Search Books</h4>
                    <form method="post">
                        <div class="input-group">
                            <input type="text" name="search_text" class="form-control" placeholder="Enter book name, author, or number..." value="<?php echo htmlspecialchars($search_query); ?>" required>
                            <button type="submit" name="search" class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    <?php if (isset($_POST['search'])): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mt-4">
                                <thead>
                                    <tr>
                                        <th>Book No</th>
                                        <th>Book Name</th>
                                        <th>Author</th>
                                        <th>Price (₹)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($search_result) > 0) {
                                        while ($row = mysqli_fetch_assoc($search_result)) {
                                            echo "<tr>
                                                    <td>{$row['book_no']}</td>
                                                    <td>{$row['book_name']}</td>
                                                    <td>{$row['author_name']}</td>
                                                    <td>{$row['book_price']}</td>
                                                  </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center text-muted'>No books found matching your search.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
