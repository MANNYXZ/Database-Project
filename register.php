<?php

include "dbConnect.php";
$username = $_POST["username"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmpassword"];
$firstName = $_POST["firstname"];
$lastName = $_POST["lastname"];
$email = $_POST["email"];
$phoneNumber = $_POST["phonenumber"];


if(empty($username)||
   empty($password)||
   empty($confirmPassword)||
   empty($firstName)||
   empty($lastName)||
   empty($email)||
   empty($phoneNumber)){
    die("Please fill in all fields");
}


if($password !== $confirmPassword){
    die("Passwords do not match");
}

$check = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ? OR email = ? OR phoneNumber = ?");
mysqli_stmt_bind_param($check, "sss", $username, $email, $phoneNumber);
mysqli_stmt_execute($check);
$result = mysqli_stmt_get_result($check);


if(mysqli_num_rows($result)>0){
    die("username, email, or phone number already exists");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$insert = mysqli_prepare($conn, "INSERT INTO users (username, password, firstname, lastName, email, phoneNumber) VALUES(?, ?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($insert, "ssssss", $username, $hashedPassword, $firstName, $lastName, $email, $phoneNumber);
mysqli_stmt_execute($insert);

header("Location: login.html");
exit();

?>