<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin'){
    header("Location: index.php");
    exit();
}

// Pay Fine ක්‍රියාව
if(isset($_GET['pay_id'])){
    $pay_id = mysqli_real_escape_string($conn, $_GET['pay_id']);
    mysqli_query($conn, "UPDATE Fine SET status = 'Paid' WHERE fine_id = '$pay_id'");
    header("Location: fine_calculation.php");
    exit();
}

// දත්ත එකතු කිරීම (LEFT JOIN මගින් Fine නැති ඒවාත් පෙන්වයි)
$sql = "SELECT b.borrow_id, u.name as user_name, bk.title, b.borrow_date, b.return_date, b.status, f.fine_id, f.amount, f.status as fine_status
        FROM Borrow b 
        JOIN Users u ON b.user_id = u.user_id 
        JOIN Books bk ON b.book_id = bk.book_id 
        LEFT JOIN Fine f ON b.borrow_id = f.borrow_id
        ORDER BY b.borrow_id ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fine Calculations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7fc; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .navbar-brand, .nav-link { color: #ffffff !important; font-weight: 500; }
        .page-title { border-left: 6px solid #f5576c; padding-left: 15px; font-weight: 700; color: #f5576c; margin-bottom: 30px; display: flex; align-items: center; }
        .table-container { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .table { margin-bottom: 0; overflow: hidden; }
        .table thead th { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none; padding: 15px; }
        .table tbody tr { transition: 0.2s; }
        .table tbody tr:hover { background-color: #f8fbff; transform: scale(1.005); }
        .table tbody td { padding: 15px; vertical-align: middle; }
        .badge-unpaid { background: #dc3545; color: white; padding: 5px 12px; border-radius: 20px; font-weight: 600; }
        .badge-paid { background: #198754; color: white; padding: 5px 12px; border-radius: 20px; font-weight: 600; }
        .btn-pay { background: #ffc107; color: #212529; padding: 5px 15px; border-radius: 25px; font-weight: 600; text-decoration: none; transition: 0.3s; }
        .btn-pay:hover { transform: scale(1.05); color: #212529; }
        .btn-paid { background: #e9ecef; color: #6c757d; padding: 5px 15px; border-radius: 25px; font-weight: 600; border: none; cursor: not-allowed; }
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
                    <li class="nav-item"><a class="nav-link" href="users.php"><i class="fas fa-users"></i> Users</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="page-title">
            <i class="fas fa-coins"></i>
            <h2 class="m-0">Fine Calculations</h2>
        </div>
        
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>User</th>
                            <th>Book</th>
                            <th>Borrow Date</th>
                            <th>Return Date</th>
                            <th>Fine Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): 
                            // ===== Fine ගණනය කිරීම =====
                            $fine = 0;
                            
                            // පොත Return කරලා තියෙනවා නම්
                            if($row['return_date']){
                                $borrow_date = new DateTime($row['borrow_date']);
                                $return_date = new DateTime($row['return_date']);
                                $interval = $borrow_date->diff($return_date);
                                $days_borrowed = $interval->days;
                                
                                if($days_borrowed > 7){
                                    $fine = ($days_borrowed - 7) * 50;
                                }
                            }
                            
                            // පොත තවමත් Return කරලා නැත්නම්
                            if($row['status'] == 'Borrowed' && !$row['return_date']){
                                $borrow_date = new DateTime($row['borrow_date']);
                                $current_date = new DateTime();
                                $interval = $borrow_date->diff($current_date);
                                $days_borrowed = $interval->days;
                                
                                if($days_borrowed > 7){
                                    $fine = ($days_borrowed - 7) * 50;
                                }
                            }

                            // Database එකේ Fine දත්ත තිබේ නම්, එය භාවිතා කරන්න
                            if(isset($row['amount']) && $row['amount'] > 0){
                                $fine = $row['amount'];
                            }
                        ?>
                        <tr>
                            <td><span class="badge bg-light text-dark border"><?php echo $row['borrow_id']; ?></span></td>
                            <td><b><?php echo $row['user_name']; ?></b></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['borrow_date']; ?></td>
                            <td>
                                <?php if($row['return_date']): ?>
                                    <?php echo $row['return_date']; ?>
                                <?php else: ?>
                                    <span class="text-danger">Not Returned</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge bg-danger">LKR <?php echo number_format($fine, 2); ?></span></td>
                            <td>
                                <?php if(isset($row['fine_status']) && $row['fine_status'] == 'Paid'): ?>
                                    <span class="badge-paid"><i class="fas fa-check-circle me-1"></i> Paid</span>
                                <?php else: ?>
                                    <span class="badge-unpaid"><i class="fas fa-exclamation-circle me-1"></i> Unpaid</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($fine > 0 && (!isset($row['fine_status']) || $row['fine_status'] == 'Unpaid')): ?>
                                    <a href="fine_calculation.php?pay_id=<?php echo $row['fine_id']; ?>" class="btn-pay" onclick="return confirm('Pay this fine?');">
                                        <i class="fas fa-money-bill-wave me-1"></i> Pay
                                    </a>
                                <?php else: ?>
                                    <button class="btn-paid" disabled><i class="fas fa-check"></i> Completed</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>