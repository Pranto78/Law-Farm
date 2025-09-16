<?php
session_start();
include 'db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: Admin_login.html");
    exit();
}

// Fetch all users
$result = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<style>
/* Body & Background */
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #2c1e1e, #1a0f0f, #0d0a0a);
    margin: 0;
    padding: 0;
    min-height: 100vh;
    color: #f0f0f0;
}

/* Header */
h1 {
    text-align: center;
    font-size: 2.5rem;
    background: linear-gradient(90deg, #d4a373, #c08457, #b67c48);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-top: 20px;
}

a.logout-btn {
    display: block;
    text-align: center;
    width: 100px;
    margin: 10px auto 30px auto;
    padding: 10px 25px;
    background: #f5a623;
    color: #111;
    text-decoration: none;
    font-weight: bold;
    border-radius: 8px;
    transition: 0.3s;
}
a.logout-btn:hover {
    background: #d49a6d;
    box-shadow: 0 0 15px #f5a623;
}

/* Table Container */
table {
    width: 90%;
    margin: auto;
    border-collapse: collapse;
    background: rgba(30, 30, 30, 0.85);
    box-shadow: 0 0 25px rgba(0,0,0,0.5);
    border-radius: 12px;
    overflow: hidden;
}

/* Table Head */
th {
    background: linear-gradient(90deg, #d4a373, #c08457, #b67c48);
    color: #111;
    padding: 15px;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Table Rows */
td {
    padding: 12px;
    text-align: center;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    font-size: 0.95rem;
}

/* Alternate row colors */
tr:nth-child(even) td {
    background: rgba(255,255,255,0.03);
}

/* Action buttons */
a {
    text-decoration: none;
    padding: 6px 14px;
    border-radius: 6px;
    font-weight: bold;
    transition: 0.3s;
}

a[href*="edit_user"] {
    background: #6fcf97;
    color: #111;
}
a[href*="edit_user"]:hover {
    background: #4ba86b;
    box-shadow: 0 0 10px #6fcf97;
}

a[href*="delete_user"] {
    background: #eb5757;
    color: #111;
}
a[href*="delete_user"]:hover {
    background: #c0392b;
    box-shadow: 0 0 10px #eb5757;
}

/* Responsive Table */
@media (max-width: 768px) {
    table, thead, tbody, th, td, tr {
        display: block;
    }
    th {
        text-align: left;
    }
    td {
        text-align: right;
        padding-left: 50%;
        position: relative;
    }
    td::before {
        content: attr(data-label);
        position: absolute;
        left: 15px;
        width: 45%;
        text-align: left;
        font-weight: bold;
    }
}
</style>
</head>
<body>

<h1>Welcome, <?php echo $_SESSION['admin']; ?> (Admin)</h1>
<a href="Admin_login.html" class="logout-btn">Logout</a>

<h2 style="text-align:center; margin-bottom:20px; color:#d4a373;">Client Users</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>DOB</th>
        <th>Gender</th>
        <th>Actions</th>
    </tr>
    <?php while($user = $result->fetch_assoc()): ?>
    <tr>
        <td data-label="ID"><?php echo $user['id']; ?></td>
        <td data-label="Full Name"><?php echo $user['full_name']; ?></td>
        <td data-label="Email"><?php echo $user['email']; ?></td>
        <td data-label="DOB"><?php echo $user['dob']; ?></td>
        <td data-label="Gender"><?php echo $user['gender']; ?></td>
        <td data-label="Actions">
            <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
            <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Delete this user?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<a href="admin_lawyers.php" class="logout-btn">Lawyer User</a>


</body>
</html>
