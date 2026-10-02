<?php
include 'config.php';
include 'includes/header.php';

// වැඩිපුරම ණයට ගත් පොත් 10 (LIMIT 10)
$most_borrowed_query = mysqli_query($conn, "SELECT bk.title, bk.author, COUNT(b.borrow_id) as borrow_count 
                                            FROM Borrow b 
                                            JOIN Books bk ON b.book_id = bk.book_id 
                                            GROUP BY b.book_id 
                                            ORDER BY borrow_count DESC 
                                            LIMIT 10");
?>
<style>
    body { background-color: #f4f7fc; font-family: 'Segoe UI', sans-serif; }
    .page-title { border-left: 6px solid #f093fb; padding-left: 15px; font-weight: 700; color: #f093fb; margin-bottom: 30px; display: flex; align-items: center; }
    .page-title i { color: #f093fb; margin-right: 10px; }
    .table-container { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
    .table { margin-bottom: 0; overflow: hidden; }
    .table thead th { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none; padding: 15px; }
    .table tbody tr { transition: 0.2s; }
    .table tbody tr:hover { background-color: #f8fbff; transform: scale(1.005); }
    .table tbody td { padding: 15px; vertical-align: middle; }
    .badge-count { background: #f093fb; color: white; padding: 5px 12px; border-radius: 20px; font-weight: 600; }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container mt-5 mb-5">
    <div class="page-title">
        <i class="fas fa-trophy"></i>
        <h2 class="m-0">Most Borrowed Books</h2>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Times Borrowed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($most_borrowed_query) > 0): ?>
                        <?php $rank = 1; ?>
                        <?php while($row = mysqli_fetch_assoc($most_borrowed_query)): ?>
                        <tr>
                            <td><span class="badge bg-light text-dark border"><?php echo $rank++; ?></span></td>
                            <td><b><?php echo $row['title']; ?></b></td>
                            <td><?php echo $row['author']; ?></td>
                            <td><span class="badge-count"><i class="fas fa-book-reader me-1"></i> <?php echo $row['borrow_count']; ?> times</span></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No borrowing data available yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>