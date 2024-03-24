<?php
session_start();

if(empty($_SESSION["uid"])){
    header("Location: login.php");
}

include 'connectionDB.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $community_name = $_POST['name'];
    $description = $_POST['description'];
    $query = "INSERT INTO communities (name, description) VALUES ('$community_name', '$description')";
    $result = mysqli_query($conn, $query);
    header("Location: home.php");
    mysqli_close($conn);
}
?>
// Here you can add HTML to format the output
// You can also add CSS for styling
// If needed, you can add JavaScript for interactivity
