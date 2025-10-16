<?php
// Database connection
$servername = "localhost";
$username = "root"; // default in XAMPP
$password = "";     // default is empty in XAMPP
$dbname = "college_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data safely
$name     = $_POST['name'];          // fixed
$email    = $_POST['email'];         // fixed
$phone    = $_POST['phone'];
$gender   = $_POST['gender'];
$dob      = $_POST['dob'];
$course   = $_POST['course'];        // fixed
$pass     = $_POST['user_password']; // fixed (matches DB column)

// Handle file upload
$targetDir = "uploads/";
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;

if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
    // Insert into database
    $sql = "INSERT INTO admissions (name, email, phone, gender, dob, course, file_path, user_password)
            VALUES ('$name', '$email', '$phone', '$gender', '$dob', '$course', '$targetFilePath', '$pass')";
 
    
    if ($conn->query($sql) === TRUE) {
        echo "Form submitted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "File upload failed.";
}

$conn->close();
?>
