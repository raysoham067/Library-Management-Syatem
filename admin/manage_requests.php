<?php
session_start();

// ✅ Database Connection
$connection = mysqli_connect("localhost", "root", "", "library_db");
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// ✅ Handle Approve / Reject actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $id = (int) $_GET['id'];

    if ($action === 'approve') {
        // Fetch request info first
        $req = mysqli_query($connection, "SELECT * FROM book_requests WHERE request_id = $id");
        $request = mysqli_fetch_assoc($req);

        if ($request && $request['status'] === 'Pending') {
            $student_id = $request['student_id'];
            $book_name = mysqli_real_escape_string($connection, $request['book_name']);
            $author_name = mysqli_real_escape_string($connection, $request['author_name']);

            // ✅ Step 1: Update request status
            mysqli_query($connection, "UPDATE book_requests SET status='Approved' WHERE request_id=$id");

            // ✅ Step 2: Find book_no (if book already exists)
            $book_q = mysqli_query($connection, "SELECT book_no FROM books WHERE LOWER(TRIM(book_name)) = LOWER(TRIM('$book_name')) LIMIT 1");
            $book = mysqli_fetch_assoc($book_q);
            $book_no = $book ? $book['book_no'] : rand(1000, 9999); // fallback random number

            // ✅ Step 3: Insert into issued_books
            $insert = "
                INSERT INTO issued_books (student_id, book_no, book_name, issue_date, status)
                VALUES ('$student_id', '$book_no', '$book_name', NOW(), 1)
            ";
            mysqli_query($connection, $insert);
        }

    } elseif ($action === 'reject') {
        mysqli_query($connection, "UPDATE book_requests SET status='Rejected' WHERE request_id=$id");
    }

    header("Location: manage_requests.php");
    exit;
}

// ✅ Fetch all requests
$query = "
    SELECT r.*, u.name AS student_name, u.email 
    FROM book_requests r
    LEFT JOIN users u ON r.student_id = u.id
    ORDER BY r.request_date DESC
";
$result = mysqli_query($connection, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Book Requests | LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            font-family: 'Poppins', sans-serif;
            color: #333;
            min-height: 100vh;
            padding: 40px 0;
        }

        .container-box {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            padding: 25px;
            margin-top: 40px;
        }

        h3 {
            color: #4e54c8;
            font-weight: 600;
        }

        .table th {
            background-color: #4e54c8;
            color: #fff;
            text-align: center;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .btn-action {
            border-radius: 8px;
            padding: 6px 10px;
            font-weight: 500;
        }

        .btn-approve {
            background-color: #28a745;
            color: white;
        }

        .btn-reject {
            background-color: #dc3545;
            color: white;
        }

        .btn-approve:hover { background-color: #218838; }
        .btn-reject:hover { background-color: #c82333; }

        .status-badge {
            font-size: 0.9rem;
            padding: 6px 12px;
            border-radius: 8px;
        }

        .badge-pending { background: #ffc107; color: #000; }
        .badge-approved { background: #28a745; color: #fff; }
        .badge-rejected { background: #dc3545; color: #fff; }

        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            transition: 0.3s;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="container-box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>📩 Book Requests</h3>
            <a href="admin_dashboard.php" class="btn-back">⬅ Back to Dashboard</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student</th>
                        <th>Email</th>
                        <th>Book Name</th>
                        <th>Author</th>
                        <th>Requested At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['request_id']) ?></td>
                                <td><?= htmlspecialchars($row['student_name'] ?? 'Unknown') ?></td>
                                <td><?= htmlspecialchars($row['email'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($row['book_name']) ?></td>
                                <td><?= htmlspecialchars($row['author_name']) ?></td>
                                <td><?= htmlspecialchars($row['request_date']) ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Pending'): ?>
                                        <span class="status-badge badge-pending">Pending</span>
                                    <?php elseif ($row['status'] == 'Approved'): ?>
                                        <span class="status-badge badge-approved">Approved</span>
                                    <?php else: ?>
                                        <span class="status-badge badge-rejected">Rejected</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['status'] == 'Pending'): ?>
                                        <a href="manage_requests.php?action=approve&id=<?= $row['request_id'] ?>" class="btn btn-approve btn-sm btn-action">Approve</a>
                                        <a href="manage_requests.php?action=reject&id=<?= $row['request_id'] ?>" class="btn btn-reject btn-sm btn-action">Reject</a>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center text-muted">No book requests found</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
