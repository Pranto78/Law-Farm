<?php
session_start();
include 'db.php';

// 🔒 Block if not logged in
if (!isset($_SESSION['lawyer_id'])) {
    header("Location: lawyer_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("⚠️ No appointment ID given.");
}

$id = intval($_GET['id']);
$lawyer_id = $_SESSION['lawyer_id'];

// ✅ Update only if this appointment belongs to the logged-in lawyer
$sql = "UPDATE appointments SET status='approved' WHERE id=$id AND lawyer_id=$lawyer_id";

if ($conn->query($sql) === TRUE) {
    header("Location: lawyer_appointment_dashboard.php?msg=approved");
    exit;
} else {
    echo "❌ Error approving appointment: " . $conn->error;
}
?>
