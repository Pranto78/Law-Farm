<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email     = $_POST['email'];
    $password  = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $dob       = $_POST['dob'];
    $gender    = $_POST['gender'];

    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, gender, dob) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $email, $password, $gender, $dob);

    if ($stmt->execute()) {
        echo "<script>alert('Signup successful! Please login.'); window.location.href=' Client-Login.html';</script>";
    } else {
        echo "<script>alert('Error: Email already exists or other error.'); window.location.href='signup.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
