<?php
// Session එක පරීක්ෂා කිරීමට සහ Role එක පරීක්ෂා කිරීමට මේ කේතය උඩින්ම තියෙන්න ඕනේ
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'config.php';
include 'includes/header.php';

$sql = "SELECT b.*, c.category_name FROM Books b JOIN Category c ON b.category_id = c.category_id ORDER BY b.book_id ASC";
$result = mysqli_query($conn, $sql);
?>

<style>
    body { background-color: #f4f7fc; font-familyp: 'Segoe UI', sans-serif; }
    .page-header { display: flex; justify-content: sace-between; align-items: center; margin-bottom: 30px; flex-wrap: wrap; }
    .page-title { border-left: 6px solid #302b63; padding-left: 15px; font-weight: 700; color: #302b63; display: flex; align-items: center; margin: 0; }
    .page-title i { color: #302b63; margin-right: 10px; }
    
    .search-box { background: white; border-radius: 25px; padding: 8px 15px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; align-items: center; border: 1px solid #e9ecef; transition: 0.3s; }
    .search-box:focus-within { border-color: #302b63; box-shadow: 0 0 0 3px rgba(48, 43, 99, 0.1); }
    .search-box input { border: none; outline: none; padding: 5px 10px; width: 200px; font-size: 14px; background: transparent; }
    .search-box i { color: #6c757d; }
    -shadow: 0 15px 35px rgba(0,0,0,0.12); }
    .table { margin-bottom: 0; border-radius: 12px; overflow: hidden; width: 100%; }
    .table thead th { bac
    .table-container { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); transition: 0.3s; }
    .table-container:hover { boxkground: linear-gradient(135deg, #0f0c29 0%, #302b63 100%); color: #ffffff; border: none; padding: 15px; font-weight: 600; text-transform: uppercase; font-size: 14px; letter-spacing: 0.5px; }
    .table tbody tr { transition: all 0.2s ease; border-bottom: 1px solid #e9ecef; }
    .table tbody tr:hover { background-color: #f8fbff; transform: scale(1.005); box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
    .table tbody td { padding: 15px; vertical-align: middle; font-size: 15px; color: #495057; }
    .category-badge { background: linear-gradient(135deg, #e0e7ff, #c3d9ff); color: #302b63; padding: 6px 14px; border-radius: 20px; font-weight: 600; font-size: 13px; display: inline-block; }
    .book-title { color: #302b63; font-weight: 600; }
    .qty-badge { background: #e9ecef; padding: 4px 12px; border-radius: 6px; font-weight: 600; color: #495057; }
    .btn-borrow { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border: none; padding: 5px 15px; border-radius: 25px; font-weight: 600; text-decoration: none; transition: 0.3s; display: inline-block; }
    .btn-borrow:hover { transform: scale(1.05); color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
    .btn-borrow:disabled { background: #e9ecef; color: #6c757d; cursor: not-allowed; transform: none; }
    .btn-reserve { background: linear-gradient(135deg, #bf2160 0%, #e1199e 100%); color: white; border: none; padding: 5px 15px; border-radius: 25px; font-weight: 600; text-decoration: none; transition: 0.3s; display: inline-block; }
    .btn-reserve:hover { transform: scale(1.05); color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
    .btn-reserve:disabled { background: #e9ecef; color: #6c757d; cursor: not-allowed; transform: none; }
    .btn-damaged { background: #dc3545; color: white; padding: 5px 12px; border-radius: 25px; font-weight: 600; text-decoration: none; transition: 0.3s; display: inline-block; }
    .btn-damaged:hover { transform: scale(1.05); color: white; box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
    
    /* Contact Librarian Style for Members */
    .contact-text {
        color: #6c757d;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        font-size: 14px;
        background: #f8f9fa;
        padding: 5px 12px;
        border-radius: 15px;
        border: 1px solid #e9ecef;
    }
    .contact-text i {
        color: #302b63;
        margin-right: 5px;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="container mt-5 mb-5">
    
    <div class="page-header">
        <h2 class="page-title">
            <i class="fas fa-book-open"></i> All Available Books
        </h2>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Search for books..." onkeyup="filterTable()">
        </div>
    </div>

    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover" id="booksTable">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Book Title</th>
                        <th>Author</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><span class="badge bg-light text-dark border"><?php echo $row['book_id']; ?></span></td>
                            <td><span class="book-title"><?php echo $row['title']; ?></span></td>
                            <td><i class="fas fa-user-edit text-secondary me-1"></i> <?php echo $row['author']; ?></td>
                            <td><span class="category-badge"><?php echo $row['category_name']; ?></span></td>
                            <td><span class="qty-badge"><?php echo $row['quantity']; ?></span></td>
                            <td>
                                <?php if($row['quantity'] > 0): ?>
                                    <!-- Admin ලෙස Login වී ඇත්නම් බොත්තම් පෙන්වන්න -->
                                    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'Admin'): ?>
                                        <a href="reserve_book.php?book_id=<?php echo $row['book_id']; ?>" class="btn-reserve me-1">
                                            <i class="fas fa-calendar-check me-1"></i> Reserve
                                        </a>
                                        <a href="borrow_book.php?book_id=<?php echo $row['book_id']; ?>" class="btn-borrow">
                                            <i class="fas fa-hand-holding-heart me-1"></i> Borrow
                                        </a>
                                        <a href="view_books.php?mark_damaged=<?php echo $row['book_id']; ?>" class="btn-damaged" onclick="return confirm('Mark this book as Damaged?');">
                                            <i class="fas fa-times-circle me-1"></i> Damaged
                                        </a>
                                    <?php else: ?>
                                        <!-- Member ලෙස Login වී ඇත්නම් Contact Librarian පෙන්වන්න -->
                                        <span class="contact-text"><i class="fas fa-headset me-1"></i> Contact Librarian</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm" disabled>Out of Stock</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-book-open fa-3x mb-3 text-secondary"></i><br>
                                No books found in the library.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function filterTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("booksTable");
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        var found = false;
        for(var j=1; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        tr[i].style.display = found ? "" : "none";
    }
}
</script>