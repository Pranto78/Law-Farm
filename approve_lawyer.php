<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) { 
    header("Location: Admin_login.html"); 
    exit(); 
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // 1️⃣ Approve the lawyer
    $conn->query("UPDATE lawyers SET status='approved' WHERE id=$id");

    // 2️⃣ Get lawyer details
    $lawyer = $conn->query("SELECT * FROM lawyers WHERE id=$id")->fetch_assoc();
    
    // 3️⃣ Insert lawyer_admin account (fixed username/password)
    $username = "lawyer@gmail.com";   // Fixed username
    $password = "lawyer12o";          // Fixed password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if account already exists
    $check = $conn->query("SELECT * FROM lawyer_admin WHERE username='$username'");
    if($check->num_rows == 0){
        $conn->query("INSERT INTO lawyer_admin (name, username, password) VALUES (
            '{$lawyer['name']}',
            '$username',
            '$hashed_password'
        )");
    }
}

// Redirect back to admin dashboard
header("Location: admin_dashboard.php");
exit();
?>
