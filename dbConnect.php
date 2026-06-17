
<?php
$host = "localhost";
$db = "user-login";
$username = "root";
$password = "OGmany69!";//replace with your own


try{
    $conn = mysqli_connect(
        $host,
        $username,
        $password,
        $db
    );

}

catch(mysqli_sql_exception $e){
    echo $e->getMessage();
}


if($conn){
    echo "you are connected";
}

?>