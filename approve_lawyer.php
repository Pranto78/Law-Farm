<?php
session_start();
include 'db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


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

    // 4️⃣ Send email via Gmail SMTP
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'youremail@gmail.com'; // Your Gmail
        $mail->Password   = 'yourapppassword';     // Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('youremail@gmail.com', 'Admin');
        $mail->addAddress('prantof39@gmail.com', $lawyer['name']);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Lawyer Admin Account Created';
        $mail->Body    = "
            <p>Hello {$lawyer['name']},</p>
            <p>A lawyer admin account has been created.</p>
            <p><strong>Username:</strong> $username</p>
            <p><strong>Password:</strong> $password</p>
            <p>Login here: <a href='http://localhost/yourproject/lawyer_login.php'>Lawyer Panel</a></p>
            <p>Thank you!</p>
        ";

        $mail->send();
        // Email sent successfully
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Redirect back to admin dashboard
header("Location: admin_dashboard.php");
exit();
?>
