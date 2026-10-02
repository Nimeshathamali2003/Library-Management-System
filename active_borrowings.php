<?php
include 'config.php';
include 'includes/header.php';

// තවමත් ආපසු භාර නොදුන් (Borrowed) පොත් පමණක් ලබා ගැනීමට
$sql = "SELECT b.borrow_id, u.name as user_name, bk.title, b.borrow_date, b.return_date, b.status 
        FROM Borrow b 
        JOIN Users u ON b.user_id = u.user_id 
        JOIN Books bk ON b.book_id = bk.book_id 
        WHERE b.status = 'Borrowed'
        ORDER BY b.borrow_date ASC";
$result = mysqli_query($conn, $sql);
?>
<style>
    body { background-color: #f4f7fc; font-family: 'Segoe UI', sans-serif; }
    .page-title { border-left: 6px solid #11998e; padding-left: 15px; font-weight: 700; color: #11998e; margin-bottom: 30px; display: flex; align-items: center; }
    .page-title i { color: #11998e; margin-right: 10px; }
    .table-container { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
    .table { margin-bottom: 0; overflow: hidden; }
    .table thead th { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border: none; padding: 15px; }
    .table tbody tr { transition: 0.2s; }
    .table tbody tr:hover { background-color: #f8fbff; transform: scale(1.005); }
    .table tbody td { padding: 15px; vertical-align: middle; }
    .badge-status-active { background: #ffc107; color: #212529; padding: 5px 12px; border-radius: 20px; font-weight: 600; }
    .text-not-returned { color: #dc3545; font-weight: 600; }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<div class="container mt-5 mb-5">
    <div class="page-title">
        <i class="fas fa-history"></i>
        <h2 class="m-0">Active Borrowings (Not Returned Yet)</h2>
    </div>
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr><th>#ID</th><th>User</th><th>Book</th><th>Borrow Date</th><th>Return Date</th><th>Status</th></tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><span class="badge bg-light text-dark border"><?php echo $row['borrow_id']; ?></span></td>
                        <td><b><?php echo $row['user_name']; ?></b></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['borrow_date']; ?></td>
                        <td>
                            <?php echo $row['return_date'] ? $row['return_date'] : '<span class="text-not-returned"><i class="fas fa-exclamation-circle me-1"></i> Not Returned</span>'; ?>
                        </td>
                        <td>
                            <span class="badge-status-active"><i class="fas fa-spinner me-1"></i> Active</span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>