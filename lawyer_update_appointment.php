<?php
session_start();
include 'db.php';

if (!isset($_SESSION['lawyer_id'])) {
    header("Location: lawyer_login.php");
    exit;
}

$lawyer_id = $_SESSION['lawyer_id'];

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === "approve") {
        $conn->query("UPDATE appointments SET status='approved' WHERE id=$id AND lawyer_id=$lawyer_id");
    } elseif ($action === "delete") {
        $conn->query("DELETE FROM appointments WHERE id=$id AND lawyer_id=$lawyer_id");
    }
}

header("Location: lawyer_appointment_dashboard.php");
exit;
?>
