<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) { header("Location: Admin_login.html"); exit(); }

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $conn->query("UPDATE users SET full_name='$full_name', email='$email', dob='$dob', gender='$gender' WHERE id=$id");
    header("Location: admin_dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit User</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #2c1e1e, #1a0f0f, #0d0a0a);
    color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
}

.edit-container {
    background: rgba(30, 30, 30, 0.85);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 0 30px rgba(0,0,0,0.7);
    width: 400px;
    text-align: center;
}

.edit-container h2 {
    font-size: 2rem;
    margin-bottom: 25px;
    background: linear-gradient(90deg, #d4a373, #c08457, #b67c48);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.edit-container input, .edit-container select {
    width: 100%;
    padding: 12px;
    margin: 12px 0;
    border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, #3a2c2c, #1f1414);
    color: #fff;
    font-size: 1rem;
    outline: none;
    transition: 0.3s;
}

.edit-container input:focus, .edit-container select:focus {
    background: linear-gradient(135deg, #4b3621, #2e1c1c);
    box-shadow: 0 0 10px rgba(212, 163, 115, 0.6);
}

.edit-container button {
    width: 100%;
    padding: 14px;
    margin-top: 20px;
    font-size: 1.1rem;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    background: linear-gradient(90deg, #d4a373, #c08457, #b67c48);
    color: #0d0a0a;
    cursor: pointer;
    transition: 0.4s;
}

.edit-container button:hover {
    background: linear-gradient(90deg, #b67c48, #c08457, #d4a373);
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(212, 163, 115, 0.8);
}

a.back-btn {
    display: inline-block;
    margin-top: 15px;
    text-decoration: none;
    color: #d4a373;
    font-weight: bold;
    transition: 0.3s;
}

a.back-btn:hover {
    text-decoration: underline;
    color: #e4b78d;
}
</style>
</head>
<body>

<div class="edit-container">
    <h2>Edit User</h2>
    <form method="POST">
        <input name="full_name" value="<?php echo $user['full_name']; ?>" required>
        <input name="email" value="<?php echo $user['email']; ?>" required>
        <input type="date" name="dob" value="<?php echo $user['dob']; ?>">
        <select name="gender">
            <option value="male" <?php if($user['gender']=='male') echo 'selected'; ?>>Male</option>
            <option value="female" <?php if($user['gender']=='female') echo 'selected'; ?>>Female</option>
        </select>
        <button type="submit">Update</button>
    </form>
    <a href="admin_dashboard.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>
