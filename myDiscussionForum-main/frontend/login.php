<?php
session_start();
require 'connectDB.php';
if(!empty($_SESSION["uid"])){
    header("Location: index.php");
}
if(isset($_POST["submit"])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if($user){
        if(password_verify($password, $user['password'])){
            $_SESSION["username"] = $user['username'];
            $_SESSION["uid"]= $user["uid"];
            header("Location: index.php");
            exit();
        }else{
            echo "<script>alert('Incorrect Password, Please try again!');</script>";
        }
    }else{
        echo "<script>alert('Sorry, user is not registered');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel = "stylesheet" href = "css/login.css">
    <link rel = "stylesheet" href = "css/style.css">

    
    <title>Login</title>
</head>
<body>
<a href= "index.php" class = "button">index</a>
<section id="login">
        <h1>Login</h1>

<form name = "loginForm" action = "" method = "POST" autocomplete = "off">
    <input type="text" id="username" name="username" placeholder="Username" required><br>
    <input type="password" id="password" name="password" placeholder="Password" required><br>
    
    <a href="resetPassword.php">Forgot Password?</a>
    
    <button class = "button" type="submit" name="submit">Log in</button>

</form>

     <p>New to the Forum? <a href="createAccount.php">Sign Up</a></p>
    </section>

   

</body>
<footer>
    <p class = "tos">Terms of Service</p>
    <p class = "tos">About</p>
    <p class = "tos">Contact Us</p>
    <p class = "tos">FAQ</p>
    <p class = "tos">Privacy and Policy</p>
</footer>
</html>