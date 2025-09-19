<?php
// DEVELOPMENT: show errors so we can see what's wrong (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db.php'; // make sure db.php creates $conn

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<p style='color:red'>Invalid request method. Use the login form (POST).</p>";
    exit;
}

$gmail = isset($_POST['gmail']) ? trim($_POST['gmail']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($gmail === '' || $password === '') {
    echo "<p style='color:red'>Please enter both Gmail and password.</p>";
    exit;
}

// Prepare statement to fetch from lawyers table
$stmt = $conn->prepare("SELECT id, name, gmail, password FROM lawyers WHERE gmail = ? LIMIT 1");
if (!$stmt) {
    echo "<p style='color:red'>Database error (prepare failed): " . htmlspecialchars($conn->error) . "</p>";
    exit;
}
$stmt->bind_param('s', $gmail);

if (!$stmt->execute()) {
    echo "<p style='color:red'>Database error (execute failed): " . htmlspecialchars($stmt->error) . "</p>";
    $stmt->close();
    exit;
}

$stmt->store_result();
if ($stmt->num_rows === 0) {
    echo "<p style='color:red'>❌ No account found with that Gmail!</p>";
    $stmt->close();
    $conn->close();
    exit;
}

// Bind results and fetch
$stmt->bind_result($id, $name, $dbgmail, $dbpassword);
$stmt->fetch();

// Trim stored password (in case of stray spaces)
$dbpassword = is_string($dbpassword) ? trim($dbpassword) : $dbpassword;

// Accept login if plain text matches or password_verify succeeds
$loggedIn = false;
if ($password === $dbpassword) {
    $loggedIn = true; // plain-text match
} elseif (is_string($dbpassword) && password_verify($password, $dbpassword)) {
    $loggedIn = true; // hashed password match
}

if ($loggedIn) {
    // ✅ Successful login
    session_regenerate_id(true);
    $_SESSION['lawyer_id'] = $id;
    $_SESSION['lawyer_name'] = $name;
    $_SESSION['lawyer_gmail'] = $dbgmail;

    $stmt->close();
    $conn->close();

    header("Location: lawer_index.php");
    exit;
} else {
    echo "<p style='color:red'>❌ Incorrect password!</p>";
}

$stmt->close();
$conn->close();
?>
