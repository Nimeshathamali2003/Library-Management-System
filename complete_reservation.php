<?php
session_start();
include 'config.php';

// Admin ලෙස Login වී ඇති බව තහවුරු කිරීම
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'Admin'){
    header("Location: index.php");
    exit();
}

if(isset($_GET['user_id']) && isset($_GET['book_id'])){
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    $book_id = mysqli_real_escape_string($conn, $_GET['book_id']);
    
    // මේ User විසින් මේ පොත සඳහා Pending Reservation එකක් තිබේදැයි පරීක්ෂා කිරීම
    $check = mysqli_query($conn, "SELECT reservation_id FROM Reservation WHERE user_id='$user_id' AND book_id='$book_id' AND status='Pending'");
    
    if(mysqli_num_rows($check) > 0){
        $row = mysqli_fetch_assoc($check);
        $reservation_id = $row['reservation_id'];
        
        // Reservation එක Completed ලෙස Update කිරීම
        mysqli_query($conn, "UPDATE Reservation SET status = 'Completed' WHERE reservation_id = '$reservation_id'");
    }
}
?>