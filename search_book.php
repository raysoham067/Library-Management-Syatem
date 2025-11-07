<?php
session_start();

// ✅ Database connection
$connection = mysqli_connect("localhost", "root", "", "library_db");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// ✅ Handle search input
$search_query = "";
if (isset($_POST['search'])) {
    $search_query = trim($_POST['search_query']);
}

// ✅ Build query with joins
if ($search_query != "") {
    $query = "
        SELECT b.book_id, b.book_name, a.author_name, c.cat_name, b.book_no, b.book_price
        FROM books b
        LEFT JOIN authors a ON b.author_id = a.author_id
        LEFT JOIN category c ON b.cat_id = c.cat_id
        WHERE b.book_name LIKE '%$search_query%'
           OR a.author_name LIKE '%$search_query%'
           OR c.cat_name LIKE '%$search_query%'";
} else {
    $query = "
        SELECT b.book_id, b.book_name, a.author_name, c.cat_name, b.book_no, b.book_price
        FROM books b
        LEFT JOIN authors a ON b.author_id = a.author_id
        LEFT JOIN category c ON b.cat_id = c.cat_id";
}

$query_run = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Books | Library Management System</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        font-family: "Poppins", sans-serif;
        background: linear-gradient(135deg, #3b82f6, #9333ea);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .search-box {
        width: 90%;
        max-width: 950px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        backdrop-filter: blur(12px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        padding: 40px;
        color: #fff;
    }

    .search-box h3 {
        text-align: center;
        margin-bottom: 25px;
        font-weight: 600;
        letter-spacing: 1px;
        color: #fff;
    }

    .input-group input {
        border-radius: 10px 0 0 10px !important;
        padding: 12px;
        font-size: 1rem;
    }

    .btn-search {
        border-radius: 0 10px 10px 0 !important;
        background-color: #2563eb;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-search:hover {
        background-color: #1e40af;
        transform: scale(1.05);
    }

    table {
        margin-top: 25px;
        border-radius: 10px;
        overflow: hidden;
    }

    thead th {
        background-color: rgba(255, 255, 255, 0.2);
        color: #fff;
        text-transform: uppercase;
        font-weight: 600;
    }

    tbody tr {
        background-color: rgba(255, 255, 255, 0.15);
        color: #fff;
        transition: 0.3s;
    }

    tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.3);
        transform: scale(1.01);
    }

    .alert {
        background-color: rgba(255, 255, 255, 0.2);
        color: #fff;
        border: none;
    }
</style>
</head>

<body>
<div class="search-box">
    <h3>🔍 Search Books</h3>
    <form method="POST" action="">
        <div class="input-group mb-3">
            <input type="text" name="search_query" class="form-control" placeholder="Enter book name, author, or category" value="<?php echo htmlspecialchars($search_query); ?>" required>
            <button class="btn btn-search" type="submit" name="search">Search</button>
        </div>
    </form>

    <div class="table-responsive">
        <?php
        if (mysqli_num_rows($query_run) > 0) {
            echo '<table class="table table-bordered table-striped text-center">';
            echo '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Book Name</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Book No</th>
                        <th>Price (₹)</th>
                    </tr>
                  </thead>
                  <tbody>';
            while ($row = mysqli_fetch_assoc($query_run)) {
                echo "<tr>
                        <td>{$row['book_id']}</td>
                        <td>{$row['book_name']}</td>
                        <td>{$row['author_name']}</td>
                        <td>{$row['cat_name']}</td>
                        <td>{$row['book_no']}</td>
                        <td>{$row['book_price']}</td>
                      </tr>";
            }
            echo '</tbody></table>';
        } else {
            echo '<div class="alert text-center">No books found matching your search.</div>';
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
