<?php
session_start();
include 'config.php';

$message = "";
$msg_type = "";

// Registration ක්‍රියාව
if(isset($_POST['register'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = 'Member'; // ලියාපදිංචි වන අය සියල්ලෝම Member ලෙස පමණක් සටහන් වේ.

    // Email එක දැනටමත් තිබේදැයි පරීක්ෂා කිරීම
    $check = mysqli_query($conn, "SELECT * FROM Users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $message = "❌ This email is already registered!";
        $msg_type = "danger";
    } else {
        $sql = "INSERT INTO Users (name, email, role, password) VALUES ('$name', '$email', '$role', '$password')";
        if(mysqli_query($conn, $sql)){
            $message = "✅ Registered Successfully! You can now login.";
            $msg_type = "success";
        } else {
            $message = "❌ Error: " . mysqli_error($conn);
            $msg_type = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0; padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            height: 100vh; display: flex; align-items: center; justify-content: center;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 40px; border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.2);
            width: 100%; max-width: 400px;
        }
        .register-card h3 { text-align: center; margin-bottom: 30px; color: #fff; font-weight: 700; }
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
        .success-msg { color: #2ecc71; text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="register-card">
        <h3>📚 Register</h3>
        <form method="POST">
            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            <input type="password" name="password" class="form-control" placeholder="Password" minlength="6" required>
            <button type="submit" name="register" class="btn btn-primary">Register</button>
            <?php if(!empty($message)): ?>
                <div class="<?php echo ($msg_type == 'success') ? 'success-msg' : 'error-msg'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
        </form>
        <div class="text-center mt-3">
            <a href="index.php" style="color: #fff; text-decoration: none;">Already have an account? Login</a>
        </div>
    </div>
</body>
</html>