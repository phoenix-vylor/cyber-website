<?php
$name = $_POST['name'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$cybercrime = $_POST['cybercrime'];
$complaintagainst = $_POST['complaintagainst'];
$message = $_POST['message'];


if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === UPLOAD_ERR_OK) {
    $file_name = $_FILES['evidence']['name'];
    $file_tmp = $_FILES['evidence']['tmp_name'];
    $file_size = $_FILES['evidence']['size'];
    $file_type = $_FILES['evidence']['type'];

    
    $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'video/mp4', 'video/avi', 'video/quicktime'];
    if (!in_array($file_type, $allowed_types)) {
        die("Sorry, only JPG, JPEG, PNG, GIF, MP4, AVI, MOV files are allowed.");
    }

    
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true); 
    }
    $upload_path = $upload_dir . basename($file_name);

    if (move_uploaded_file($file_tmp, $upload_path)) {
        
        $conn = new mysqli('localhost', 'root', '', 'project');
        if ($conn->connect_error) {
            die('Connection Failed: ' . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("INSERT INTO complaint (name, email, gender, contact, address, cybercrime, complaintagainst, evidence, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", $name, $email, $gender, $contact, $address, $cybercrime, $complaintagainst, $upload_path, $message);
            if ($stmt->execute()) {
                echo "Submitted successfully...";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
            $conn->close();
        }
    } else {
        die("Sorry, there was an error uploading your file.");
    }
} else {
    die("No file uploaded or file upload error occurred.");
}
?>
