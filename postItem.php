<?php
session_start();
include "dbConnect.php";

if(!isset($_SESSION["username"])){
    header("location: login.php");
    exit();
}

$username = $_SESSION["username"];
$title = trim($_POST["title"]);
$description = trim($_POST["description"]);
$category = trim($_POST["category"]);
$price = $_POST["price"];

if(empty($title) || empty($description) || empty($category) || empty($price)){
    die("Please fill in all required fields.");
}

$check = mysqli_prepare($conn, "SELECT COUNT(*) AS itemCount FROM 
items WHERE username = ? AND postDate = CURDATE()");

mysqli_stmt_bind_param($check, "s", $username);
mysqli_stmt_execute($check);

$result = mysqli_stmt_get_result($check);
$row = mysqli_fetch_assoc($result);

if($row["itemCount"] >= 2){
    die("You can only post a maximum of 2 items per day.");
}

$insert = mysqli_prepare(
    $conn,
    "INSERT INTO items (username, title, description, category, price, postDate)
    VALUES (?, ?, ?, ?, ?, CURDATE())"
);

mysqli_stmt_bind_param(
    $insert,
    "ssssd",
    $username,
    $title,
    $description,
    $category,
    $price
);

mysqli_stmt_execute($insert);
echo "item has been posted";
echo "<a href='welcome.php'>Back to Welcome Page</a>";
?>













?>