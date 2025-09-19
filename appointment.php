<?php
session_start();
include 'db.php';

// Get lawyer ID from form (⚠️ THIS MUST MATCH lawyer_admin.id)
$lawyer_id = isset($_POST['lawyer_id']) ? intval($_POST['lawyer_id']) : null;

$client_name = "Guest Client";

// If user is logged in, use their email
if (isset($_SESSION['email'])) {
    $client_name = $_SESSION['email'];
}


// Get appointment data from form
$case_desc = isset($_POST['case_desc']) ? trim($_POST['case_desc']) : null;
$day       = isset($_POST['day']) ? $_POST['day'] : null;
$time      = isset($_POST['time']) ? $_POST['time'] : null;

$attachment = null;

// Prevent null lawyer_id
if ($lawyer_id === null) {
    die("Error: Lawyer ID is missing. Please go back and select a lawyer.");
}

// Handle file upload
if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
    $uploadDir = "uploads/appointments/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . "_" . basename($_FILES["attachment"]["name"]);
    $targetFilePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)) {
        $attachment = $fileName;
    }
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO appointments 
    (lawyer_id, client_name, case_desc, day, time, attachment, status) 
    VALUES (?, ?, ?, ?, ?, ?, 'pending')");

$stmt->bind_param("isssss", $lawyer_id, $client_name, $case_desc, $day, $time, $attachment);

if ($stmt->execute()) {
    echo "<script>alert('Appointment request sent successfully!'); window.location.href='index.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
