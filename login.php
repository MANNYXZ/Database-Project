
<?php
include "dbConnect.php";

$username = trim($_POST["userName"]);
$password = $_POST["password"];

if(empty($username) || empty($password)){
    die("Please fill in all fields");
}

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");

mysqli_stmt_bind_param($stmt, "s", $username);

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if($user && password_verify($password, $user["password"])) {
    header("location: welcome.html");
    exit();
}
else{
    echo "Incorrect username or password";
}


?>
