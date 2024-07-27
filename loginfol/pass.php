<?php
$email = $_POST["email"];
$password = $_POST["password"];
$con = new mysqli("localhost", "root", "", "test");
if ($con->connect_error) {
    die("Failed to connect: " . $con->connect_error);
} else {
    $stmt = $con->prepare("SELECT * FROM registration WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if ($stmt_result->num_rows > 0) {
        $data = $stmt_result->fetch_assoc();
        if ($data['password'] === $password) { 
            echo "<script>
                    window.location.href = 'cyber.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Invalid Email or Password');
                    window.location.href = 'login.html';
                  </script>";
        }
    } 
}
?>


