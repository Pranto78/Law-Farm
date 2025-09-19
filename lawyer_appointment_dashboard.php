<?php
session_start();
include 'db.php';

// 🔹 Block if not logged in
if (!isset($_SESSION['lawyer_id'])) {
    header("Location: lawyer_login.php");
    exit;
}

$lawyer_id = $_SESSION['lawyer_id'];

// Fetch all appointments for this lawyer
$result = $conn->query("SELECT * FROM appointments WHERE lawyer_id = $lawyer_id ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Lawyer Appointments</title>
  <link rel="stylesheet" href="style/justice.css">
  <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #2c1e1e, #1a0f0f, #0d0a0a);
        color: #f1f1f1;
        margin: 0;
        padding: 20px;
        min-height: 100vh;
    }
    h1 {
        text-align: center;
        font-size: 28px;
        margin-bottom: 25px;
        color: #ffffff;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.6);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: rgba(40, 40, 40, 0.95);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.5);
    }
    table th {
        background: rgba(60, 60, 60, 0.95);
        color: #ffffff;
        padding: 14px;
        text-align: left;
        font-size: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    table td {
        padding: 14px;
        border-bottom: 1px solid #444;
        font-size: 14px;
        color: #e0e0e0;
    }
    table tr:hover td {
        background: rgba(70, 70, 70, 0.85);
        transition: background 0.3s ease;
    }
    .ap-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #28a745;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .ap-btn:hover { background-color: #218838; }
    .dl-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #e74c3c;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    .dl-btn:hover { background-color: #c0392b; }
    .done-tick {
        font-size: 18px;
        color: #28a745;
        font-weight: bold;
    }
  </style>
</head>
<body>
  <h1>📅 Appointments for <?php echo $_SESSION['lawyer_name']; ?></h1>

  <table>
    <tr>
      <th>ID</th>
      <th>Client Name</th>
      <th>Case Description</th>
      <th>Day</th>
      <th>Time</th>
      <th>Attachment</th>
      <th>Status</th>
      <th>Action</th>
    </tr>

    <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['client_name']; ?></td>
          <td><?php echo $row['case_desc']; ?></td>
          <td><?php echo $row['day']; ?></td>
          <td><?php echo $row['time']; ?></td>
          <td>
            <?php if ($row['attachment']): ?>
              <a href="uploads/appointments/<?php echo $row['attachment']; ?>" target="_blank">📂 View File</a>
            <?php else: ?>
              No file
            <?php endif; ?>
          </td>
          <td>
            <?php if ($row['status'] === 'approved'): ?>
              <span class="done-tick">✅ Approved</span>
            <?php else: ?>
              ⏳ Pending
            <?php endif; ?>
          </td>
          <td>
            <?php if ($row['status'] === 'approved'): ?>
              <span class="done-tick">✔️</span>
            <?php else: ?>
              <a class="ap-btn" href="approve_appointment.php?id=<?php echo $row['id']; ?>">✅ Approve</a> |
              <a class="dl-btn" href="delete_appointment.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this appointment?')">❌ Delete</a>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="8">⚠️ No appointments found.</td></tr>
    <?php endif; ?>
  </table>
</body>
</html>
