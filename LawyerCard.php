<?php
include 'db.php';

// Fetch approved lawyers
$result = $conn->query("SELECT * FROM lawyers WHERE status='approved'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Lawyers</title>
<link rel="stylesheet" href="style/justice.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css">
<style>
.lawyer-section {
    max-width: 1170px;
    margin: 50px auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
}

.lawyer-card {
    background: #000;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0,0,0,0.6);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.lawyer-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.8);
}

.lawyer-card img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.lawyer-card-content {
    padding: 20px;
}

.lawyer-card-content h3 {
    font-size: 20px;
    margin: 0 0 10px;
    color: #d4af37; /* Gold */
}

.lawyer-card-content p {
    font-size: 14px;
    line-height: 1.5;
    color: #ccc;
    margin-bottom: 10px;
}

.lawyer-card-content p span {
    font-weight: bold;
    color: #fff;
}

.lawyer-card-content a {
    display: inline-block;
    padding: 8px 15px;
    background: #d48537;
    color: #000;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background 0.3s ease;
    margin-right: 5px;
}

.lawyer-card-content a:hover {
    background: #b89028;
}

.law-btn {
    height: 36px;
    background: #facc15;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
    transition: all 0.3s ease;
}

.law-btn:hover {
    background: #d4a373;
    color: #000;
}

.book-btn{
  height: 36px;
}
</style>
</head>
<body>

<div class="lawyer-section">
<?php while($lawyer = $result->fetch_assoc()): ?>
    <div class="lawyer-card">
      <img src="uploads/<?php echo $lawyer['profile_image']; ?>" alt="<?php echo $lawyer['name']; ?>">
      <div class="lawyer-card-content">
        <h3><?php echo $lawyer['name']; ?></h3>
        <p><?php echo $lawyer['description']; ?></p>
        <p><span>Service:</span> <?php echo $lawyer['service']; ?></p>
        <p><span>Institute:</span> <?php echo $lawyer['institute']; ?></p>
        <p><span>Degree:</span> <?php echo $lawyer['degree']; ?></p>
        <p><span>Graduate-Year:</span> <?php echo $lawyer['grad_year']; ?></p>
        <p><span>Cases:</span> <?php echo $lawyer['cases']; ?></p>
        <a href="lawyer_profile.php?id=<?php echo $lawyer['id']; ?>">View Profile</a>
        <button class="btn-primary book-btn">Book</button>
      </div>
    </div>
<?php endwhile; ?>
</div>

<script src="Javascript/script.js"></script>
</body>
</html>
