<?php
session_start();
include "dbConnect.php";

if(!isset($_SESSION["username"])){
    header("Location: login.html");
    exit();
}

$username = $_SESSION["username"];

if(!isset($_GET["itemID"])){
    die("no item selected");
}

$itemID = $_GET["itemID"];

$itemQuery = mysqli_prepare($conn, "SELECT * FROM items WHERE itemID = ?");
mysqli_stmt_bind_param($itemQuery, "i", $itemID);
mysqli_stmt_execute($itemQuery);

$itemResult = mysqli_stmt_get_result($itemQuery);
$item = mysqli_fetch_assoc($itemResult);

if(!$item){
    die("item not found");
}

if($item["username"] == $username){
    die("you cannot review your own item");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $rating = $_POST["rating"];
    $description = trim($_POST["description"]);
    if(empty($rating)||empty($description)){
        die("Please fill in all fields");
    }


$dailyCheck = mysqli_prepare(
    $conn,
    "SELECT COUNT(*) AS reviewCount FROM reviews 
    WHERE username = ? AND reviewDate = CURDATE()"
);

mysqli_stmt_bind_param($dailyCheck, "s", $username);
mysqli_stmt_execute($dailyCheck);

$dailyResult = mysqli_stmt_get_result($dailyCheck);
$dailyRow = mysqli_fetch_assoc($dailyResult);

if($dailyRow["reviewCount"] >= 2){
    die("you can only review two items per day");
}

$reviewCheck = mysqli_prepare(
    $conn,
    "SELECT * FROM reviews WHERE username = ? AND itemID = ?"
);

mysqli_stmt_bind_param($reviewCheck, "si", $username, $itemID);
mysqli_stmt_execute($reviewCheck);
$reviewResult = mysqli_stmt_get_result($reviewCheck);


if(mysqli_num_rows($reviewResult) > 0){
    die("you already reviewed this item");
}

$insertReview = mysqli_prepare(
    $conn,
    "INSERT INTO reviews(itemID, username, rating, description, reviewDate)
    VALUES(?, ?, ?, ?, CURDATE())"
);

mysqli_stmt_bind_param(
    $insertReview,
    "isss",
    $itemID, 
    $username,
    $rating,
    $description

);

mysqli_stmt_execute($insertReview);

echo "review has been posted";
echo "<br><br>";
echo "<a href='search.html'>Back to Search</a>";
echo "<br>";
echo "<a href='welcome.php'>Back to Welcome Page</a>";
exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Review Item</title>
</head>
<body style = "text-align: center;">
    <h1>write a review</h1>
    <h3> <?php echo $item["title"];?></h3>
    <p>  <?php echo $item["description"];?></p>
    <p> Category: <?php echo $item["category"];?></p>
    <p> Price: $<?php echo $item["price"];?></p>

    <form action = "review.php?itemID=<?php echo $itemID;?>" method = "post">
        <label> Rating: </label>
        <select name = "rating" required>
            <option value = "" > choose a rating </option>
            <option value = "excellent"> Excellent </option>
            <option value = "good"> Good </option>
            <option value = "fair"> Fair </option>
            <option value = "poor"> Poor </option>
            </select>
            <br><br>
            <label> Description: </label>
            <br>
            <textarea name = "description" rows = "5" cols = "40" required></textarea>
            <br><br>
            <button type = "submit"> Submit Review </button>
            </form>
            <br> 

            <a href = "search.html">
                <button type = "button"> Back to Search </button>
                </a>

</body>
</html>

