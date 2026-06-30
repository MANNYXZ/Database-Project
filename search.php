<?php
session_start();
include "dbConnect.php";

if(!isset($_SESSION["username"])){
    header("Location: login.html");
    exit();
}

$category = trim($_POST["category"]);

if(empty($category)){
    die("Please enter a category.");
}

$stmt = mysqli_prepare(
    $conn,
    "SELECT * FROM items WHERE category LIKE ?"
);

$searchCategory = "%" . $category . "%";

mysqli_stmt_bind_param($stmt, "s", $searchCategory);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Search Results</title>
</head>

<body style="text-align: center;">

    <h1>Search Results</h1>

    <table border="1" style="margin-left: auto; margin-right: auto;">
        <tr>
            <th>Item ID</th>
            <th>Posted By</th>
            <th>Title</th>
            <th>Description</th>
            <th>Category</th>
            <th>Price</th>
            <th>Review</th>
        </tr>

        <?php
        while($row = mysqli_fetch_assoc($result)){
            echo "<tr>";
            echo "<td>" . $row["itemID"] . "</td>";
            echo "<td>" . $row["username"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["description"] . "</td>";
            echo "<td>" . $row["category"] . "</td>";
            echo "<td>$" . $row["price"] . "</td>";
            echo "<td><a href='review.php?itemID=" . $row["itemID"] . "'>Write Review</a></td>";
            echo "</tr>";
        }
        ?>

    </table>

    <br>

    <a href="search.html">
        <button type="button">Search Again</button>
    </a>

    <br><br>

    <a href="welcome.php">
        <button type="button">Back to Welcome</button>
    </a>

</body>

</html>