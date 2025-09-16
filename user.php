<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) { header("Location: Admin_login.html"); exit(); }

$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id=$id");
header("Location: admin_dashboard.php");
?>
