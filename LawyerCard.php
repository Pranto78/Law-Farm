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

/* Modal */

/* Modal Styles */
.modal {
  position: fixed;
  z-index: 999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.7);
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-content {
  background: #111;
  padding: 20px;
  border-radius: 10px;
  width: 400px;
  color: #fff;
  position: relative;
}

.modal-content h2 {
  margin-bottom: 15px;
  color: #facc15;
}

.modal-content label {
  display: block;
  margin: 10px 0 5px;
}

.modal-content textarea,
.modal-content select,
.modal-content input {
  width: 100%;
  padding: 8px;
  border-radius: 5px;
  border: none;
  margin-bottom: 15px;
}

.modal-content button {
  width: 100%;
}

.close {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 20px;
  cursor: pointer;
  color: #fff;
}




</style>
</head>
<body>

        <div class="top-nav">
            <nav class="navbar">
                <div class="logo">
                    <img src="images/Group 37.png" alt="Logo">

                </div>

                <div class="nav-links">
                    <a href="">Home</a>
                    <a href="">Services<i class="fa-solid fa-angle-right"></i></a>
                    <a href="">Cases<i class="fa-solid fa-angle-right"></i></a>
                    <a href="LawyerCard.php">Our Lawyer<i class="fa-solid fa-angle-right"></i></a>
                    <a href="Contact.html">Contact Us<i class="fa-solid fa-angle-right"></i></a>
                </div>

                <!-- <button class=" lawyer-btn">Lawyer Registration</button>
                <button class="btn-primary">Client Login</button> -->

                <img src="images/lawyer.png" alt="" width="100px" height="100px">
            </nav>
        </div>

<div class="lawyer-section">
<?php while($lawyer = $result->fetch_assoc()): ?>
   <div class="lawyer-card" data-lawyer-id="<?php echo $lawyer['id']; ?>">
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


<!-- Appointment Modal -->
<div id="appointmentModal" class="modal" style="display:none;">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Book Appointment</h2>
    <form id="appointmentForm" action="appointment.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" id="lawyerId" name="lawyer_id" value="">

      <label for="case_desc">Case Description</label>
      <textarea id="case_desc" name="case_desc" required></textarea>

      <label for="day">Select Day</label>
      <select id="day" name="day" required>
        <option value="">-- Select Day --</option>
        <option value="Sunday">Sunday</option>
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
        <option value="Thursday">Thursday</option>
      </select>

      <label for="time">Select Time</label>
      <input type="time" id="time" name="time" required>

      <label for="attachment">Upload File (Optional)</label>
      <input type="file" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.jpg,.png">

      <button type="submit" class="law-btn">Book Appointment</button>
    </form>
  </div>
</div>



<script>
// Open modal when book button clicked
document.querySelectorAll(".book-btn").forEach(btn => {
  btn.addEventListener("click", function() {
    const lawyerId = this.closest(".lawyer-card").getAttribute("data-lawyer-id");
    document.getElementById("lawyerId").value = lawyerId;
    document.getElementById("appointmentModal").style.display = "flex";
  });
});


// Close modal
document.querySelector(".close").onclick = function() {
  document.getElementById("appointmentModal").style.display = "none";
};

// ✅ Submit form (no preventDefault, so it goes to appointment.php)
document.getElementById("appointmentForm").addEventListener("submit", function() {
  document.getElementById("appointmentModal").style.display = "none";
});
</script>


<script src="Javascript/script.js"></script>


<footer>

        <div class="footer-container">
            <div class="justice">
                <img src="images/Group 37.png" alt="">
                <p class="foot-des">There are many variations of passages of Lorem Ipsum available, but the majority
                    have suffered alteration in some form, by injected humour.</p>
            </div>

            <div class="useful">
                <h1 class="fot-txt">Useful Link</h1>
                <ul>
                    <li class="list"><a href="">Home</a></li>
                    <li class="list"><a href="">About Us</a></li>
                    <li class="list"><a href="">Cases</a></li>
                    <li class="list"><a href="">Blog</a></li>
                    <li class="list"><a href="">Contact Us</a></li>
                </ul>
            </div>

            <div class="contact-now">
                <h1 class="contact-2">Contact Now</h1>
                <p class="fot-min-txt">555 4th 5t NW, Washington</p>
                <p class="fot-min-txt">DC 20530, United States</p>
                <p class="fot-min-txt">+88 01750 000 000</p>
                <p class="fot-min-txt">+88 01750 000 000</p>
                <p class="fot-min-txt">info@gmail.com</p>
                <p class="fot-min-txt">info@gmail.com</p>
            </div>


            <div class="subscribe">
                <h1 class="s-title">Subscribe</h1>
                <p class="s-des">Subscribe for our latest & articles. We won’t give you spam mails</p>

                <div class="sub-box">
                    <input type="email" placeholder="Email Address">
                    <button type="submit"><i class="fa-solid fa-paper-plane"></i></button>
                </div>
            </div>

        </div>

    </footer>
</body>
</html>
