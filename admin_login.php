<?php
session_start();
include 'db.php'; // make sure this file sets $conn properly

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: Admin_login.html");
    exit();
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// simple validation
if (empty($username) || empty($password)) {
    echo "<script>alert('Enter username and password'); window.location.href='Admin_login.html';</script>";
    exit();
}

$stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "<script>alert('Admin not found'); window.location.href='Admin_login.html';</script>";
    exit();
}

$admin = $result->fetch_assoc();
$hash = $admin['password'];

// If your DB contains plain-text passwords (not recommended), use plain compare instead.
// But here we assume hashed passwords:
if (password_verify($password, $hash)) {
    // login success
    $_SESSION['admin'] = $admin['username'];
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "<script>alert('Invalid password!'); window.location.href='Admin_login.html';</script>";
    exit();
}
