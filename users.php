<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin'){
    header("Location: index.php");
    exit();
}

// පරිශීලකයෙකු මකා දැමීමේ ක්‍රියාව
if(isset($_GET['delete_id'])){
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    // Admin කෙනෙක් මකා දැමීමට ඉඩ නොදෙන්න (ආරක්ෂාව සඳහා)
    $check_role = mysqli_query($conn, "SELECT role FROM Users WHERE user_id='$delete_id'");
    $role_data = mysqli_fetch_assoc($check_role);
    
    if($role_data['role'] != 'Admin'){
        mysqli_query($conn, "DELETE FROM Users WHERE user_id='$delete_id'");
        $del_msg = "User deleted successfully!";
    } else {
        $del_msg = "You cannot delete an Admin!";
    }
}

$result = mysqli_query($conn, "SELECT * FROM Users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7fc; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .navbar-brand, .nav-link { color: #ffffff !important; font-weight: 500; }
        .page-title { border-left: 6px solid #f5576c; padding-left: 15px; font-weight: 700; color: #f5576c; margin-bottom: 30px; display: flex; align-items: center; }
        .page-title i { color: #f5576c; margin-right: 10px; }
        .table-container { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .table { margin-bottom: 0; overflow: hidden; }
        .table thead th { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none; padding: 15px; }
        .table tbody tr { transition: 0.2s; }
        .table tbody tr:hover { background-color: #f8fbff; transform: scale(1.005); }
        .table tbody td { padding: 15px; vertical-align: middle; }
        .badge-librarian { background: #198754; color: white; padding: 5px 12px; border-radius: 20px; font-weight: 600; }
        .badge-member { background: #0d6efd; color: white; padding: 5px 12px; border-radius: 20px; font-weight: 600; }
        .btn-del { transition: 0.2s; }
        .btn-del:hover { transform: scale(1.1); }
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
        <?php if(isset($del_msg)): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $del_msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="page-title">
            <i class="fas fa-users-cog"></i>
            <h2 class="m-0">Manage Users</h2>
        </div>
        
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><span class="badge bg-light text-dark border"><?php echo $row['user_id']; ?></span></td>
                            <td><b><?php echo $row['name']; ?></b></td>
                            <td><?php echo $row['email']; ?></td>
                            <td>
                                <?php if($row['role'] == 'Librarian'): ?>
                                    <span class="badge-librarian"><i class="fas fa-user-tie me-1"></i> Librarian</span>
                                <?php elseif($row['role'] == 'Admin'): ?>
                                    <span class="badge bg-dark text-white"><i class="fas fa-crown me-1"></i> Admin</span>
                                <?php else: ?>
                                    <span class="badge-member"><i class="fas fa-user me-1"></i> Member</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($row['role'] != 'Admin'): ?>
                                    <a href="users.php?delete_id=<?php echo $row['user_id']; ?>" class="btn btn-danger btn-sm btn-del" onclick="return confirm('Are you sure you want to delete this user?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted"><i class="fas fa-lock"></i> Protected</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="admin_dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i> Back to Dashboard</a>
        </div>
    </div>
</body>
</html>