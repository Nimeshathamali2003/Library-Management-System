<?php
include 'config.php';
include 'includes/header.php';

// හානි වූ පොත් පමණක් ලබා ගැනීම
$sql = "SELECT * FROM Books WHERE status = 'Damaged' ORDER BY book_id ASC";
$result = mysqli_query($conn, $sql);
?>
<style>
    body { background-color: #f4f7fc; font-family: 'Segoe UI', sans-serif; }
    .page-title { border-left: 6px solid #dc3545; padding-left: 15px; font-weight: 700; color: #dc3545; margin-bottom: 30px; display: flex; align-items: center; }
    .page-title i { color: #dc3545; margin-right: 10px; }
    .table-container { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
    .table { margin-bottom: 0; overflow: hidden; }
    .table thead th { background: linear-gradient(135deg, #dc3545 0%, #a71d2a 100%); color: white; border: none; padding: 15px; }
    .table tbody tr { transition: 0.2s; }
    .table tbody tr:hover { background-color: #f8fbff; transform: scale(1.005); }
    .table tbody td { padding: 15px; vertical-align: middle; }
    .badge-damaged { background: #dc3545; color: white; padding: 5px 12px; border-radius: 20px; font-weight: 600; }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container mt-5 mb-5">
    <div class="page-title">
        <i class="fas fa-exclamation-triangle"></i>
        <h2 class="m-0">Damaged Books</h2>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><span class="badge bg-light text-dark border"><?php echo $row['book_id']; ?></span></td>
                            <td><b><?php echo $row['title']; ?></b></td>
                            <td><?php echo $row['author']; ?></td>
                            <td><span class="badge-damaged"><i class="fas fa-times-circle me-1"></i> Damaged</span></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No damaged books found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>