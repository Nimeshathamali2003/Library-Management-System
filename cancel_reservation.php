<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Member'){
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";
$msg_type = "";

if(isset($_GET['res_id'])){
    $res_id = mysqli_real_escape_string($conn, $_GET['res_id']);
    
    // මෙම Reservation එක අදාල User ට අයිති එකක්දැයි පරීක්ෂා කිරීම
    $check = mysqli_query($conn, "SELECT * FROM Reservation WHERE reservation_id = '$res_id' AND user_id = '$user_id'");
    
    if(mysqli_num_rows($check) > 0){
        // ===== මෙතන DELETE වෙනුවට UPDATE කරලා status Expired කරන්න =====
        $update_sql = "UPDATE Reservation SET status = 'Expired' WHERE reservation_id = '$res_id'";
        if(mysqli_query($conn, $update_sql)){
            $message = "✅ Reservation Cancelled Successfully!";
            $msg_type = "success";
        } else {
            $message = "❌ Error: " . mysqli_error($conn);
            $msg_type = "danger";
        }
    } else {
        $message = "❌ You are not authorized to cancel this reservation.";
        $msg_type = "danger";
    }
} else {
    header("Location: user_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cancel Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f7fc; font-family: 'Segoe UI', sans-serif; }
        .card { background: white; border-radius: 20px; padding: 40px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); max-width: 600px; margin: 100px auto; text-align: center; }
        .btn-custom { padding: 12px 30px; border-radius: 25px; font-weight: 600; transition: 0.3s; text-decoration: none; display: inline-block; }
        .btn-custom:hover { transform: translateY(-3px); }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <?php if(!empty($message)): ?>
                <div class="alert alert-<?php echo $msg_type; ?>">
                    <i class="fas <?php echo ($msg_type == 'success') ? 'fa-check-circle' : 'fa-exclamation-circle'; ?> me-2"></i>
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <div class="mt-4">
                <a href="user_dashboard.php" class="btn btn-success btn-custom">
                    <i class="fas fa-home me-2"></i> Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>