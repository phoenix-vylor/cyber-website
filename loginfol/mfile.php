<?php
// MySQL database configuration
$servername = "localhost";  // Replace with your server name
$username = "root";         // Replace with your MySQL username
$password = "";             // Replace with your MySQL password
$dbname = "test";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if file is a actual file or fake file
if(isset($_POST["submit"])) {
    $check = filesize($_FILES["fileToUpload"]["mfile"]);
    if($check !== false) {
        echo "File is valid - " . $check . " bytes.<br>";
        $uploadOk = 1;
    } else {
        echo "File is not valid.<br>";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br>";
    $uploadOk = 0;
}

// Check file size (limit to 50MB)
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "Sorry, your file is too large.<br>";
    $uploadOk = 0;
}

// Allow certain file formats
$allowedTypes = array("exe", "apk");
if(!in_array($fileType, $allowedTypes)) {
    echo "Sorry, only EXE & APK files are allowed.<br>";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " has been uploaded.<br>";
        
        // Insert file upload information into database
        $file_name = basename($_FILES["fileToUpload"]["name"]);
        $file_size = $_FILES["fileToUpload"]["size"];
        
        $sql = "INSERT INTO uploads (file_name, file_type, file_size) VALUES ('$file_name', '$fileType', '$file_size')";
        
        if ($conn->query($sql) === TRUE) {
            echo "File upload information recorded in database.<br>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.<br>";
    }
}

// Close MySQL connection
$conn->close();
?>
