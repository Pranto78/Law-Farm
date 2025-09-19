<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: Client-login.html");
    exit();
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/justice.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css"
        integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
        /* Overlay background */
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            /* dark overlay */
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        /* Modal box */
        .modal-content {
            background: #1e293b;
            /* dark gray */
            color: white;
            padding: 20px;
            border-radius: 10px;
            width: 50%;
            max-width: 600px;
            text-align: center;
            position: relative;
        }

        /* Close button */
        .closeNotify {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
            color: #facc15;
            /* yellow */
        }

        .ap-btn {
            width: 200px;
            /* margin-right: 20px; */
            background: linear-gradient(135deg, #978077ff, #a87748ff, #d4b182ff);
            color: black;
            font-weight: bolder;
        }

        /* ---------------- */

        .notify-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: red;
            color: white;
            font-size: 12px;
            font-weight: bold;
            border-radius: 50%;
            padding: 2px 6px;
        }

        .btn-wrapper {
            position: relative;
            display: inline-block;
        }

        .lg-btn {
            margin-left: 20px;
        }
    </style>
</head>

<body>
    <header>
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

                <!-- <button class=" lawyer-btn">Lawyer Registration</button> -->
                <!-- <button id="notifyBtn" class="ap-btn law-btn btn-primary"><i class="fa-regular fa-calendar-check"></i> Appointment Notify</button> -->
                <div class="btn-wrapper">
                    <button id="notifyBtn" class="ap-btn law-btn btn-primary">
                        <i class="fa-regular fa-calendar-check"></i> Appointment Notify
                    </button>
                    <?php
                    include 'db.php';
                    $badgeCount = 0;
                    if (isset($_SESSION['email'])) {
                        $client_email = $_SESSION['email'];
                        $stmt = $conn->prepare("SELECT COUNT(*) as total FROM appointments WHERE client_name = ? AND is_seen = 0");
                        $stmt->bind_param("s", $client_email);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        $badgeCount = $row['total'] ?? 0;
                        $stmt->close();
                        $conn->close();
                    }
                    if ($badgeCount > 0) {
                        echo "<span class='notify-badge'>$badgeCount</span>";
                    }
                    ?>
                </div>


                <button onclick="window.location.href='Client_logout.php'" class="lg-btn btn-primary logout"><i
                        class="fa-solid fa-right-from-bracket"></i> Logout</button>


            </nav>
        </div>



        <!-- Client Appointment Notify Modal -->
        <div id="notifyModal" class="modal" style="display:none;">
            <div class="modal-content">
                <span class="closeNotify">&times;</span>
                <h2>Your Appointments</h2>

                <table border="1" cellpadding="8" width="100%">
                    <tr style="color:#facc15;">
                        <th>Case</th>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>
                    <?php
                    include 'db.php';
                    if (isset($_SESSION['email'])) {
                        $client_email = $_SESSION['email'];
                        $stmt = $conn->prepare("SELECT * FROM appointments WHERE client_name = ? ORDER BY id DESC");
                        $stmt->bind_param("s", $client_email);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['case_desc']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['day']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                                echo "<td>";
                                if ($row['status'] === 'approved') {
                                    echo "<span style='color:green;'>✔ Approved</span>";
                                } else {
                                    echo "<span style='color:orange;'>⏳ Pending</span>";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' style='text-align:center;'>No appointments yet</td></tr>";
                        }

                        $stmt->close();
                        $conn->close();
                    } else {
                        echo "<tr><td colspan='4' style='text-align:center;'>Please log in to see appointments</td></tr>";
                    }
                    ?>

                </table>
            </div>
        </div>

        <script>
            // Open notify modal
            document.getElementById("notifyBtn").onclick = function () {
                document.getElementById("notifyModal").style.display = "flex";
            };

            // Close notify modal
            document.querySelector(".closeNotify").onclick = function () {
                document.getElementById("notifyModal").style.display = "none";
            };
        </script>


        <!-- ----------------------------------------------------- -->
        <div class="carousel">

            <div class="banner slide1">
                <div class="banner-txt">
                    <h1 class="banner-title">We Provide Effective Legal Solutions</h1>
                    <p class="banner-description">
                        There are many variations of passages of Lorem Ipsum available, but the majority have suffered
                        alteration in some form.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Necessitatibus tempore explicabo, ullam
                        animi dolore molestias repellat, temporibus magni veritatis architecto quae laboriosam, vitae ea
                        placeat fuga asperiores consectetur obcaecati expedita!
                    </p>
                </div>
            </div>

            <div class="banner slide2">
                <div class="banner-txt">
                    <h1 class="banner-title">Trusted Legal Advisors</h1>
                    <p class="banner-description">
                        Get expert guidance from our experienced attorneys to solve your legal problems quickly and
                        effectively.
                    </p>
                </div>
            </div>

            <div class="banner slide3">
                <div class="banner-txt">
                    <h1 class="banner-title">Your Justice, Our Commitment</h1>
                    <p class="banner-description">
                        We fight for your rights and provide the best legal representation in all types of cases.
                    </p>
                </div>
            </div>

        </div>



        <!-- ------------------------------------------------- -->
    </header>

    <main>

        <section class="all-laws">
            <div class="laws-txt">
                <h1 class="l-title">The Legal Practice Area</h1>
                <p class="l-description">There are many variations of passages of Lorem Ipsum available, but the
                    majority have <br>suffered alteration in some form, by injected humour.</p>
            </div>

            <div class="laws-container">
                <div class="business-law">
                    <img src="images/business.png" alt="" class="b-img">
                    <h1 class="b-title">Business Law</h1>
                    <p class="b-description">There are many variations of passages of Lorem Ipsum available, but the
                        majority have suffered alteration in some form, by injected humour. Lorem ipsum dolor sit amet
                        consectetur adipisicing elit. Assumenda labore temporibus, eum cum voluptatem molestiae eaque
                        reprehenderit ducimus praesentium sapiente?</p>
                    <a class="b-button" href=""><i class="fa-solid fa-circle-arrow-right"></i></a>
                </div>
                <div class="business-law">
                    <img src="images/criminal.png" alt="" class="b-img">
                    <h1 class="b-title">Criminal Law Law</h1>
                    <p class="b-description">There are many variations of passages of Lorem Ipsum available, but the
                        majority have suffered alteration in some form, by injected humour. Lorem ipsum dolor sit amet
                        consectetur adipisicing elit. Assumenda labore temporibus, eum cum voluptatem molestiae eaque
                        reprehenderit ducimus praesentium sapiente?</p>
                    <a class="b-button" href=""><i class="fa-solid fa-circle-arrow-right"></i></a>
                </div>
                <div class="business-law">
                    <img src="images/child.png" alt="" class="b-img">
                    <h1 class="b-title">Child Law</h1>
                    <p class="b-description">There are many variations of passages of Lorem Ipsum available, but the
                        majority have suffered alteration in some form, by injected humour. Lorem ipsum dolor sit amet
                        consectetur adipisicing elit. Assumenda labore temporibus, eum cum voluptatem molestiae eaque
                        reprehenderit ducimus praesentium sapiente?</p>
                    <a class="b-button" href=""><i class="fa-solid fa-circle-arrow-right"></i></a>
                </div>
                <div class="business-law">
                    <img src="images/education.png" alt="" class="b-img">
                    <h1 class="b-title">Education Law</h1>
                    <p class="b-description">There are many variations of passages of Lorem Ipsum available, but the
                        majority have suffered alteration in some form, by injected humour. Lorem ipsum dolor sit amet
                        consectetur adipisicing elit. Assumenda labore temporibus, eum cum voluptatem molestiae eaque
                        reprehenderit ducimus praesentium sapiente?</p>
                    <a class="b-button" href=""><i class="fa-solid fa-circle-arrow-right"></i></a>
                </div>
                <div class="business-law">
                    <img src="images/divorce.png" alt="" class="b-img">
                    <h1 class="b-title">divorce Law</h1>
                    <p class="b-description">There are many variations of passages of Lorem Ipsum available, but the
                        majority have suffered alteration in some form, by injected humour. Lorem ipsum dolor sit amet
                        consectetur adipisicing elit. Assumenda labore temporibus, eum cum voluptatem molestiae eaque
                        reprehenderit ducimus praesentium sapiente?</p>
                    <a class="b-button" href=""><i class="fa-solid fa-circle-arrow-right"></i></a>
                </div>
                <div class="business-law">
                    <img src="images/tax.png" alt="" class="b-img">
                    <h1 class="b-title">Tax Law</h1>
                    <p class="b-description">There are many variations of passages of Lorem Ipsum available, but the
                        majority have suffered alteration in some form, by injected humour. Lorem ipsum dolor sit amet
                        consectetur adipisicing elit. Assumenda labore temporibus, eum cum voluptatem molestiae eaque
                        reprehenderit ducimus praesentium sapiente?</p>
                    <a class="b-button" href=""><i class="fa-solid fa-circle-arrow-right"></i></a>
                </div>
            </div>

        </section>
        <!-- ------------------------------------------------------------ -->
        <section class="client display-sizing">
            <div class="client-txt">
                <h1 class="client-title">What Our Client Say</h1>
                <p class="client-description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Placeat sapiente
                    asperiores eius!</p>
            </div>

            <div class="client-carousel">
                <div class="client-slide c-1"></div>
                <div class="client-slide c-2"></div>
                <div class="client-slide c-3"></div>
            </div>

        </section>
        <!-- -------------------------------------------------------------------------------------------- -->
        <section class="question">
            <h1 class="q-title">Frequently Asked Any Questions</h1>
            <p class="q-description">There are many variations of passages of Lorem Ipsum available, but the majority
                have suffered alteration in some form, by injected humour.</p>
        </section>

        <section class="q-scenario">
            <div class="q-txt">
                <div class="one another-one">
                    <h2 class="q-all">1. Are application fee waivers available?</h2>
                    <p class="q-des">There are many variations of passages of Lorem Ipsum available, but the majority
                        have suffered alteration in some form, by injected humour, . </p>

                </div>
                <div class="one">
                    <h2 class="q-all">2. Are application fee waivers available?</h2>
                </div>
                <div class="one">
                    <h2 class="q-all">3. Are application fee waivers available?</h2>
                </div>
                <div class="one">
                    <h2 class="q-all">4. Are application fee waivers available?</h2>
                </div>
            </div>

            <div class="q-img">
                <img src="images/faq.png" alt="">
            </div>
        </section>

        <!-- <section class="question">
            <h1 class="q-title">Contact With Us</h1>
            <p class="q-description">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour.</p>
        </section>


        <section class="contact">
            <div class="contact-cards">
                <div class="contact-card">
                    <img src="images/address.png" alt="">
                    <h3 class="contact-title">Address</h3>
                    <p class="contact-des">A108 Adam Street,<br>New York, NY 535022</p> 
                </div>
                <div class="contact-card">
                    <img src="images/call.png" alt="">
                    <h3 class="contact-title">Call us</h3>
                    <p class="contact-des">A108 Adam Street,<br>New York, NY 535022</p> 
                </div>
                <div class="contact-card">
                    <img src="images/email.png" alt="">
                    <h3 class="contact-title">Email us</h3>
                    <p class="contact-des">A108 Adam Street,<br>New York, NY 535022</p> 
                </div>
                <div class="contact-card">
                    <img src="images/time.png" alt="">
                    <h3 class="contact-title">Working Hour</h3>
                    <p class="contact-des">A108 Adam Street,<br>New York, NY 535022</p> 
                </div>
            </div>

            <div class="contact-fields">
                <input class="text-area" type="text" name="" id="" placeholder="name"><br><br>
                <input class="text-area" type="email" name="" id="" placeholder="email"><br><br>
                <input class="text-area" type="text" name="" id="" placeholder="subject"><br><br>
                <textarea class="area-txt" name="" id="" placeholder="your message"></textarea><br><br>
                <input class="btn-primary anoter-btn" type="submit" value="Send Message">
            </div>
        </section> -->

    </main>

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

    <!-- <script>
        // Select buttons
        const lawyerBtn = document.querySelector('.lawyer-btn');
        const clientBtn = document.querySelector('.btn-primary');

        // Open new window when Lawyer button clicked
        lawyerBtn.addEventListener('click', () => {
            window.open('Lawer.html');
        });

        // Open new window when Client button clicked
        clientBtn.addEventListener('click', () => {
            window.open('Client-Login.html');
        });

    </script> -->


    <script>
document.getElementById("notifyBtn").onclick = function() {
  document.getElementById("notifyModal").style.display = "flex";

  // 🔹 Mark appointments as seen when modal opens
  fetch("mark_seen.php", { method: "POST" })
    .then(res => res.text())
    .then(data => {
      const badge = document.querySelector(".notify-badge");
      if (badge) badge.remove(); // remove badge after viewing
    });
};

// Close modal
document.querySelector(".closeNotify").onclick = function() {
  document.getElementById("notifyModal").style.display = "none";
};
</script>


</body>

</html>