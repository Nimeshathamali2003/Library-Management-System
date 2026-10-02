<?php
session_start();
include 'config.php';

if(isset($_SESSION['user_id'])){
    if($_SESSION['role'] == 'Admin'){
        header("Location: admin_dashboard.php");
    } else {
        header("Location: user_dashboard.php");
    }
    exit();
}

$message = "";
if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        if($password === $user['password']){ 
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            if($user['role'] == 'Admin'){
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            $message = "Incorrect Password!";
        }
    } else {
        $message = "User Not Found!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0; padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px; border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.2);
            width: 100%; max-width: 400px;
            position: relative; /* ලින්ක් එක පතුලේ පෙන්වීමට */
        }
        .login-card h3 { text-align: center; margin-bottom: 30px; color: #fff; font-weight: 700; }
        .form-control {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: #fff;
            padding: 12px; border-radius: 10px; margin-bottom: 20px;
        }
        .form-control::placeholder { color: #ddd; }
        .form-control:focus { background: rgba(255,255,255,0.3); border-color: #fff; box-shadow: none; color: #fff; }
        .btn-primary {
            width: 100%; padding: 12px; border-radius: 10px; font-weight: 600;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border: none; transition: 0.3s;
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.3); }
        .error-msg { color: #ff6b6b; text-align: center; margin-top: 15px; }
        
        /* Register ලින්ක් එක පැහැදිලිව පෙන්වීමට */
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .register-link a {
            color: #f093fb; /* ලස්සන රෝස පාටක් */
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .register-link a:hover {
            color: #ffffff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h3>📚 Library Login</h3>
        <form method="POST">
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" name="login" class="btn btn-primary">Login</button>
            
            <!-- පැහැදිලි "Register" ලින්ක් එක -->
            <div class="register-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>
            
            <?php if(!empty($message)): ?>
                <div class="error-msg"><?php echo $message; ?></div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>