<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin'){
    header("Location: index.php");
    exit();
}

$message = "";
$msg_type = "";

if(isset($_POST['borrow_book'])){
    $target_user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    
    // ===== 1. පළමුව Reservation එක Complete කරන්න (Pending එකක් තිබේ නම්) =====
    $check_res = mysqli_query($conn, "SELECT reservation_id FROM Reservation WHERE user_id='$target_user_id' AND book_id='$book_id' AND status='Pending'");
    if(mysqli_num_rows($check_res) > 0){
        $res_row = mysqli_fetch_assoc($check_res);
        $res_id = $res_row['reservation_id'];
        mysqli_query($conn, "UPDATE Reservation SET status = 'Completed' WHERE reservation_id = '$res_id'");
    }

    // ===== 2. ඉන්පසු පොත Borrow කිරීමට පෙර Stock එක පරීක්ෂා කිරීම =====
    $check_qty = mysqli_query($conn, "SELECT quantity FROM Books WHERE book_id = '$book_id'");
    $book_data = mysqli_fetch_assoc($check_qty);
    
    if($book_data['quantity'] > 0){
        // ===== 3. මේ Member ගේ Borrow ගණන පරීක්ෂා කිරීම =====
        $count_borrow = mysqli_query($conn, "SELECT COUNT(*) as total FROM Borrow WHERE user_id = '$target_user_id' AND status = 'Borrowed'");
        $count_row = mysqli_fetch_assoc($count_borrow);
        $current_borrow_count = $count_row['total'];

        if($current_borrow_count >= 5){
            $message = "❌ Limit exceeded! This member cannot borrow more than 5 books.";
            $msg_type = "danger";
        } else {
            // ===== 4. අවසානයේ: මේ පොතේ පිටපතක් දැනටමත් Borrow කරලා තියෙනවාද? =====
            // මෙය කරන්නේ Reservation Complete වීමෙන් පසුවයි.
            $check_duplicate = mysqli_query($conn, "SELECT * FROM Borrow WHERE book_id = '$book_id' AND status = 'Borrowed' AND user_id != '$target_user_id'");
            if(mysqli_num_rows($check_duplicate) > 0){
                $message = "❌ Sorry, this book is currently borrowed by another member!";
                $msg_type = "danger";
            } else {
                // ===== 5. Borrow කිරීමේ ක්‍රියාවලිය =====
                $borrow_date = date('Y-m-d');
                $sql = "INSERT INTO Borrow (user_id, book_id, borrow_date, status) VALUES ('$target_user_id', '$book_id', '$borrow_date', 'Borrowed')";
                
                if(mysqli_query($conn, $sql)){
                    mysqli_query($conn, "UPDATE Books SET quantity = quantity - 1 WHERE book_id = '$book_id'");
                    
                    $new_borrow_id = mysqli_insert_id($conn);
                    $initial_fine = 0.00;
                    mysqli_query($conn, "INSERT INTO Fine (borrow_id, amount, status) VALUES ('$new_borrow_id', '$initial_fine', 'Unpaid')");
                    
                    $message = "✅ Book Borrowed successfully! (By Librarian)";
                    $msg_type = "success";
                } else {
                    $message = "❌ Error: " . mysqli_error($conn);
                    $msg_type = "danger";
                }
            }
        }
    } else {
        $message = "❌ Sorry, this book is out of stock!";
        $msg_type = "danger";
    }
}

// ===== 6. All Members සහ All Books ලැයිස්තුව =====
$users_list = mysqli_query($conn, "SELECT * FROM Users WHERE role='Member'");
$books_list = mysqli_query($conn, "SELECT * FROM Books WHERE quantity > 0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Borrow Book</title>
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
            <h2 class="m-0">Borrow Book</h2>
        </div>

        <?php if(!empty($message)): ?>
            <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                <?php echo $message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <h5><i class="fas fa-hand-holding-heart me-2"></i> Borrow a Book</h5>
            <form method="POST" action="">
                <div class="mb-3">
                    <label class="fw-bold">Select Member</label>
                    <select name="user_id" class="form-select" required>
                        <option value="">-- Choose Member --</option>
                        <?php while($u = mysqli_fetch_assoc($users_list)): ?>
                            <option value="<?php echo $u['user_id']; ?>"><?php echo $u['name']; ?> (ID: <?php echo $u['user_id']; ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="fw-bold">Select Book</label>
                    <select name="book_id" class="form-select" required>
                        <option value="">-- Choose Book --</option>
                        <?php while($b = mysqli_fetch_assoc($books_list)): ?>
                            <option value="<?php echo $b['book_id']; ?>"><?php echo $b['title']; ?> (Stock: <?php echo $b['quantity']; ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <button type="submit" name="borrow_book" class="btn-submit"><i class="fas fa-hand-holding-heart me-2"></i> Borrow Book</button>
            </form>
        </div>

        <div class="mt-3 text-center">
            <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a>
        </div>
    </div>
</body>
</html>