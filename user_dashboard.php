<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Member'){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// 1. පරිශීලකයාගේ ණයට ගත් පොත් ලැයිස්තුව
$my_books = mysqli_query($conn, "SELECT bk.title, b.borrow_date, b.return_date, b.status 
                                 FROM Borrow b JOIN Books bk ON b.book_id = bk.book_id 
                                 WHERE b.user_id = '$user_id'");

// 2. පරිශීලකයාගේ Reservations ලැයිස්තුව
$my_reservations = mysqli_query($conn, "SELECT bk.title, r.reservation_date, r.status 
                                       FROM Reservation r 
                                       JOIN Books bk ON r.book_id = bk.book_id 
                                       WHERE r.user_id = '$user_id'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .navbar-brand, .nav-link { color: #ffffff !important; font-weight: 500; }
        
        .welcome-section { background: white; padding: 25px; border-radius: 20px; border-left: 8px solid #11998e; box-shadow: 0 4px 6px rgba(0,0,0,0.05); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; }
        .welcome-text { font-size: 26px; font-weight: 700; color: #11998e; }
        
        .main-card { border: none; border-radius: 20px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); overflow: hidden; }
        .main-card .card-header { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border: none; padding: 18px 25px; font-size: 18px; font-weight: 600; }
        
        .table thead th { background: #e9ecef; color: #495057; font-weight: 600; border: none; padding: 15px; }
        .table tbody tr { transition: 0.2s; }
        .table tbody tr:hover { background-color: #f8f9fa; }
        .table tbody td { padding: 15px; vertical-align: middle; }
        
        .status-badge-active { background: #ffc107; color: #212529; padding: 5px 15px; border-radius: 20px; font-weight: 600; }
        .status-badge-returned { background: #198754; color: white; padding: 5px 15px; border-radius: 20px; font-weight: 600; }
        .empty-state { text-align: center; padding: 50px 0; color: #6c757d; }
        .empty-state i { font-size: 60px; color: #dee2e6; margin-bottom: 15px; }
        .res-status-badge { padding: 3px 10px; border-radius: 15px; font-size: 12px; font-weight: 600; }
        .res-status-badge.completed { background: #198754; color: white; }
        .res-status-badge.pending { background: #ffc107; color: #212529; }
        .res-status-badge.expired { background: #dc3545; color: white; }
        .res-status-badge.cancelled { background: #6c757d; color: white; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="user_dashboard.php"><i class="fas fa-user-graduate me-2"></i> My Library</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="user_dashboard.php"><i class="fas fa-home me-1"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_books.php"><i class="fas fa-book me-1"></i> Browse Books</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="welcome-section">
            <div>
                <div class="welcome-text">Hello, <?php echo $_SESSION['name']; ?>! 📚</div>
                <small class="text-muted">Welcome to your personal library space.</small>
            </div>
        </div>
        
        <!-- Borrowed Books List -->
        <div class="card main-card shadow-sm">
            <div class="card-header">
                <i class="fas fa-list-ul me-2"></i> My Borrowed Books
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Borrow Date</th>
                                <th>Return Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($my_books) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($my_books)): ?>
                                <tr>
                                    <td><b><?php echo $row['title']; ?></b></td>
                                    <td><?php echo $row['borrow_date']; ?></td>
                                    <td>
                                        <?php echo $row['return_date'] ? $row['return_date'] : '<span class="text-warning fw-bold">Not Returned</span>'; ?>
                                    </td>
                                    <td>
                                        <?php if($row['status'] == 'Borrowed'): ?>
                                            <span class="status-badge-active"><i class="fas fa-spinner me-1"></i> Active</span>
                                        <?php else: ?>
                                            <span class="status-badge-returned"><i class="fas fa-check-circle me-1"></i> Returned</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="empty-state">
                                        <i class="fas fa-book-open"></i><br>
                                        You haven't borrowed any books yet. 
                                        <br><a href="view_books.php" class="btn btn-outline-success mt-3 rounded-pill">Browse Books</a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- My Reservations List -->
        <div class="card main-card shadow-sm mt-5">
            <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <i class="fas fa-calendar-check me-2"></i> My Reservations
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Book Title</th>
                                <th>Reservation Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($my_reservations) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($my_reservations)): ?>
                                <tr>
                                    <td><b><?php echo $row['title']; ?></b></td>
                                    <td><?php echo $row['reservation_date']; ?></td>
                                    <td>
                                        <?php if($row['status'] == 'Completed'): ?>
                                            <span class="res-status-badge completed">Completed</span>
                                        <?php elseif($row['status'] == 'Pending'): ?>
                                            <span class="res-status-badge pending">Pending</span>
                                        <?php elseif($row['status'] == 'Expired'): ?>
                                            <span class="res-status-badge expired">Expired</span>
                                        <?php else: ?>
                                            <span class="res-status-badge cancelled">Cancelled</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">You have no active reservations.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>