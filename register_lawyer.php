<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $service = $_POST['service'];
    $institute = $_POST['institute'];
    $degree = $_POST['degree'];
    $grad_year = $_POST['grad_year'];
    $cases = $_POST['cases'];

    // 🔹 Handle Image Upload
    $target_dir = "uploads/"; // Make sure this folder exists
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $image_name = time() . "_" . basename($_FILES["profile_image"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
        // Save file name to database
        $sql = "INSERT INTO lawyers (name, description, service, institute, degree, grad_year, cases, profile_image, status) 
                VALUES ('$name', '$description', '$service', '$institute', '$degree', '$grad_year', '$cases', '$image_name', 'pending')";

        if ($conn->query($sql) === TRUE) {
            echo "Lawyer registered successfully!";
            header("Location: LawyerCard.php");
            exit();
        } else {
            echo "Database error: " . $conn->error;
        }
    } else {
        echo "Error uploading image!";
    }
}
?>
