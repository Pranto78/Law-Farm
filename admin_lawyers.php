<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) { 
    header("Location: Admin_login.html"); 
    exit(); 
}

// Fetch all lawyers
$lawyers = $conn->query("SELECT * FROM lawyers ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lawyer Approval</title>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #2c1e1e, #1a0f0f, #0d0a0a);
        color: #fff;
    }

    .container {
        width: 90%;
        margin: 50px auto;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #d4a373;
        font-size: 28px;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background: #1e1e1e;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.6);
    }

    th, td {
        padding: 14px 20px;
        text-align: center;
    }

    th {
        background: #2c2c2c;
        color: #d4af37;
        font-size: 16px;
        text-transform: uppercase;
    }

    tr:nth-child(even) {
        background: #2a2a2a;
    }

    tr:hover {
        background: #333;
        transition: 0.3s;
    }

    .btn {
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s;
        display: inline-block;
    }

    .approve {
        background: #28a745;
        color: #fff;
    }
    .approve:hover {
        background: #218838;
    }

    .delete {
        background: #dc3545;
        color: #fff;
        margin-left: 5px;
    }
    .delete:hover {
        background: #c82333;
    }

    .approved-tag {
        color: #28a745;
        font-weight: bold;
    }
</style>
</head>
<body>

<div class="container">
    <h2>Lawyer Approval Panel</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Service</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while($lawyer = $lawyers->fetch_assoc()): ?>
        <tr>
            <td><?php echo $lawyer['id']; ?></td>
            <td><?php echo $lawyer['name']; ?></td>
            <td><?php echo $lawyer['service']; ?></td>
            <td>
                <?php if($lawyer['status'] == 'pending'): ?>
                    <span style="color:#ffc107; font-weight:bold;">Pending</span>
                <?php else: ?>
                    <span class="approved-tag">Approved</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if($lawyer['status'] == 'pending'): ?>
                    <a href="approve_lawyer.php?id=<?php echo $lawyer['id']; ?>" class="btn approve">Approve</a>
                <?php else: ?>
                    <span class="approved-tag">✔</span>
                <?php endif; ?>
                <a href="delete_lawyer.php?id=<?php echo $lawyer['id']; ?>" class="btn delete">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
