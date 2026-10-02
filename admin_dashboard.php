<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin'){
    header("Location: index.php");
    exit();
}

$book_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM Books"))['total'];
$user_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM Users"))['total'];
$borrow_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM Borrow WHERE status='Borrowed'"))['total'];
$fine_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM Fine"))['total'];
$reserve_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM Reservation"))['total'];

$books_list = mysqli_query($conn, "SELECT * FROM Books ORDER BY book_id ASC");
$users_list = mysqli_query($conn, "SELECT * FROM Users ORDER BY user_id ASC");
$loans_list = mysqli_query($conn, "SELECT u.name as user_name, bk.title, b.borrow_date 
                                   FROM Borrow b 
                                   JOIN Users u ON b.user_id = u.user_id 
                                   JOIN Books bk ON b.book_id = bk.book_id 
                                   WHERE b.status = 'Borrowed'
                                   ORDER BY b.borrow_date ASC");
$fines_list = mysqli_query($conn, "SELECT u.name as user_name, bk.title, f.amount, f.fine_id 
                                   FROM Fine f 
                                   JOIN Borrow b ON f.borrow_id = b.borrow_id 
                                   JOIN Users u ON b.user_id = u.user_id 
                                   JOIN Books bk ON b.book_id = bk.book_id 
                                   ORDER BY f.fine_id ASC");

$res_query = mysqli_query($conn, "SELECT u.name as user_name, bk.title, r.reservation_date, r.status 
                                  FROM Reservation r 
                                  JOIN Users u ON r.user_id = u.user_id 
                                  JOIN Books bk ON r.book_id = bk.book_id 
                                  ORDER BY r.reservation_date DESC");

// Most Borrowed Books Query
$most_borrowed_query = mysqli_query($conn, "SELECT bk.title, COUNT(b.borrow_id) as borrow_count 
                                            FROM Borrow b 
                                            JOIN Books bk ON b.book_id = bk.book_id 
                                            GROUP BY b.book_id 
                                            ORDER BY borrow_count DESC 
                                            LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7fc; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .navbar-brand, .nav-link { color: #ffffff !important; font-weight: 500; }
        .stat-card { border: none; border-radius: 20px; padding: 25px 20px; color: white; transition: 0.3s; box-shadow: 0 4px 6px rgba(0,0,0,0.1); position: relative; overflow: hidden; }
        .stat-card:hover { transform: translateY(-10px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
        .stat-card i { font-size: 50px; position: absolute; right: 15px; top: 20px; opacity: 0.15; }
        .bg-gradient-1 { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .bg-gradient-2 { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .bg-gradient-3 { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .bg-gradient-4 { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }
        .bg-gradient-5 { background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%); }
        .welcome-text { font-size: 28px; font-weight: 700; color: #302b63; }
        .admin-tools-card { background: white; border-radius: 20px; padding: 25px; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .admin-tools-card h5 { color: #302b63; font-weight: 700; }
        .btn-custom { border-radius: 25px; font-weight: 600; padding: 10px 20px; transition: 0.3s; }
        .btn-custom:hover { transform: scale(1.05); }

        .detail-section {
            display: none;
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-top: 30px;
            animation: fadeIn 0.5s ease;
        }
        .detail-section.active { display: block; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .detail-section h4 {
            font-weight: 700;
            color: #302b63;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .detail-section table { margin-bottom: 0; }
        .detail-section table thead th { background: #f1f3f5; color: #495057; border: none; }
        .detail-section table tbody td { padding: 12px 15px; }

        /* Most Borrowed Books Card */
        .most-borrowed-container {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-top: 30px;
        }
        .most-borrowed-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #f093fb;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .most-borrowed-header h5 { color: #302b63; font-weight: 700; margin: 0; display: flex; align-items: center; gap: 10px; }
        .most-borrowed-header h5 i { color: #f5576c; }
        .most-borrowed-container table { margin-bottom: 0; }
        .most-borrowed-container table thead th { background: #f8f9fa; color: #495057; border: none; font-weight: 600; }
        .badge-count { background: #f093fb; color: white; padding: 5px 12px; border-radius: 20px; font-weight: 600; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-shield-alt"></i> Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_books.php"><i class="fas fa-book"></i> Books</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php"><i class="fas fa-users"></i> Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="active_borrowings.php"><i class="fas fa-hand-holding-heart"></i> Active Borrowings</a></li>
                    <li class="nav-item"><a class="nav-link" href="overdue_books.php"><i class="fas fa-exclamation-triangle"></i> Overdue Books</a></li>
                    <li class="nav-item"><a class="nav-link" href="fine_calculation.php"><i class="fas fa-coins"></i> Fine Calculation</a></li>
                    <li class="nav-item"><a class="nav-link" href="return_book.php"><i class="fas fa-undo-alt"></i> Return Books</a></li>
                    <li class="nav-item"><a class="nav-link" href="damaged_books.php"><i class="fas fa-exclamation-circle"></i> Damaged Books</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5 mb-5">
        <div class="mb-4 p-4 bg-white rounded shadow-sm border-start border-5 border-primary">
            <div class="welcome-text">Welcome Admin, <?php echo $_SESSION['name']; ?>! 👑</div>
        </div>
        
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card bg-gradient-1" onclick="showDetails('booksSection')">
                    <i class="fas fa-book"></i>
                    <h5>Total Books</h5>
                    <h2><?php echo $book_count; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-gradient-2" onclick="showDetails('usersSection')">
                    <i class="fas fa-users"></i>
                    <h5>Registered Users</h5>
                    <h2><?php echo $user_count; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-gradient-3" onclick="showDetails('loansSection')">
                    <i class="fas fa-hand-holding-heart"></i>
                    <h5>Active Loans</h5>
                    <h2><?php echo $borrow_count; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-gradient-4" onclick="showDetails('finesSection')">
                    <i class="fas fa-coins"></i>
                    <h5>Total Fines</h5>
                    <h2><?php echo $fine_count; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-gradient-5" onclick="showDetails('reservationsSection')">
                    <i class="fas fa-calendar-check"></i>
                    <h5>Reservations</h5>
                    <h2><?php echo $reserve_count; ?></h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="admin-tools-card">
                    <h5><i class="fas fa-cogs me-2 text-primary"></i> Admin Tools</h5>
                    <a href="add_book.php" class="btn btn-primary btn-custom w-100 mb-2"><i class="fas fa-plus-circle me-1"></i> Add New Book</a>
                    <a href="users.php" class="btn btn-success btn-custom w-100"><i class="fas fa-user-plus me-1"></i> Manage Users</a>
                </div>
            </div>
        </div>

        <div id="booksSection" class="detail-section">
            <h4><i class="fas fa-book me-2 text-primary"></i> Books List</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>ID</th><th>Title</th><th>Author</th><th>Quantity</th></tr></thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($books_list)): ?>
                        <tr><td><?php echo $row['book_id']; ?></td><td><b><?php echo $row['title']; ?></b></td><td><?php echo $row['author']; ?></td><td><?php echo $row['quantity']; ?></td></tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="usersSection" class="detail-section">
            <h4><i class="fas fa-users me-2 text-secondary"></i> Users List</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th></tr></thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($users_list)): ?>
                        <tr><td><?php echo $row['user_id']; ?></td><td><b><?php echo $row['name']; ?></b></td><td><?php echo $row['email']; ?></td><td><span class="badge bg-primary"><?php echo $row['role']; ?></span></td></tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="loansSection" class="detail-section">
            <h4><i class="fas fa-hand-holding-heart me-2 text-success"></i> Active Loans List</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>User</th><th>Book</th><th>Borrow Date</th></tr></thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($loans_list)): ?>
                        <tr><td><b><?php echo $row['user_name']; ?></b></td><td><?php echo $row['title']; ?></td><td><?php echo $row['borrow_date']; ?></td></tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="finesSection" class="detail-section">
            <h4><i class="fas fa-coins me-2 text-warning"></i> Fines List</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead><tr><th>User</th><th>Book</th><th>Amount</th></tr></thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($fines_list)): ?>
                        <tr><td><b><?php echo $row['user_name']; ?></b></td><td><?php echo $row['title']; ?></td><td><span class="badge bg-danger">LKR <?php echo $row['amount']; ?></span></td></tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="reservationsSection" class="detail-section">
            <h4><i class="fas fa-calendar-check me-2 text-purple"></i> Reservations List</h4>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Book</th>
                            <th>Reservation Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($res_query)): ?>
                        <tr>
                            <td><b><?php echo $row['user_name']; ?></b></td>
                            <td><?php echo $row['title']; ?></td>
                            <td><?php echo $row['reservation_date']; ?></td>
                            <td>
                                <?php if($row['status'] == 'Completed'): ?>
                                    <span class="badge bg-success">Completed</span>
                                <?php elseif($row['status'] == 'Pending'): ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php elseif($row['status'] == 'Expired'): ?>
                                    <span class="badge bg-secondary">Expired</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Cancelled</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Most Borrowed Books Button Card -->
        <div class="most-borrowed-container">
            <div class="most-borrowed-header">
                <h5><i class="fas fa-trophy"></i> Most Borrowed Books</h5>
                <a href="most_borrowed.php" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                    <i class="fas fa-arrow-right me-1"></i> View All
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Times Borrowed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($most_borrowed_query) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($most_borrowed_query)): ?>
                            <tr>
                                <td><b><?php echo $row['title']; ?></b></td>
                                <td><span class="badge-count"><?php echo $row['borrow_count']; ?> times</span></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="2" class="text-center py-3 text-muted">No borrowing data available yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function showDetails(sectionId) {
            var sections = document.getElementsByClassName('detail-section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].classList.remove('active');
            }
            var selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.classList.add('active');
                selectedSection.scrollIntoView({ behavior: 'smooth' });
            }
        }
    </script>
</body>
</html>