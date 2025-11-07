<?php
session_start();

// ✅ Database Connection
$connection = mysqli_connect("localhost", "root", "", "library_db");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// ✅ Fetch issued books (smart join: book_no + fallback book_name)
$query = "
    SELECT 
        ib.book_name AS issued_name,
        ib.book_no AS issued_no,
        a.author_name,
        b.book_pdf
    FROM issued_books ib
    LEFT JOIN books b 
        ON CAST(ib.book_no AS CHAR) = CAST(b.book_no AS CHAR)
        OR LOWER(TRIM(ib.book_name)) = LOWER(TRIM(b.book_name))
    LEFT JOIN authors a 
        ON b.author_id = a.author_id
    WHERE ib.student_id = '{$_SESSION['id']}' AND ib.status = 1
";
$query_run = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Issued Books | LMS</title>

    <!-- ✅ Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            background-attachment: fixed;
            font-family: "Poppins", sans-serif;
            color: #212529;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.85) !important;
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.3);
        }

        .table-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            backdrop-filter: blur(8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 40px;
        }

        table th {
            background: #4e54c8;
            color: #fff;
            text-align: center;
        }

        table td {
            text-align: center;
            background: #ffffff;
            vertical-align: middle;
        }

        .btn-view {
            background-color: #007bff;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-view:hover {
            background-color: #0056b3;
        }

        .btn-download {
            background-color: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-download:hover {
            background-color: #1f8a3a;
        }

        .btn-nopdf {
            background-color: #dc3545;
            color: white;
            padding: 6px 12px;
            border-radius: 5px;
            font-weight: 500;
        }

        .pdf-thumbnail {
            width: 35px;
            height: 35px;
            object-fit: contain;
        }

        marquee {
            color: #fff;
            font-weight: 500;
            background: rgba(0, 0, 0, 0.2);
            padding: 8px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<!-- ✅ Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="user_dashboard.php">📚 Library Management System</a>
        <div class="d-flex align-items-center text-white me-3">
            <span class="me-3"><strong>Welcome:</strong> <?= htmlspecialchars($_SESSION['name']); ?></span>
            <span><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']); ?></span>
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
<div class="container mt-3">
    <marquee>📢 Library is open from 8:00 AM to 8:00 PM. Please return your books on time.</marquee>
</div>

<!-- ✅ Issued Books Table -->
<div class="container table-container">
    <div class="text-center mb-4">
        <h4>📖 Issued Book Details</h4>
        <hr style="border: 2px solid #4e54c8; width: 80px; margin: 0 auto;">
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr>
                    <th>Book Name</th>
                    <th>Author</th>
                    <th>Book Number</th>
                    <th>PDF</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($query_run) > 0) {
                    while ($row = mysqli_fetch_assoc($query_run)) {
                        $pdf_path = "uploads/books_pdf/" . $row['book_pdf']; // ✅ Correct path
                        echo "<tr>
                            <td>" . htmlspecialchars($row['issued_name']) . "</td>
                            <td>" . htmlspecialchars($row['author_name']) . "</td>
                            <td>" . htmlspecialchars($row['issued_no']) . "</td>";

                        if (!empty($row['book_pdf']) && file_exists($pdf_path)) {
                            // ✅ PDF column: show View PDF button
                            echo "
                                <td>
                                    <a href='$pdf_path' target='_blank' class='btn btn-primary btn-sm'>
                                        <i class='bi bi-eye'></i> View PDF
                                    </a>
                                </td>
                                <td>
                                    <a href='$pdf_path' download class='btn btn-success btn-sm'>
                                        <i class='bi bi-download'></i> Download
                                    </a>
                                </td>
                            ";
                        } else {
                            echo "
                                <td><span class='text-muted'>—</span></td>
                                <td><span class='btn-nopdf'>No PDF</span></td>
                            ";
                        }

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center text-muted'>No issued books found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
