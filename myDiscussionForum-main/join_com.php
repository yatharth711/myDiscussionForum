<?php
session_start();
if(empty($_SESSION["uid"])){
    header("Location: login.php");
}

if(isset($_SESSION["uid"])){

include_once 'connectionDB.php';

// Get the user ID from the current session
$uid = $_SESSION['uid'];

// Get the community ID from the submitted form data
$com_id = $_POST['com_id'];

$query = "SELECT * FROM user_communities WHERE uid = '$uid' AND com_id = '$com_id'";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result) == 0){
    // Insert a new row into the user_communities table

    $query = "INSERT INTO user_communities (uid, com_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $uid, $com_id);
    $result = mysqli_stmt_execute($stmt);
    
}

// Close the database connection
mysqli_close($conn);

header("Location: home.php");
}
?>