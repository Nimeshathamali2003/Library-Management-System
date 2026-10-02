<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin'){
    header("Location: index.php");
    exit();
}

$message = "";
$msg_type = "";

// ===== 1. Form එක හරහා Return කිරීම =====
if(isset($_POST['return_book'])){
    $borrow_id = mysqli_real_escape_string($conn, $_POST['borrow_id']);
    
    $get_data = mysqli_query($conn, "SELECT book_id FROM Borrow WHERE borrow_id = '$borrow_id' AND status = 'Borrowed'");
    if(mysqli_num_rows($get_data) == 0){
        $message = "❌ Invalid Borrow ID or book already returned!";
        $msg_type = "danger";
    } else {
        $data = mysqli_fetch_assoc($get_data);
        $book_id = $data['book_id'];

        $update_sql = "UPDATE Borrow SET return_date = CURDATE(), status = 'Returned' WHERE borrow_id = '$borrow_id'";
        if(mysqli_query($conn, $update_sql)){
            mysqli_query($conn, "UPDATE Books SET quantity = quantity + 1 WHERE book_id = '$book_id'");
            $message = "✅ Book Returned successfully! (By Librarian)";
            $msg_type = "success";
        } else {
            $message = "❌ Error: " . mysqli_error($conn);
            $msg_type = "danger";
        }
    }
}

// ===== 2. Active Borrowings List (Dropdown එකට පෙන්වීමට) =====
$active_borrowings = mysqli_query($conn, "SELECT b.borrow_id, u.name as user_name, bk.title 
        FROM Borrow b 
        JOIN Users u ON b.user_id = u.user_id 
        JOIN Books bk ON b.book_id = bk.book_id 
        WHERE b.status = 'Borrowed'
        ORDER BY b.borrow_id ASC");

// ===== 3. Returned Borrowings List (Return කළ පසු පෙන්වීමට) =====
$returned_borrowings = mysqli_query($conn, "SELECT b.borrow_id, u.name as user_name, bk.title, b.return_date 
        FROM Borrow b 
        JOIN Users u ON b.user_id = u.user_id 
        JOIN Books bk ON b.book_id = bk.book_id 
        WHERE b.status = 'Returned'
        ORDER BY b.return_date DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Return Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7fc; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .navbar-brand, .nav-link { color: #ffffff !important; font-weight: 500; }
        .page-title { border-left: 6px solid #302b63; padding-left: 15px; font-weight: 700; color: #302b63; margin-bottom: 30px; display: flex; align-items: center; }
        .page-title i { color: #302b63; margin-right: 10px; }
        .form-card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); max-width: 600px; margin: 0 auto; }
        .form-card h5 { color: #302b63; font-weight: 700; }
        .btn-submit { background: #ffc107; color: #212529; padding: 12px; border-radius: 25px; font-weight: 600; width: 100%; transition: 0.3s; }
        .btn-submit:hover { transform: scale(1.05); color: #212529; }
        .table-container { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .table { margin-bottom: 0; overflow: hidden; }
        .table thead th { background: linear-gradient(135deg, #0f0c29 0%, #302b63 100%); color: white; border: none; padding: 15px; }
        .table tbody tr { transition: 0.2s; }
        .table tbody tr:hover { background-color: #f8fbff; transform: scale(1.005); }
        .table tbody td { padding: 15px; vertical-align: middle; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php"><i class="fas fa-shield-alt"></i> Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_books.php"><i class="fas fa-book"></i> Books</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="page-title">
            <i class="fas fa-undo-alt"></i>
            <h2 class="m-0">Return Books</h2>
        </div>

        <?php if(!empty($message)): ?>
            <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Dropdown Form -->
        <div class="form-card mb-5">
            <h5><i class="fas fa-undo-alt me-2"></i> Return a Book</h5>
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="fw-bold">Select Borrowing Record</label>
                    <select name="borrow_id" class="form-select" required>
                        <option value="">-- Choose Member & Book --</option>
                        <?php while($row = mysqli_fetch_assoc($active_borrowings)): ?>
                            <option value="<?php echo $row['borrow_id']; ?>">
                                <?php echo $row['user_name']; ?> - <?php echo $row['title']; ?> (ID: <?php echo $row['borrow_id']; ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" name="return_book" class="btn-submit"><i class="fas fa-undo-alt me-2"></i> Return Book</button>
            </form>
        </div>

        <!-- Returned Books List -->
        <div class="table-container">
            <h5 class="mb-3 text-success"><i class="fas fa-check-circle me-2"></i> Recently Returned Books</h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>User</th>
                            <th>Book</th>
                            <th>Return Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($returned_borrowings) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($returned_borrowings)): ?>
                            <tr>
                                <td><span class="badge bg-light text-dark border"><?php echo $row['borrow_id']; ?></span></td>
                                <td><b><?php echo $row['user_name']; ?></b></td>
                                <td><?php echo $row['title']; ?></td>
                                <td><?php echo $row['return_date']; ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">No books returned yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3 text-center">
            <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a>
        </div>
    </div>
</body>
</html>