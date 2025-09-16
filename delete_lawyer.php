<?php
session_start();
include 'db.php';
if(!isset($_SESSION['admin'])){ header("Location: Admin_login.html"); exit(); }

$id = $_GET['id'];
// delete image from server first
$res = $conn->query("SELECT profile_image FROM lawyers WHERE id=$id");
$img = $res->fetch_assoc()['profile_image'];
if(file_exists($img)) unlink($img);

$conn->query("DELETE FROM lawyers WHERE id=$id");
header("Location: admin_dashboard.php");
?>
