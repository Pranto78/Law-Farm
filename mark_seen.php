<?php
session_start();
include 'db.php'; // ✅ use your existing db connection

if (isset($_SESSION['email'])) {
    $client_email = $_SESSION['email'];
    $stmt = $conn->prepare("UPDATE appointments SET is_seen = 1 WHERE client_name = ?");
    $stmt->bind_param("s", $client_email);
    $stmt->execute();
    $stmt->close();
}
$conn->close();
echo "done";
?>
