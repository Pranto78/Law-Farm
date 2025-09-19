<?php
session_start();
include 'db.php'; // Make sure this file contains $conn = new mysqli(...);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
    // Store useful info in session
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email']     = $user['email'];

    header("Location: index.php");
    exit();
}
 else {
            echo "<script>alert('Invalid password!'); window.location.href=Client-login.html';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email!'); window.location.href='Client-login.html';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: login.html");
    exit();
}
?>
