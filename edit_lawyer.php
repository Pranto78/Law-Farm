<?php
session_start();
include 'db.php';
if (!isset($_SESSION['admin'])) { header("Location: Admin_login.html"); exit(); }

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM lawyers WHERE id=$id");
$lawyer = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $service = $_POST['service'];
    $institute = $_POST['institute'];
    $degree = $_POST['degree'];
    $grad_year = $_POST['grad_year'];
    $cases = $_POST['cases'];
    $status = $_POST['status'];

    $conn->query("UPDATE lawyers SET name='$name', description='$description', service='$service', institute='$institute', degree='$degree', grad_year='$grad_year', cases='$cases', status='$status' WHERE id=$id");
    header("Location: admin_lawyers.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Lawyer</title>
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #2c1e1e, #1a0f0f, #0d0a0a);
    color: #f0f0f0;
    margin: 0;
    padding: 0;
}

main {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.form-container {
    width: 100%;
    max-width: 700px;
    background: linear-gradient(135deg, #1c1c1c, #292929, #0f0f0f);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 0 25px rgba(255, 215, 0, 0.3);
    animation: fadeIn 1s ease-in-out;
}

.form-container h1 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 28px;
    font-weight: bold;
    background: linear-gradient(90deg, #facc15, #f59e0b, #ef4444);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #f3f4f6;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px 15px;
    border: none;
    border-radius: 12px;
    outline: none;
    font-size: 15px;
    background: linear-gradient(135deg, #3a3a3a, #2a2a2a, #1a1a1a);
    color: #fff;
    transition: all 0.3s ease-in-out;
    box-shadow: inset 0 0 5px rgba(250, 204, 21, 0.2);
}

.form-group select {
    appearance: none;
    background-image: url("data:image/svg+xml;utf8,<svg fill='white' height='18' viewBox='0 0 24 24' width='18' xmlns='http://www.w3.org/2000/svg'><path d='M7 10l5 5 5-5z'/></svg>");
    background-repeat: no-repeat;
    background-position: right 15px center;
    background-size: 18px;
    cursor: pointer;
    padding-right: 40px; 
}

.form-group input:focus,
.form-group select:focus {
    box-shadow: 0 0 15px rgba(250, 204, 21, 0.6);
    transform: scale(1.02);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 30px;
}

.btn {
    padding: 14px 25px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.4s ease;
}

.btn-update {
    background: linear-gradient(to right, rgba(182,140,90,0.9), rgba(0,0,0,0.8));
    color: #cbc2c2;
}

.btn-update:hover {
    background: linear-gradient(to left, rgba(218,165,100,1), rgba(50,50,50,1));
    transform: scale(1.05);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
</head>
<body>

<main>
    <div class="form-container">
        <h1>Edit Lawyer Details</h1>
        <form method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" value="<?php echo $lawyer['name']; ?>" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <input type="text" name="description" value="<?php echo $lawyer['description']; ?>" required>
            </div>

            <div class="form-group">
                <label>Service</label>
                <input type="text" name="service" value="<?php echo $lawyer['service']; ?>" required>
            </div>

            <div class="form-group">
                <label>Institute</label>
                <input type="text" name="institute" value="<?php echo $lawyer['institute']; ?>" required>
            </div>

            <div class="form-group">
                <label>Degree</label>
                <input type="text" name="degree" value="<?php echo $lawyer['degree']; ?>" required>
            </div>

            <div class="form-group">
                <label>Graduation Year</label>
                <input type="number" name="grad_year" value="<?php echo $lawyer['grad_year']; ?>" required>
            </div>

            <div class="form-group">
                <label>Cases Solved</label>
                <input type="number" name="cases" value="<?php echo $lawyer['cases']; ?>" required>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="pending" <?php if($lawyer['status']=='pending') echo 'selected'; ?>>Pending</option>
                    <option value="approved" <?php if($lawyer['status']=='approved') echo 'selected'; ?>>Approved</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-update">Update</button>
            </div>
        </form>
    </div>
</main>

</body>
</html>
