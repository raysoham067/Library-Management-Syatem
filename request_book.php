<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,"library_db");

// ✅ If user not logged in, redirect to login
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit;
}

$success = $error = "";

// ✅ When form submitted
if (isset($_POST['submit_request'])) {
    $book_name = trim($_POST['book_name']);
    $author_name = trim($_POST['author_name']);
    $student_id = (int) $_SESSION['id'];

    if (empty($book_name)) {
        $error = "Please enter the book name.";
    } else {
        $book_name_esc = mysqli_real_escape_string($connection, $book_name);
        $author_name_esc = mysqli_real_escape_string($connection, $author_name);

        // ✅ Insert into book_requests
        $query = "
            INSERT INTO book_requests (student_id, book_name, author_name, status)
            VALUES ('$student_id', '$book_name_esc', '$author_name_esc', 'Pending')
        ";

        if (mysqli_query($connection, $query)) {
            $success = "✅ Your book request has been submitted successfully!";
        } else {
            $error = "❌ Database Error: " . mysqli_error($connection);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request a Book | LMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4e54c8, #8f94fb);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .card {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .btn-primary {
            background-color: #4e54c8;
            border: none;
        }
        .btn-primary:hover {
            background-color: #3a3fbb;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
    </style>
</head>
<body>

<div class="card">
    <h4 class="text-center mb-3">📩 Request a New Book</h4>
    <hr>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
        <a href="user_dashboard.php" class="btn btn-primary w-100">Back to Dashboard</a>
    <?php else: ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Book Name <span class="text-danger">*</span></label>
                <input type="text" name="book_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Author Name</label>
                <input type="text" name="author_name" class="form-control">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" name="submit_request" class="btn btn-primary">Submit Request</button>
                <a href="user_dashboard.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
