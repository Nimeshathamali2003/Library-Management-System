<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin'){
    header("Location: index.php");
    exit();
}

$message = "";
$msg_type = "";

// Categories ලබා ගැනීම
$cat_result = mysqli_query($conn, "SELECT * FROM Category");

if(isset($_POST['add_book'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    $sql = "INSERT INTO Books (title, author, category_id, quantity) VALUES ('$title', '$author', '$category_id', '$quantity')";
    
    if(mysqli_query($conn, $sql)){
        $message = "✅ New Book Added Successfully!";
        $msg_type = "success";
    } else {
        $message = "❌ Error: " . mysqli_error($conn);
        $msg_type = "danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7fc; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .navbar-brand, .nav-link { color: #ffffff !important; font-weight: 500; }
        .form-card { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); max-width: 600px; margin: 0 auto; }
        .form-card h2 { color: #302b63; font-weight: 700; border-left: 6px solid #302b63; padding-left: 15px; margin-bottom: 30px; }
        .btn-submit { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none; padding: 12px; border-radius: 10px; font-weight: 600; width: 100%; transition: 0.3s; }
        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php"><i class="fas fa-shield-alt"></i> Admin Panel</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="view_books.php"><i class="fas fa-book"></i> View Books</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="form-card">
            <h2><i class="fas fa-plus-circle me-2"></i> Add New Book</h2>
            
            <?php if(!empty($message)): ?>
                <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
                    <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label fw-bold">Book Title</label>
                    <input type="text" name="title" class="form-control" placeholder="Enter book title" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Author</label>
                    <input type="text" name="author" class="form-control" placeholder="Enter author name" required>
                </div>
                <!-- මෙතනට Category Dropdown එක එකතු කරලා තියෙනවා -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select Category</option>
                        <?php while($cat = mysqli_fetch_assoc($cat_result)): ?>
                            <option value="<?php echo $cat['category_id']; ?>"><?php echo $cat['category_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Quantity</label>
                    <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" min="1" required>
                </div>
                <button type="submit" name="add_book" class="btn-submit"><i class="fas fa-save me-2"></i> Save Book</button>
                <a href="admin_dashboard.php" class="btn btn-secondary w-100 mt-3">Cancel & Go Back</a>
            </form>
        </div>
    </div>
</body>
</html>