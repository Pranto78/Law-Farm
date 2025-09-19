<?php
session_start();
include 'db.php';

if (!isset($_SESSION['lawyer_id'])) {
    header("Location: lawyer_login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("⚠️ No appointment ID given.");
}

$id = intval($_GET['id']);
$lawyer_id = $_SESSION['lawyer_id'];

$sql = "DELETE FROM appointments WHERE id=$id AND lawyer_id=$lawyer_id";

if ($conn->query($sql) === TRUE) {
    header("Location: lawyer_appointment_dashboard.php?msg=deleted");
    exit;
} else {
    echo "❌ Error deleting appointment: " . $conn->error;
}
?>
