<?php
session_start();
include 'db.php';

if (isset($_SESSION['lawyer_id'])) {
    $lawyer_id = $_SESSION['lawyer_id'];
    $stmt = $conn->prepare("UPDATE appointments SET is_seen_lawyer = 1 WHERE lawyer_id = ?");
    $stmt->bind_param("i", $lawyer_id);
    $stmt->execute();
    $stmt->close();
}
$conn->close();
echo "done";
?>
