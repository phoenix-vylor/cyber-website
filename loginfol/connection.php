<?php
$fullname =$_POST['fullname'];
$username =$_POST['username'];
$email =$_POST['email'];
$number =$_POST['number'];
$password =$_POST['password'];
$confirm  =$_POST['confirm'];
$gender =$_POST['gender'];
 
 $conn = new mysqli('localhost','root','','test');
 if($conn->connect_error){
    die('Connection Failed :' .$conn->connect_error);
 }else{
    $stmt =$conn->prepare("insert into registration (fullname ,username ,number ,gender , email ,password ,confirm)
    values(?,?,?,?,?,?,?)");
    $stmt->bind_param("ssissss",$fullname,$username,$number,$gender,$email,$password,$confirm);
    $stmt->execute();
    echo "registration sucessfully...";
    $stmt->close();
    $conn->close();

          
 }
?>