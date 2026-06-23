<?php
session_start();

if(isset($_POST["Logout"])){
    session_destroy();
    header("Location: login.html");
    exit();
}
if(!isset($_SESSION["username"])){
    (header("Location: login.html"));
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Welcome</title>
</head>

<body style="text-align: center;">

    <h1>Login Successful!</h1>

    <p>Welcome,<?php echo $_SESSION["username"];?>.</p>

    <a href = "postItem.html">
        <button type = "button"> Post Item </button>
    </a>

    <br><br>

    <form method="post">
        <button type = "submit" name = "Logout"> Log out </button>
    </form>

</body>

</html>





