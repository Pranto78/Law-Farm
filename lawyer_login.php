<?php
// DEVELOPMENT: show errors so we can see what's wrong (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db.php'; // make sure this path is correct and db.php creates $conn

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<p style='color:red'>Invalid request method. Use the login form (POST).</p>";
    exit;
}

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if ($username === '' || $password === '') {
    echo "<p style='color:red'>Please enter both username and password.</p>";
    exit;
}

// Prepare statement
$stmt = $conn->prepare("SELECT id, name, username, password FROM lawyer_admin WHERE username = ? LIMIT 1");
if (!$stmt) {
    echo "<p style='color:red'>Database error (prepare failed): " . htmlspecialchars($conn->error) . "</p>";
    exit;
}
$stmt->bind_param('s', $username);

if (!$stmt->execute()) {
    echo "<p style='color:red'>Database error (execute failed): " . htmlspecialchars($stmt->error) . "</p>";
    $stmt->close();
    exit;
}

$stmt->store_result();
if ($stmt->num_rows === 0) {
    echo "<p style='color:red'>❌ No account found with that username!</p>";
    $stmt->close();
    $conn->close();
    exit;
}

// Bind results and fetch
$stmt->bind_result($id, $name, $dbusername, $dbpassword);
$stmt->fetch();

// Trim stored password (in case of stray spaces)
$dbpassword = is_string($dbpassword) ? trim($dbpassword) : $dbpassword;

// === DEBUG HELPERS (uncomment if you need to inspect values) ===
// echo "<pre>DEBUG:\nPosted username: ".htmlspecialchars($username)."\nPosted password: ".htmlspecialchars($password).
//      "\nDB username: ".htmlspecialchars($dbusername)."\nDB password: ".htmlspecialchars($dbpassword)."</pre>";
// ===============================================================

// Accept login if either the plain text matches OR the hash verifies
$loggedIn = false;
if ($password === $dbpassword) {
    $loggedIn = true; // plain-text match
} elseif (is_string($dbpassword) && password_verify($password, $dbpassword)) {
    $loggedIn = true; // hashed password match
}

if ($loggedIn) {
    // Successful login
    session_regenerate_id(true);
    $_SESSION['lawyer_id'] = $id;
    $_SESSION['lawyer_name'] = $name;
    $_SESSION['lawyer_username'] = $dbusername;

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
